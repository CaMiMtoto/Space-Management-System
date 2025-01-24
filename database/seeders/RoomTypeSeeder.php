<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ["Office", "Classroom", "Residence", "Storage", "Meeting Room", "Conference Room",
            "Auditorium", "Lecture Hall", "Laboratory", "Workshop", "Studio", "Library", "Gymnasium",
            "Cafeteria", "Kitchen", "Restroom", "Lobby", "Lounge", "Reception", "Waiting Room",
            "Corridor", "Staircase", "Elevator", "Balcony", "Terrace"];
        if (RoomType::query()->doesntExist()) {
            foreach ($types as $type) {
                RoomType::query()->create([
                    'name' => $type,
                    'slug' => Str::slug($type),
                    'description' => "This is a $type."
                ]);
            }
        }
    }
}
