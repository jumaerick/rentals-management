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
        Schema::create('users_metadata', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('domain_experience_id')->nullable();
            $table->integer('skill_level_id')->nullable();
            $table->integer('learnin_goal_id')->nullable();
            $table->integer('interest_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_metadata');
    }
};
