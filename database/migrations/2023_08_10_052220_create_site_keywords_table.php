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
        Schema::create('site_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->comment('Keyword must be set with underscore');
            $table->string('arabic')->nullable();
            $table->string('bangla')->nullable();
            $table->string('english')->nullable();
            $table->string('hindi')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_keywords');
    }
};
