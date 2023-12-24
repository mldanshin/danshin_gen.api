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
            $table->foreignId('user_id')
                ->references('id')
                ->on('people_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text("code")->unique();
            $table->unique(['user_id']);
            $table->bigInteger("time");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers_codes');
    }
};
