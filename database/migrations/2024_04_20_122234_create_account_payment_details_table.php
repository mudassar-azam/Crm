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
        Schema::create('account_payment_details', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('IBAN')->nullable();
            $table->string('bank_branch_code')->nullable();
            $table->string('BIC_or_Swift_code')->nullable();
            $table->string('bank_city_name')->nullable();
            $table->string('sort_code')->nullable(); 
            $table->string('bank_address')->nullable();
            $table->string('country')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('transferwise_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_payment_details');
    }
};
