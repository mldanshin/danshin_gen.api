<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("people_users_roles", function (Blueprint $table) {
            $table->id();
            $table->string("slug");
            $table->unique(['slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("people_users_roles");
    }
};
