<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use App\Models\Booking;
use App\Models\RoomType;
use App\Services\BookingFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class BookingReportController extends Controller
{
    protected BookingFilterService $bookingFilterService;

    public function __construct(BookingFilterService $bookingFilterService)
    {
        $this->bookingFilterService = $bookingFilterService;
    }

    /**
     * @throws \Exception
     */
    public function index()
    {
        $lastWeek = Carbon::now()->subWeek();
        $startDate = \request('start_date', $lastWeek->format('Y-m-d'));
        $endDate = \request('end_date', date('Y-m-d'));
        if (request()->ajax()) {
            // Collect filters from the request
            $filters = [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'room_type' => \request()->input('room_type'),
                'status' => \request()->input('status')
            ];

            // Use the BookingFilterService to apply filters
            $data = $this->bookingFilterService->filterBookings($filters);
            return \DataTables::of($data)->make(true);
        }
        $roomTypes = RoomType::query()->get();
        return view('reports.booking', compact('roomTypes', 'startDate', 'endDate'));
    }


    // Method to export data to Excel

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportToExcel(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'room_type' => $request->input('room_type'),
            'status' => $request->input('status')
        ];


        return (new BookingsExport($filters,$this->bookingFilterService))->download('bookings.xlsx', Excel::XLSX);
    }
}
