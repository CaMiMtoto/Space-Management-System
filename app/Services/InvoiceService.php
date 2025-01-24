<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Support\Str;

class InvoiceService
{
    public function createInvoice(Booking $booking)
    {
        $invoiceNumber = 'INV-' . Str::upper(Str::random(10));

        $roomCost = $booking->room->rate; // Assuming room has a 'rate' field
        $servicesCost = $booking->services->sum('pivot.total_price'); // Sum of all additional services

        $totalAmount = $roomCost + $servicesCost;

        $invoice = Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => $invoiceNumber,
            'total_amount' => $totalAmount,
            'remaining_amount'=> $totalAmount,
        ]);

        return $invoice;
    }
}
