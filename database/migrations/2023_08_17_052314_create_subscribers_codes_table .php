<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text("code")->unique();
            $table->unique(['client_id']);
            $table->bigInteger("time");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers_codes');
    }
};
