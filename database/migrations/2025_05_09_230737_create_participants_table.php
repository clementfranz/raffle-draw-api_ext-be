<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('full_name');
            $table->bigInteger('id_entry');
            $table->string('raffle_code')->unique();
            $table->string('regional_location')->nullable();

            // Timestamps
            $table->timestamp('registered_at');
            $table->timestamp('uploaded_at')->useCurrent();

            // Draw Info
            $table->boolean('is_drawn')->default(false);
            $table->timestamp('drawn_at')->nullable();

            // Batch Link
            $table->foreignId('participant_batch_id')
                    ->default(1)
                    ->constrained('participant_batches')
                    ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
