<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clockify_users', function (Blueprint $table) {
            $table->id();
            $table->string('clockify_user_id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clockify_users');
    }
};
