<?php

use App\Constants\Status;
use App\Models\Booking;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Booking::class)->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->dateTime('invoice_date');
            $table->decimal('total_amount', 18, 2)->default(0);
            $table->decimal('remaining_amount', 18, 2)->default(0); // The balance remaining after payments
            $table->string('status')->default(Status::Pending);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
