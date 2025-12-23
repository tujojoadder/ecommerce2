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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('id_no')->nullable();
            $table->string('client_name')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('transport')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_optional')->nullable();

            $table->decimal('previous_due', 10, 2)->nullable();
            $table->decimal('sales', 10, 2)->nullable();
            $table->decimal('sales_return', 10, 2)->nullable();
            $table->decimal('receive', 10, 2)->nullable();
            $table->decimal('money_return', 10, 2)->nullable();
            $table->decimal('sales_return_adjustment', 10, 2)->nullable();
            $table->decimal('adjustment', 10, 2)->nullable();
            $table->decimal('due', 10, 2)->nullable();

            $table->decimal('max_due_limit', 10, 2)->nullable()->default(0);
            $table->string('email')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('upazilla_thana')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('street_road')->nullable();
            $table->string('reference')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->integer('type')->nullable()->default(0);
            $table->timestamp('remaining_due_date')->nullable();

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
        Schema::dropIfExists('clients');
    }
};
