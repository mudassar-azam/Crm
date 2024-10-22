<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('duration');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status');
            $table->string('comment');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};

