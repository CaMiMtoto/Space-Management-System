<?php

use App\Models\MaintenanceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::table('room_maintenances', function (Blueprint $table) {
            $table->dropColumn('maintenance_type');
            $table->foreignIdFor(MaintenanceType::class)->after('room_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_types');
        Schema::table('room_maintenances', function (Blueprint $table) {
            $table->string('maintenance_type')->after('room_id');
            $table->dropConstrainedForeignIdFor(MaintenanceType::class);
        });
    }
};
