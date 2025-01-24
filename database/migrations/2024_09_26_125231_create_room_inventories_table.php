<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Room::class)->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->integer('quantity')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(\App\Constants\Status::Available);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_inventories');
    }
};
