<?php

use Illuminate\Support\Facades\Route;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilityResourceTable extends Migration
{
    public function up()
    {
        Schema::create('availability_resource', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resources')->onDelete('cascade');
            $table->foreignId('availability_id')->constrained('availabilities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('availability_resource');
    }
}
