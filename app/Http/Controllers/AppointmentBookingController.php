<?php

namespace App\Http\Controllers;

use App\Constants\Permission;
use App\Constants\Status;
use App\Http\Requests\ValidateAppointmentRequest;
use App\Jobs\SendAppointmentBookingEmailJob;
use App\Jobs\SendEmailJob;
use App\Models\AppointmentBooking;
use App\Models\EmailLink;
use App\Models\Guest;
use App\Models\User;
use App\Notifications\AppointmentReviewedNotification;
use App\Notifications\NewAppointmentNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class AppointmentBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index()
    {
        if (\request()->ajax()) {
            $data = AppointmentBooking::query();
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('appointments.show', encodeId($row->id)) . '" class="edit btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('bookings.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(ValidateAppointmentRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        DB::beginTransaction();

        $startTime = $data['start_time'];
        $endTime = $data['end_time'];
        $data['start_date_time'] = $data['start_date_time'] . ' ' . $startTime . ':00:00';
        $data['end_date_time'] = $data['end_date_time'] . ' ' . $endTime . ':00:00';
        $data['start_time'] = $startTime . ' ' . $startTime . ':00';
        $data['end_time'] = $endTime . ' ' . $endTime . ':00';
        $model = AppointmentBooking::query()->create($data);
        $model->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => 'Appointment booked.',
            'is_comment' => false,
            'status' => Status::Pending,
        ]);
        SendAppointmentBookingEmailJob::dispatch($model);
        // notify all users who have permissions to view appointment about new appointment
        $this->notifyAllUsersForAppointments($model);

        DB::commit();
        if ($request->ajax()) {
            session()->flash('success', 'Appointment Booked Successfully.');
            return response()->json([
                'message' => 'Appointment Booked Successfully.',
                'redirect' => route('appointments.create')
            ]);
        }

        return redirect()
            ->back()->with('success', 'Appointment Booked Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AppointmentBooking $appointmentBooking)
    {
        return view('bookings.appointments.show', compact('appointmentBooking'));
    }


    /**
     * @throws Throwable
     */
    public function review(Request $request, AppointmentBooking $booking)
    {
        $data = $request->validate([
            'status' => ['required'],
            'description' => ['required'],
            'contact_person_name' => ['required_if:status,approved'],
            'contact_person_email' => ['required_if:status,approved'],
            'contact_person_phone' => ['required_if:status,approved'],
        ]);
        DB::beginTransaction();
        $booking->update([
            'status' => $data['status'],
            'reviewed_at' => now(),
            'reviewed_by_id' => auth()->id(),
            'contact_person_name' => $data['contact_person_name'] ?? null,
            'contact_person_email' => $data['contact_person_email'] ?? null,
            'contact_person_phone' => $data['contact_person_phone'] ?? null,
        ]);

        // save flow
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => $data['description'],
            'is_comment' => true,
            'status' => $data['status'],
        ]);


        $guest = new Guest($booking->name, $booking->email, $booking->phone);
        $guest->notify(new AppointmentReviewedNotification($booking, route('appointments.show', encodeId($booking->id))));


        DB::commit();

        if (\request()->ajax()) {
            session()->flash('success', 'Booking reviewed successfully.');
            return response()->json(['message' => 'Booking reviewed successfully.']);
        }
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Booking reviewed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppointmentBooking $appointmentBooking)
    {
        $appointmentBooking->delete();
        return redirect()->back()->with('success', 'Appointment Deleted Successfully');
    }

    /**
     * @param AppointmentBooking $booking
     * @return string
     */
    public function buildMessage(AppointmentBooking $booking): string
    {
        if (strtolower($booking->status) == strtolower(Status::Rejected)) {
            return "Hello! " . $booking->name . ",\n\n" .
                "Your appointment has been reviewed. Unfortunately, your appointment has been rejected.\n\n" .
                "If you have any questions, please contact us.\n\n" .
                "Thank you!";
        }

        return "Hello! " . $booking->name . ",\n\n" .
            "Your appointment has been reviewed. Please check the details below:\n\n" .
            "Date: " . $booking->date->format('d/m/Y') . "\n\n" .
            "Contact Person: " . $booking->contact_person_name . "\n\n" .
            "Contact Number: " . $booking->contact_person_phone . "\n\n" .
            "Contact Email: " . $booking->contact_person_email . "\n\n" .
            "Thank you!";
    }

    /**
     * @param Model|AppointmentBooking $model
     * @return void
     */
    public function notifyAllUsersForAppointments(Model|AppointmentBooking $model): void
    {
        $users = User::query()->whereHas('permissions', function ($query) {
            $query->whereIn('name', [Permission::ReviewBookingAppointments]);
        })->get();
        foreach ($users as $user) {
            $user->notify(new NewAppointmentNotification($model));
        }
    }


}
