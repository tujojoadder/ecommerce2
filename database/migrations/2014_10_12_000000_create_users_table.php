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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();

            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('present_address')->nullable();
            $table->string('parmanent_address')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('nid')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('gender')->nullable();
            $table->string('edu_qualification')->nullable();
            $table->string('experience')->nullable();
            $table->string('staff_id')->nullable();
            $table->string('staff_type')->nullable();
            $table->integer('type')->default(0)->nullable()->comment('1 = Staff, 0 = User');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('office_zone')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('discharge_date')->nullable();
            $table->string('machine_id')->nullable();
            $table->string('description')->nullable();
            $table->string('marital_status')->nullable();
            $table->decimal('salary', 15, 2)->nullable();

            $table->string('show_password');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->tinyInteger('status')->default(0);

            $table->tinyInteger('menu')->default(1);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
