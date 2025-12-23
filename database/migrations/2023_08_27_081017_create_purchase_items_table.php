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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->timestamp('issued_date')->nullable();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('row_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable(); //new field
            $table->longText('description')->nullable();
            $table->decimal('selling_price', 15, 2)->nullable();
            $table->bigInteger('free')->nullable();
            $table->decimal('quantity', 15, 2)->nullable();
            $table->string('return_type')->nullable();
            $table->decimal('buying_price', 15, 2)->nullable();
            $table->decimal('total_buying_price', 15, 2)->nullable();
            $table->decimal('total_selling_price', 15, 2)->nullable();
            $table->decimal('wholesale_price', 15, 2)->nullable();
            $table->unsignedBigInteger('barcode_id')->nullable();
            $table->integer('status')->nullable()->default(0);

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
