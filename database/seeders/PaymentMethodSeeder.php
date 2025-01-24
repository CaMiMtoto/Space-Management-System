<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Cash',
            'Credit Card',
            'Debit Card',
            'PayPal',
            'Bank Transfer',
            'Mobile Money',
            'Cheque',
            'Other',
        ];

        foreach ($names as $name) {
            PaymentMethod::query()
                ->updateOrCreate(['name' => $name], ['name' => $name, 'code' => strtoupper(substr($name, 0, 3))]);
        }
    }
}
