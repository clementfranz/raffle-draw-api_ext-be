<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('winner_participants', function (Blueprint $table) {
            $table->id();

            // Nullable FK to participant
            $table->foreignId('participant_id')
                  ->nullable()
                  ->constrained('participants')
                  ->nullOnDelete();

            // Keep old participant id
            $table->unsignedBigInteger('old_participant_id')->nullable();

            // Copy participant data
            $table->string('full_name_raw');
            $table->string('full_name_cleaned');
            $table->bigInteger('id_entry');
            $table->string('raffle_code')->unique();
            $table->string('regional_location')->nullable();

            $table->timestamp('registered_at')->nullable();
            $table->timestamp('uploaded_at')->nullable();

            $table->boolean('is_drawn')->default(true);
            $table->timestamp('drawn_at')->nullable();

            // Batch Link
            $table->foreignId('participant_batch_id')
                    ->constrained('participant_batches')
                    ->cascadeOnDelete();

            // ✅ Winner Specific Fields
            $table->boolean('has_won')->default(true);
            $table->timestamp('won_at')->useCurrent();

            $table->string('winner_type')->nullable();

            $table->boolean('is_cancelled')->default(false);
            $table->timestamp('cancelled_at')->nullable();

            $table->boolean('is_proclaimed')->default(false);
            $table->timestamp('proclaimed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('winner_participants');
    }
};
