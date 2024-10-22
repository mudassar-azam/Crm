<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('location');
            $table->text('email_body'); 
            $table->string('subject'); 
            $table->string('express'); 
            $table->text('email_note')->nullable(); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('emails');
    }
};
