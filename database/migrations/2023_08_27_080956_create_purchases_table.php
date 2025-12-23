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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->timestamp('issued_date')->nullable();

            $table->decimal('discount', 15, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('transport_fare', 15, 2)->nullable();
            $table->string('vat_type')->nullable();
            $table->decimal('vat', 15, 2)->nullable();

            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

            $table->decimal('receive_amount', 15, 2)->nullable();

            $table->decimal('purchase_bill', 15, 2)->nullable()->default(0);
            $table->decimal('total_vat', 15, 2)->nullable()->default(0);
            $table->decimal('total_discount', 15, 2)->nullable()->default(0);
            $table->decimal('grand_total', 15, 2)->nullable()->default(0);
            $table->decimal('total_due', 15, 2)->nullable()->default(0);

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
