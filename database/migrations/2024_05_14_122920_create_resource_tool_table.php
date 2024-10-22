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
        Schema::create('resource_tool', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('tool_id');
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->foreign('tool_id')->references('id')->on('tools')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_tool');
    }
};
