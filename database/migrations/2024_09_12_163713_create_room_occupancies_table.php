<?php

use App\Models\OccupancyType;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_occupancies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OccupancyType::class)->constrained();
            $table->foreignIdFor(Room::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('purpose')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_occupancies');
    }
};
