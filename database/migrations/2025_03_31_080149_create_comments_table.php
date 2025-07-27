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
        Schema::Create('comments', function (Blueprint $table) {
            //
            $table->id();
            $table->string('course_id')->nullable();
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');  // user_id as foreign key, assuming the users table exists
            $table->text('message')->nullable();
            $table->timestamps();  // created_at and updated_at
        });

        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained()->onDelete('cascade');  // Foreign key to comments table
            $table->foreignId('parent_reply_id')->nullable()->constrained('replies')->onDelete('cascade');  // For replies to replies
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key to users table
            $table->string('course_id')->nullable();
            $table->text('message');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments'); 
        Schema::dropIfExists('replies');
    }
};
