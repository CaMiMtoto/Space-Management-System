<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\ValidateStoreBookingRequest;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Notifications\BookingAutoApprovedNotification;
use App\Notifications\BookingCancelledNotification;
use App\Notifications\BookingCreatedNotification;
use App\Notifications\BookingReviewNotification;
use App\Services\InvoiceService;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Throwable;
use Yajra\DataTables\Exceptions\Exception;

class BookingController extends Controller
{


    /**
     * Display a listing of the resource.
     * @throws Exception
     * @throws \Exception
     */
    public function index()
    {
        $userId = \request('user_id', auth()->id());
        if (\request()->ajax()) {
            $data = Booking::query()
                ->when(\request('type') != 'all', function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->when(\request('status'), function (Builder $query) {
                    $query->where('status', \request('status'));
                })
                ->with('room.roomType', 'room.building', 'user', 'room.maintenances')
                ->select('bookings.*');
            return datatables()->eloquent($data)
                ->addColumn('action', function (Booking $booking) {
                    return view('bookings.action', compact('booking'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('bookings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $roomTypes = RoomType::all();
        $times = [];
        for ($i = 0; $i < 24; $i++) {
            $times[] = $i;
        }
        return view('bookings.create', compact('roomTypes', 'times'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(ValidateStoreBookingRequest $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        unset($data['room_type_id']);
        $data['user_id'] = auth()->id();
        $data['is_guest_booking'] = isset($data['is_guest_booking']) ? 1 : 0;
        $data['status'] = Status::Pending;

        // Convert the check-in and check-out dates and times to Unix timestamps
        // Combine check-in date and time into one date

        $data['start_date'] = $data['check_in_date'] . ' ' . $data['check_in_time'] . ':00:00';
        $data['end_date'] = $data['check_out_date'] . ' ' . $data['check_out_time'] . ':00:00';
        $checkIn = strtotime($data['start_date']);
        $checkOut = strtotime($data['end_date']);

        // Calculate the difference between check-out and check-in times (in seconds)
        $durationInSeconds = $checkOut - $checkIn;

        // If the booking duration is 24 hours (86400 seconds) or less, automatically approve the booking
        if ($durationInSeconds <= 86400) {
            $data['status'] = Status::Approved;
        }


        DB::beginTransaction();


        $booking = Booking::query()->create($data);
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => 'Booking created.',
            'is_comment' => false,
            'status' => $data['status']
        ]);
        // for guest booking , send email to guest
        $bookingUrl = route('admin.bookings.show', encodeId($booking->id));
        if ($booking->is_guest_booking) {
            $user = $this->makeGuestUser($booking);
            $user->notify(new BookingCreatedNotification($booking, $bookingUrl));
        }
        DB::commit();
        if ($booking->status == Status::Approved) {

            $user = User::find($booking->user_id);
            if ($booking->is_guest_booking) {
                $user = $this->makeGuestUser($booking);
            }
            // notify the user that booking is approved
            $user->notify(new BookingAutoApprovedNotification($booking, $bookingUrl));
        }

        $message = 'Booking created successfully.';

        if ($request->ajax()) {
            session()->flash('success', $message);
            return response()->json([
                'message' => $message,
                'redirect' => route('admin.bookings.index', ['type' => 'all'])
            ]);
        }
        return redirect()->route('admin.bookings.index', ['type' => 'all'])
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $booking->load(['room.roomType', 'room.building', 'user', 'flow' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        return view('bookings.show', compact('booking'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        if (\request()->ajax()) {
            return response()->json(['message' => 'Booking deleted successfully.']);
        }
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    /**
     * @throws Throwable
     */
    public function cancelBooking(Booking $booking)
    {
        $data = \request()->validate([
            'reason' => ['required', 'string', 'max:500']
        ]);

        // Update booking status to 'canceled'
        DB::beginTransaction();
        $booking->status = Status::Cancelled;
        $booking->save();

        // save flow
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => $data['reason'],
            'is_comment' => false,
            'status' => Status::Cancelled,
        ]);

        $user = User::find($booking->user_id);
        if ($booking->is_guest_booking) {
            $user = $this->makeGuestUser($booking);
        }
        $user->notify(new BookingCancelledNotification($booking, $data['reason']));
        DB::commit();

        if (\request()->ajax()) {
            return response()->json(['message' => 'Booking canceled successfully.']);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking canceled successfully.');
    }

    public function checkout(Booking $booking)
    {
        // Update booking status to 'completed'
        $booking->status = Status::Completed;
        $booking->save();

        if (\request()->ajax()) {
            return response()->json(['message' => 'Booking checked out successfully.']);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking checked out successfully.');
    }

    /**
     * @throws Throwable
     */
    public function review(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => ['required'],
            'description' => ['required'],
        ]);
        DB::beginTransaction();
        $booking->update([
            'status' => $data['status'],
            'reviewed_at' => now(),
            'reviewed_by_id' => auth()->id(),
        ]);

        // save flow
        $booking->flow()->create([
            'done_by_id' => auth()->id(),
            'description' => $data['description'],
            'is_comment' => true,
            'status' => $data['status'],
        ]);

        // if booking is for guest, notify the guest email
        if ($booking->is_guest_booking) {
            $user = $this->makeGuestUser($booking);
        } else {
            $user = User::find($booking->user_id);
        }
        $user->notify(new BookingReviewNotification($booking, route('admin.bookings.show', encodeId($booking->id))));
        if ($data['status'] == Status::Approved) {
            // Generate invoice after booking approval
            $invoiceService = new InvoiceService();
            $invoiceService->createInvoice($booking);
        }

        DB::commit();

        if (\request()->ajax()) {
            session()->flash('success', 'Booking reviewed successfully.');
            return response()->json(['message' => 'Booking reviewed successfully.']);
        }
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking reviewed successfully.');
    }

    public function searchBooking()
    {
        return view('search-booking');
    }


    public function makeGuestUser(Booking $booking)
    {
        return new Guest($booking->guest_name, $booking->guest_email, $booking->guest_phone);
    }


}
