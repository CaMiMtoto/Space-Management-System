<?php

namespace Database\Factories;

use App\Constants\Status;
use App\Models\Building;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {

        return [
            'name' => $this->faker->name(),
            'floor' => $this->faker->randomNumber(),
            'room_number' => "RM" . $this->faker->randomNumber(),
            'capacity' => $this->faker->randomNumber(),
            'status' => Arr::random(Status::roomStatuses(), 1)[0],
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'room_type_id' => RoomType::query()->inRandomOrder()->first()->id,
            'building_id' => Building::factory(),
        ];
    }
}
