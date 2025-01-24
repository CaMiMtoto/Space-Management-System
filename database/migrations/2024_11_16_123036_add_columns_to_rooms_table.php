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
        Schema::table('room_types', function (Blueprint $table) {
            $table->boolean('is_vip')->default(false);
            $table->unsignedInteger('max_booking_days')->nullable();
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->unsignedInteger('check_in_time')->nullable();
            $table->unsignedInteger('check_out_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->dropColumn('is_vip');
            $table->dropColumn('max_booking_days');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('check_in_date');
            $table->dropColumn('check_out_date');
            $table->dropColumn('check_in_time');
            $table->dropColumn('check_out_time');
        });
    }
};
