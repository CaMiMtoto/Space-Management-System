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
        Schema::table('room_maintenances', function (Blueprint $table) {
            $table->dropColumn('maintenance_date');
            $table->dateTime('start_date')->after('room_id');
            $table->dateTime('end_date')->nullable()->after('start_date');
            $table->string('status')->default('pending')->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_maintenances', function (Blueprint $table) {
            //
        });
    }
};
