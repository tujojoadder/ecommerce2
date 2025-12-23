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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('buying_price', 15, 2)->nullable();
            $table->decimal('selling_price', 15, 2)->nullable();
            $table->decimal('wholesale_price', 15, 2)->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->decimal('opening_stock', 15, 2)->nullable();
            $table->string('carton')->nullable();
            $table->string('group_id')->nullable();
            $table->integer('stock_warning')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('size_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->string('custom_barcode_no')->nullable();
            $table->string('imei_no')->nullable();

            $table->decimal('buy_quantity', 8, 2)->nullable();
            $table->decimal('sale_quantity', 8, 2)->nullable();
            $table->decimal('return_quantity', 8, 2)->nullable();
            $table->decimal('in_stock', 8, 2)->nullable();

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
        Schema::dropIfExists('products');
    }
};
