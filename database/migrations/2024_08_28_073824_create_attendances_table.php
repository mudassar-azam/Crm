<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date'); 
            $table->string('in'); 
            $table->string('in2')->nullable(); 
            $table->string('out')->nullable();
            $table->string('out2')->nullable(); 
            $table->string('worked_hours')->nullable(); 
            $table->string('break')->nullable(); 
            $table->string('arrived_early')->nullable(); 
            $table->string('arrived_late')->nullable(); 
            $table->string('left_late')->nullable(); 
            $table->string('left_early')->nullable(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
