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
        Schema::create('participant_batches', function (Blueprint $table) {
            $table->id();
            $table->string('raffle_week_code'); // Add raffle_week_code column

            $table->json('regional_stats')->nullable();

            $table->timestamp('date_start')->nullable(); // Add date_start column
            $table->timestamp('date_end')->nullable(); // Add date_end column
            $table->timestamp('raffle_date_time_started')->nullable(); // Add raffle_date_time_started column
            $table->timestamp('raffle_date_time_ended')->nullable(); // Add raffle_date_time_ended column
            $table->boolean('is_completed')->default(false); // Add is_completed column
            $table->unsignedBigInteger('drawn_by_user_id')->nullable(); // Add drawn_by_user_id column

            $table->timestamps();

            // Create indexes
            $table->index('raffle_week_code');
            $table->index('date_start');
            $table->index('date_end');
            $table->index('raffle_date_time_started');
            $table->index('raffle_date_time_ended');
            $table->index('is_completed');
            $table->index('drawn_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_batches');
    }
};
