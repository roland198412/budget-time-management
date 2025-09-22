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
            $table->string('payment_type')->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clockify_user_payments', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
};
