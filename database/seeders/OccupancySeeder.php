<?php

namespace Database\Seeders;

use App\Models\OccupancyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use function Termwind\parse;

class OccupancySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Accommodation', 'Working Station', 'Storage'
        ];

        $descriptions = [
            'This is a place where people can live, stay, or sleep.',
            'This is a place where people can work, study, or do business.',
            'This is a place where things can be kept or stored.'
        ];

        if (OccupancyType::query()->doesntExist()) {
            foreach ($names as $index => $name) {
                OccupancyType::query()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $descriptions[$index]
                ]);
            }
            $this->command->info(parse('<info>Occupancy types seeded successfully.</info>'));
        }


    }
}
