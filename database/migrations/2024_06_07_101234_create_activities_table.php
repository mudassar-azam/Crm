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

            Schema::create('activities', function (Blueprint $table) {
                $table->id();
                $table->string('ticket_detail');
                $table->string('email_screenshot')->nullable();
                $table->datetime('activity_start_date');
                $table->text('location');
                $table->text('activity_description');
                $table->string('customer_service_type');
                $table->string('customer_rates');
                $table->string('tech_service_type');
                $table->string('tech_rates');
                $table->datetime('pakistani_time')->nullable();
                $table->datetime('default_time')->nullable();
                $table->string('remark')->nullable();
                $table->string('po_number')->nullable();
                $table->string('total_customer_payments')->nullable();
                $table->string('duration_cust')->nullable();
                $table->string('start_date_time')->nullable();
                $table->string('end_date_time')->nullable();
                $table->string('time_difference')->nullable();
                $table->string('activity_status')->default('pending');
                $table->string('assign_to_user_id')->nullable();
                $table->string('assign_remarks')->nullable();
                $table->string('total_tech_payments')->nullable();
                $table->string('duration')->nullable();
                $table->string('sign_of_sheet')->nullable();
                $table->unsignedBigInteger('resource_id')->nullable();
                $table->unsignedBigInteger('client_id')->nullable();
                $table->unsignedBigInteger('tech_country_id')->nullable(); 
                $table->string('tech_city')->nullable();
                $table->unsignedBigInteger('project_id')->nullable();      
                $table->string('other_project_name')->nullable();
                $table->unsignedBigInteger('customer_currency_id')->nullable();      
                $table->unsignedBigInteger('tech_currency_id')->nullable();      
                $table->string('tech_invoice')->nullable();
                $table->string('customer_invoice')->nullable();
                $table->string('tech_invoice_payment_status')->nullable();
                $table->string('customer_invoice_payment_status')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('confirmed_by')->nullable();
                $table->string('confirmed_at')->nullable();
                $table->string('completed_by')->nullable();
                $table->string('approved_by')->nullable();
                $table->boolean('ff')->default(false);
                $table->boolean('job')->default(false);
                $table->boolean('reached')->default(false);
                $table->boolean('update_client')->default(false);
                $table->boolean('inform_client')->default(false);
                $table->boolean('sign_of_sheet_received')->default(false);
                $table->boolean('ff_working')->default(false);
                $table->boolean('activity_completed')->default(false);
                $table->boolean('ff_need_time')->default(false);
                $table->boolean('svr_shared')->default(false);

                $table->timestamps();

                $table->foreign('resource_id')->references('id')->on('resources')->onDelete('set null');
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('tech_country_id')->references('id')->on('countries')->onDelete('set null');
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
                $table->foreign('customer_currency_id')->references('id')->on('currencies')->onDelete('set null');
                $table->foreign('tech_currency_id')->references('id')->on('currencies')->onDelete('set null');
            });
    }
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
