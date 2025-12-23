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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->timestamp('issued_date')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('purchased_id')->nullable();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('stock', 15, 2)->nullable();
            $table->decimal('buying_price', 15, 2)->nullable();
            $table->decimal('selling_price', 15, 2)->nullable();
            $table->string('selling_type')->nullable();
            $table->decimal('wholesale_price', 15, 2)->nullable();
            $table->decimal('quantity', 15, 2)->nullable();
            $table->string('return_type')->nullable();
            $table->decimal('return_quantity', 15, 2)->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->decimal('total', 15, 2)->nullable();

            $table->string('deleted_by')->nullable();
            $table->string('created_by');
            $table->string('prepared_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
};
