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
        Schema::create('clockify_user_payment_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clockify_user_payment_id')
                ->constrained('clockify_user_payments')
                ->onDelete('cascade')
                ->name('payment_project_payment_fk');
            $table->foreignId('project_id')
                ->constrained('projects')
                ->onDelete('cascade')
                ->name('payment_project_project_fk');
            $table->timestamps();
            
            // Ensure unique combination
            $table->unique(['clockify_user_payment_id', 'project_id'], 'payment_project_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clockify_user_payment_project');
    }
};
