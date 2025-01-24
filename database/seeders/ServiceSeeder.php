<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomServices = [
            ['name' => 'Wi-Fi', 'fee' => 0],
            ['name' => 'Air Conditioning', 'fee' => 0],
            ['name' => 'Heating', 'fee' => 0],
            ['name' => 'Private Bathroom', 'fee' => 0],
            ['name' => 'Laundry', 'fee' => 0],
            ['name' => 'Parking', 'fee' => 0],
            ['name' => 'Security', 'fee' => 0],
            ['name' => 'Cleaning', 'fee' => 0],
            ['name' => 'Breakfast', 'fee' => 0],
            ['name' => 'Drying', 'fee' => 0],
            ['name' => 'Washing', 'fee' => 0],
            ['name' => 'Housekeeping', 'fee' => 0],
            ['name' => 'Gym', 'fee' => 0],
            ['name' => 'Swimming Pool', 'fee' => 0],
        ];
        foreach ($roomServices as $roomService) {
            Service::query()
                ->updateOrCreate(['name' => $roomService['name']], $roomService);
        }
    }
}
