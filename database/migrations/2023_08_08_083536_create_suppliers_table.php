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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_optional')->nullable();
            $table->string('email')->nullable();

            $table->decimal('previous_due', 10, 2)->nullable();
            $table->decimal('purchase', 10, 2)->nullable();
            $table->decimal('purchase_return', 10, 2)->nullable();
            $table->decimal('payment', 10, 2)->nullable();
            $table->decimal('receive', 10, 2)->nullable();
            $table->decimal('adjustment', 10, 2)->nullable();
            $table->decimal('due', 10, 2)->nullable();

            $table->string('address')->nullable();
            $table->string('city_state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('domain')->nullable();
            $table->text('bank_account')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('remaining_due_date')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

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
        Schema::dropIfExists('suppliers');
    }
};
