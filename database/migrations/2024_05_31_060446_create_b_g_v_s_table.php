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
        Schema::create('b_g_v_s', function (Blueprint $table) {
            $table->id();
            $table->string('file_name'); // Adding file_name column
            $table->unsignedBigInteger('resource_id'); // Adding resource_id column
            $table->timestamps();
            // Assuming 'resources' is the name of the table you're referencing
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_g_v_s');
    }
};
