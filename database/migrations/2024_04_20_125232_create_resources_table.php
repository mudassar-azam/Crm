<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_no')->nullable();
            $table->string('group_link')->nullable();
            $table->string('email')->unique();
            $table->string('region')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('certification')->nullable();
            $table->boolean('worked_with_us')->default(false);
            $table->string('whatsapp')->nullable();
            $table->string('linked_in')->nullable();
            $table->string('tools_catagory')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('language')->nullable();
            $table->string('latitude', 211)->nullable();
            $table->string('longitude', 211)->nullable();
            $table->text('address')->nullable();
            $table->string('work_status')->nullable();
            $table->text('resume')->nullable();
            $table->string('visa')->nullable();
            $table->string('license')->nullable();
            $table->string('passport')->nullable();
            $table->decimal('daily_rate', 8, 2)->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->string('weekly_rates')->nullable();
            $table->string('monthly_rates')->nullable();
            $table->string('rate_currency')->nullable();
            $table->decimal('half_day_rates', 8, 2)->nullable();
            $table->text('rate_snap')->nullable();
            $table->string('created_by')->nullable();
            $table->unsignedBigInteger('account_payment_details_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('account_payment_details_id')->references('id')->on('account_payment_details')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
