<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointment_bookings', function (Blueprint $table) {
            $table->integer('guests')->default(0)->unsigned();
            $table->string('organization')->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->time('start_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->time('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_bookings', function (Blueprint $table) {
            $table->dropColumn('guests');
            $table->dropColumn('organization');
            $table->dropColumn('start_date_time');
            $table->dropColumn('end_date_time');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
};
