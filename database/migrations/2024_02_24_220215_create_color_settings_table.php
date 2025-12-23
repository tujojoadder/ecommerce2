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
        Schema::create('color_settings', function (Blueprint $table) {
            $table->id();
            $table->string('layout_gradient_left')->nullable()->default('#f54266');
            $table->string('layout_gradient_right')->nullable()->default('#3858f9');
            $table->string('sidebar_bg_color_left')->nullable()->default('#ffffff');
            $table->string('sidebar_bg_color_right')->nullable()->default('#ffffff');
            $table->string('sidebar_menu_hover_color')->nullable()->default('#3858f9');
            $table->string('sidebar_text_color')->nullable()->default('#000000');
            $table->string('card_border_color')->nullable()->default('#87ceeb');
            $table->string('card_header_color')->nullable()->default('#ffffff');
            $table->string('card_body_color')->nullable()->default('#ffffff');
            $table->string('card_text_color')->nullable()->default('#000000');
            $table->string('label_color')->nullable()->default('#000000');
            $table->string('input_bg_color')->nullable()->default('#ffffff');
            $table->string('input_color')->nullable()->default('#000000');
            $table->string('table_header_bg_color')->nullable()->default('#919191');
            $table->string('table_header_text_color')->nullable()->default('#ffffff');
            $table->string('table_text_color')->nullable()->default('#000000');
            $table->string('table_border_color')->nullable()->default('#6e6e6e');

            $table->string('success_btn_color')->nullable()->default('#0ba360');
            $table->string('danger_btn_color')->nullable()->default('#f53c5b');
            $table->string('info_btn_color')->nullable()->default('#17a2b8');
            $table->string('warning_btn_color')->nullable()->default('#ffc107');
            $table->string('primary_btn_color')->nullable()->default('#3858f9');
            $table->string('secondary_btn_color')->nullable()->default('#7987a1');
            $table->string('dark_btn_color')->nullable()->default('#212022');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_settings');
    }
};
