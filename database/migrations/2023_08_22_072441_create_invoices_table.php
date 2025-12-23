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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamp('issued_date')->nullable();
            $table->string('issued_time')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->unsignedBigInteger('total_return')->nullable();
            $table->decimal('transport_fare', 15, 2)->nullable();
            $table->decimal('labour_cost', 15, 2)->nullable();
            $table->unsignedBigInteger('account_id')->nullable();

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_issued_date')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->decimal('receive_amount', 15, 2)->nullable();
            $table->decimal('cash_receive', 15, 2)->nullable();
            $table->decimal('change_amount', 15, 2)->nullable();
            $table->decimal('bill_amount', 15, 2)->nullable();
            $table->decimal('due_amount', 15, 2)->nullable();
            $table->decimal('highest_due', 15, 2)->nullable();
            $table->string('vat_type')->nullable();
            $table->decimal('vat', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->longText('warranty')->nullable();
            $table->string('track_number')->nullable();

            $table->decimal('total_discount', 15, 2)->nullable()->default(0);
            $table->decimal('invoice_bill', 15, 2)->nullable()->default(0);
            $table->decimal('previous_due', 15, 2)->nullable()->default(0);
            $table->decimal('due_before_return', 15, 2)->nullable()->default(0);
            $table->decimal('total_vat', 15, 2)->nullable()->default(0);
            $table->decimal('grand_total', 15, 2)->nullable()->default(0);
            $table->decimal('total_due', 15, 2)->nullable()->default(0);
            $table->decimal('adjusting_amount', 15, 2)->nullable()->default(0);

            $table->string('send_sms')->nullable();
            $table->string('send_email')->nullable();

            $table->string('created_by');
            $table->string('prepared_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('status')->nullable()->default(0);

            $table->decimal('total_shipping_charge', 15, 2)->nullable()->default(0);
            $table->integer('order_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
