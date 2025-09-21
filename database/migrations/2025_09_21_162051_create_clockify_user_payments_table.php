<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clockify_user_payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount_ex_vat');
            $table->float('vat_amount');
            $table->date('payment_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clockify_user_payments');
    }
};
