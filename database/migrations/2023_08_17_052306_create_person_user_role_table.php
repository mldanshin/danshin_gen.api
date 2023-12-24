<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("person_user_role", function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('role_id', false, true);
            $table->foreign('role_id')
                ->references('id')
                ->on('people_users_roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['person_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("person_user_role");
    }
};
