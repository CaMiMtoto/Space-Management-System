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
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('guests')->unsigned()->nullable();
            $table->boolean('is_guest_booking')->default(false);
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('status')->default(\App\Constants\Status::Pending)->change();
            $table->foreignIdFor(\App\Models\User::class, 'reviewed_by_id')->nullable()->constrained('users');
            $table->dateTime('reviewed_at')->nullable();
            $table->string('approval_type')->default('manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('guests');
            $table->dropColumn('is_guest_booking');
            $table->dropColumn('guest_name');
            $table->dropColumn('guest_email');
            $table->dropColumn('guest_phone');
            $table->dropConstrainedForeignId('reviewed_by_id');
            $table->dropColumn('reviewed_at');
            $table->dropColumn('approval_type');
        });
    }
};
