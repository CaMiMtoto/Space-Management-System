<?php

namespace App\Exports;

use App\Services\BookingFilterService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements WithMapping, FromQuery, WithColumnFormatting, ShouldAutoSize, WithStyles, WithHeadings,WithEvents
{
    use Exportable;


    protected array $filters;
    protected BookingFilterService $bookingFilterService;

    public function __construct(array $filters, BookingFilterService $bookingFilterService)
    {
        $this->filters = $filters;
        $this->bookingFilterService = $bookingFilterService;
    }


    /**
     * Define the headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Booked At',
            'Check In',
            'Check Out',
            'Booking Code',
            'Room Type',
            'Room Number',
            'Building',
            '# Guests',
            'Guest Name',
            'Guest Phone',
            'Guest Email',
            'Status'
        ];
    }

    public function map($row): array
    {
        return [
            $row->created_at->format('Y-m-d H:i:s'),
            $row->start_date->format('Y-m-d H:i:s'),
            $row->end_date->format('Y-m-d H:i:s'),
            $row->booking_code,
            $row->room->roomType->name,
            $row->room->room_number,
            $row->room->building->name,
            $row->guests,
            $row->guest_name,
            $row->guest_phone,
            $row->guest_email,
            $row->status
        ];
    }

    public function query(): Relation|\Illuminate\Database\Eloquent\Builder|\Laravel\Scout\Builder|Builder
    {
        return $this->bookingFilterService->filterBookings($this->filters);
    }

    public function columnFormats(): array
    {
        return [
            'A' => 'yyyy-mm-dd hh:mm:ss',
            'B' => 'yyyy-mm-dd hh:mm:ss',
            'C' => 'yyyy-mm-dd hh:mm:ss',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // color to be white
        return [
            1 => ['font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF']
            ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '187BA5'],

                ],

            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // Apply filters to only 'Room Type' (E1) and 'Status' (L1) columns
                $sheet->setAutoFilter('E1:E1'); // Filter only 'Room Type' column (E)
                $sheet->setAutoFilter('L1:L1'); // Filter only 'Status' column (L
                // Optionally, adjust column widths for better readability
                $sheet->getColumnDimension('A')->setWidth(20); // Booked At column
                $sheet->getColumnDimension('B')->setWidth(25); // Check In column
                $sheet->getColumnDimension('C')->setWidth(25); // Check Out column
                $sheet->getColumnDimension('D')->setWidth(20); // Booking Code column
                $sheet->getColumnDimension('E')->setWidth(25); // Room Type column
                $sheet->getColumnDimension('F')->setWidth(15); // Room Number column
                $sheet->getColumnDimension('G')->setWidth(20); // Building column
                $sheet->getColumnDimension('H')->setWidth(12); // # Guests column
                $sheet->getColumnDimension('I')->setWidth(25); // Guest Name column
                $sheet->getColumnDimension('J')->setWidth(20); // Guest Phone column
                $sheet->getColumnDimension('K')->setWidth(30); // Guest Email column
                $sheet->getColumnDimension('L')->setWidth(15); // Status column

            },
        ];
    }
}
