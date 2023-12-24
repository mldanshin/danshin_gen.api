<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('telegram_id');
            $table->string('telegram_username')->nullable();
            $table->timestamps();
            $table->unique('telegram_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram');
    }
};
