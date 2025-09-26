<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('channel');
            $table->string('subject');
            $table->string('content');
            $table->string('available_placeholders')->default('{subject}, {content}, {name}');
            $table->foreignIdFor(Client::class)->constrained('clients');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
