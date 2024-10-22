<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('email')->unique(); 
            $table->string('check_in')->nullable(); 
            $table->string('check_out')->nullable(); 
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('role_type')->nullable();
            $table->string('password');
            $table->integer('vacation')->default(18)->nullable();
            $table->integer('sick_leave')->default(6)->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
