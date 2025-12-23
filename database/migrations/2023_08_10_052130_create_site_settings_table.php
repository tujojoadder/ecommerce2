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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('sale_price_percentage', 15, 2)->nullable()->default(0);
            $table->string('language')->nullable()->default('en');
            $table->string('menu_size')->nullable()->default('large');
            $table->integer('page_length')->default('10');
            $table->string('receive_sms')->nullable()->default("Dear {client_name}, Thank you for the payment of {receive_amount} TKDue : {due_amount} for {description}{company_name} HELPLINE: {company_mobile}");
            $table->string('invoice_sms')->nullable()->default("Dear {client_name}, Thank you for purchase our products total bill of {total_bill} TK Payment: {total_payment} and Due : {invoice_due} Total Due : {client_total_due} {company_name} HELPLINE: {company_mobile}");

            $table->decimal('today_sales', 15, 2)->nullable()->default(0);
            $table->decimal('today_deposit', 15, 2)->nullable()->default(0);
            $table->decimal('today_cost', 15, 2)->nullable()->default(0);
            $table->decimal('today_due', 15, 2)->nullable()->default(0);
            $table->decimal('today_balance', 15, 2)->nullable()->default(0);

            $table->decimal('monthly_sales', 15, 2)->nullable()->default(0);
            $table->decimal('monthly_deposit', 15, 2)->nullable()->default(0);
            $table->decimal('monthly_cost', 15, 2)->nullable()->default(0);
            $table->decimal('monthly_due', 15, 2)->nullable()->default(0);
            $table->decimal('monthly_balance', 15, 2)->nullable()->default(0);

            $table->decimal('total_balance', 15, 2)->nullable()->default(0);
            $table->decimal('total_purchase', 15, 2)->nullable()->default(0);
            $table->decimal('total_sales', 15, 2)->nullable()->default(0);
            $table->decimal('total_deposit', 15, 2)->nullable()->default(0);
            $table->decimal('total_cost', 15, 2)->nullable()->default(0);
            $table->decimal('total_return', 15, 2)->nullable()->default(0);
            $table->decimal('total_due', 15, 2)->nullable()->default(0);
            $table->decimal('total_client_due', 15, 2)->nullable()->default(0);
            $table->decimal('total_client_advance', 15, 2)->nullable()->default(0);
            $table->decimal('total_previous_due', 15, 2)->nullable()->default(0);
            $table->decimal('total_stock_value', 15, 2)->nullable()->default(0);

            $table->integer('partial_api')->default(0);
            $table->string('api_key')->nullable();
            $table->string('api_url')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('google_drive_folder_id')->nullable();
            $table->string('package')->default('basic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};