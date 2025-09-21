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
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->string('clockify_time_entry_id')->unique();
            $table->text('description')->nullable();
            $table->string('clockify_user_id');
            $table->timestamp('time_interval_start');
            $table->timestamp('time_interval_end');
            $table->integer('duration'); // duration in seconds
            $table->boolean('billable')->default(false);
            $table->string('clockify_project_id');
            $table->string('clockify_task_id')->nullable();
            $table->json('tag_ids')->nullable();
            $table->string('approval_request_id')->nullable();
            $table->string('type')->default('REGULAR');
            $table->boolean('is_locked')->default(false);
            $table->string('currency', 3)->default('USD');
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('earned_amount', 15, 2)->nullable();
            $table->decimal('earned_rate', 15, 2)->nullable();
            $table->decimal('cost_amount', 15, 2)->nullable();
            $table->decimal('cost_rate', 15, 2)->nullable();
            $table->string('project_name')->nullable();
            $table->string('project_color')->nullable();
            $table->string('client_name')->nullable();
            $table->string('clockify_client_id')->nullable();
            $table->string('task_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('clockify_user_id');
            $table->index('clockify_project_id');
            $table->index('clockify_client_id');
            $table->index(['time_interval_start', 'time_interval_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
