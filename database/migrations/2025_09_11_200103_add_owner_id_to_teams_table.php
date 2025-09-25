<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // adiciona a coluna owner_id referenciando users.id
            $table->foreignId('owner_id')
                  ->after('name')
                  ->constrained('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // remove a FK e a coluna se rodar rollback
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });
    }
};
