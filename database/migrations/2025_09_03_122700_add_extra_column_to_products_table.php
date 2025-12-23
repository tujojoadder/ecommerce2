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
        Schema::table('products', function (Blueprint $table) {
            $table->text('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->string('item_code')->nullable();
            $table->string('condition')->default('New');
            $table->decimal('main_price', 15,2)->default(0);
            $table->longText('information')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('guarantee')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('subcategory_id')->nullable();
            $table->integer('subsubcategory_id')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_seo')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_tag')->nullable();
            $table->decimal('shipping_in_dhaka', 15, 2)->default(0);
            $table->decimal('shipping_out_dhaka', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
