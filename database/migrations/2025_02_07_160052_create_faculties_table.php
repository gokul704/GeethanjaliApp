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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('faculty_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('stream');
            $table->enum('designation', ['faculty', 'hod', 'dean', 'principal'])->default('faculty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
