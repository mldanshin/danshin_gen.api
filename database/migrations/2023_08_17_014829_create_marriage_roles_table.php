<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marriage_roles', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('slug');
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marriage_roles');
    }
};
