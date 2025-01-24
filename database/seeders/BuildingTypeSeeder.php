<?php

namespace Database\Seeders;

use App\Models\BuildingType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BuildingTypeSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Residential', 'Commercial', 'Industrial', 'Institutional', 'Recreational', 'Agricultural', 'Special Purpose'
        ];

        if (BuildingType::query()->doesntExist()) {
            foreach ($names as $name) {
                BuildingType::query()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => "This is a $name building."
                ]);
            }
        }


    }
}
