<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $payment_method_id
 * @property string $amount
 * @property string|null $payment_reference
 * @property string|null $payment_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment wherePaymentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoicePayment extends Model
{
    use HasFactory;
}
