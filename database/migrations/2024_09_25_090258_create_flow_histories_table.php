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
        Schema::create('flow_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id');
            $table->string('model_type');
            $table->string('status');
            $table->text('description');
            $table->boolean('is_comment')->default(false);
            $table->foreignIdFor(\App\Models\User::class, 'done_by_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_histories');
    }
};
