<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentStatus;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('clockify_user_payments', function (Blueprint $table) {
            $table->string('payment_status')->default(PaymentStatus::PAID->value);
        });
    }

    public function down(): void
    {
        Schema::table('clockify_user_payments', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });
    }
};
