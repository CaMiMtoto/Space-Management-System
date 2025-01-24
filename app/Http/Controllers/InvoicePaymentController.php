<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $invoice->remaining_amount,
            'payment_method_id' => 'required|exists:payment_methods',
            'payment_reference' => 'nullable|string',
            'payment_description' => 'nullable|string',
        ]);
        \DB::beginTransaction();
        // Create new payment record
        $payment = InvoicePayment::query()->create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_method_id' => $request->payment_method_id,
            'payment_reference' => $request->payment_reference,
            'payment_description' => $request->payment_description
        ]);

        // Update invoice's remaining amount and payment status
        $invoice->remaining_amount -= $request->amount;

        // Check if invoice is fully paid
        if ($invoice->remaining_amount <= 0) {
            $invoice->status = 'paid';
            $invoice->remaining_amount = 0;
        } else {
            $invoice->status = 'partial';
        }

        $invoice->save();
        \DB::commit();
        return redirect()
            ->route('invoices.show', $invoice->id)
            ->with('success', 'Payment successfully recorded.');
    }

}
