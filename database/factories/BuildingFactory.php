<?php

namespace Database\Factories;

use App\Constants\Status;
use App\Models\Building;
use App\Models\BuildingType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition(): array
    {

        return [
            'name' => $this->faker->buildingNumber(),
            'slug' => $this->faker->slug(),
            'floors' => $this->faker->randomNumber(),
            'rooms' => $this->faker->randomNumber(),
            'address' => $this->faker->address(),
            'intended_use' => $this->faker->word(),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(Status::BuildingStatuses()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'building_type_id' => BuildingType::query()->inRandomOrder()->first()->id,
        ];
    }
}
