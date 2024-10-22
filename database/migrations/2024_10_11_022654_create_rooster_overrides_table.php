<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rooster_overrides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rooster_id');
            $table->date('override_date');
            $table->enum('type', ['present', 'absent']);
            $table->timestamps();
    
            $table->foreign('rooster_id')->references('id')->on('roosters')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooster_overrides');
    }
};
