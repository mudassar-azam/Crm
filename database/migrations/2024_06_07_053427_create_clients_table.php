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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_hq')->nullable();
            $table->string('form_nda_coc_sow')->nullable();
            $table->string('worth')->nullable();
            $table->string('sport_areas')->nullable();
            $table->string('status')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
