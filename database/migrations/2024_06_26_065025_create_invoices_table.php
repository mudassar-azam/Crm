<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('paid_time')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ach_wire_routing')->nullable();
            $table->string('swift_bnic')->nullable();
            $table->string('account_number')->nullable();
            $table->string('iban')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('address_associated')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
