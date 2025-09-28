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
        Schema::table('users', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->text('about_me')->nullable();
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->string('preferred_foot')->nullable();
            $table->string('availability')->nullable();
            $table->string('profile_picture')->nullable();
            $table->integer('height')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->date('birthdate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'position',
                'about_me',
                'strengths',
                'weaknesses',
                'preferred_foot',
                'availability',
                'profile_picture',
                'height',
                'city',
                'state',
                'birthdate',
            ]);
        });
    }
};
