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
        Schema::create('asset_and_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type')->nullable();
            $table->string('date')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('unit')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->integer('account')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('chart_of_account_id')->nullable();
            $table->unsignedBigInteger('chart_of_account_group_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('id_no')->nullable();
            $table->longText('description')->nullable();
            $table->string('type')->nullable();

            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_and_stocks');
    }
};
