<?php

namespace Database\Seeders;

use App\Models\MaintenanceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Plumbing', 'Electrical', 'HVAC', 'Painting', 'Carpentry', 'Cleaning', 'Other'];
        if (MaintenanceType::query()->doesntExist()) {
            foreach ($names as $name) {
                MaintenanceType::query()->create(['name' => $name]);
            }
        }
    }
}
