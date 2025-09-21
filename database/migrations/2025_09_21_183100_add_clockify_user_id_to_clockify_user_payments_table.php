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
        Schema::table('clockify_user_payments', function (Blueprint $table) {
            $table->string('clockify_user_id')->after('id');
            $table->index('clockify_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clockify_user_payments', function (Blueprint $table) {
            $table->dropIndex(['clockify_user_id']);
            $table->dropColumn('clockify_user_id');
        });
    }
};
