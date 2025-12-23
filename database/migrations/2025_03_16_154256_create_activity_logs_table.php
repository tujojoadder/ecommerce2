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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('model'); // User, Post, Comment, etc.
            $table->unsignedBigInteger('row_id');
            $table->string('activity'); // login, logout, create, update, delete
            $table->text('description')->nullable();
            $table->decimal('old_amount', 8, 2)->nullable();
            $table->decimal('new_amount', 8, 2)->nullable();
            $table->timestamp('logged_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
