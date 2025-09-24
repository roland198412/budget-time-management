<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('bucket_project');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('bucket_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bucket_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['bucket_id', 'project_id']);
        });
    }
};
