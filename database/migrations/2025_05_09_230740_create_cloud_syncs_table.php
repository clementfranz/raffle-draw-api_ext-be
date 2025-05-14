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
        Schema::create('cloud_syncs', function (Blueprint $table) {
            $table->id();

            // Core sync queue fields
            $table->string('api_url');
            $table->string('source');
            $table->string('destination');
            $table->string('type');
            $table->json('payload');
            $table->string('method_type');

            // Enhanced fields
            $table->string('status')->default('pending'); // e.g. pending, in-progress, completed, failed
            $table->integer('retry_count')->default(0);
            $table->text('error_message')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('reference_id')->nullable();
            $table->string('content_type')->nullable();
            $table->string('triggered_by')->nullable();
            $table->boolean('is_test')->default(false);
            $table->timestamp('next_retry_at')->nullable();
            $table->json('headers')->nullable();
            $table->json('response_body')->nullable();
            $table->integer('duration')->nullable(); // in milliseconds

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_syncs');
    }
};
