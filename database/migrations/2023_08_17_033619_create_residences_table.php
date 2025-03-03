<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('date')->nullable();
            $table->timestamps();
            $table->unique(['person_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residences');
    }
};
