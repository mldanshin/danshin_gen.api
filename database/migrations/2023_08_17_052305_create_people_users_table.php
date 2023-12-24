<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people_users', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('password', 255)->nullable(false);
            $table->string('remember_token', 100)->nullable(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people_users');
    }
};
