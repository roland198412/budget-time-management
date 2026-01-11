<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->string('template_type')->nullable()->after('identifier');
        });
    }

    public function down(): void
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->dropColumn('template_type');
        });
    }
};

