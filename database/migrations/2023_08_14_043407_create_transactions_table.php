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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('type')->index();
            $table->string('expense_type')->nullable()->index()->default('default');
            $table->string('transaction_type')->nullable()->index()->index();
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->unsignedBigInteger('transfer_id')->nullable()->index();
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->unsignedBigInteger('staff_id')->nullable()->index()->comment('For Staff Payment');
            $table->unsignedBigInteger('invoice_id')->nullable()->index();
            $table->unsignedBigInteger('purchase_id')->nullable()->index();
            $table->integer('month')->nullable()->index()->comment('For Staff Payment');
            $table->integer('year')->nullable()->index()->comment('For Staff Payment');
            $table->timestamp('date')->nullable()->index();
            $table->unsignedBigInteger('account_id');
            $table->longText('description')->nullable();
            $table->longText('reference')->nullable();
            $table->longText('tags')->nullable();

            $table->decimal('amount', 15, 2)->nullable()->index();
            $table->decimal('current_due', 15, 2)->nullable()->index();
            $table->decimal('current_balance', 15, 2)->nullable()->index();

            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('chart_account_id')->nullable();
            $table->unsignedBigInteger('chart_group_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('image')->nullable();
            $table->string('send_sms')->nullable();
            $table->string('send_email')->nullable();

            $table->string('created_by');
            $table->string('prepared_by')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
