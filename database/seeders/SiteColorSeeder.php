<?php

namespace Database\Seeders;

use App\Models\ColorSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ColorSetting::create([
            'layout_gradient_left' => '#f54266',
            'layout_gradient_right' => '#3858f9',
            'sidebar_bg_color_left' => '#ffffff',
            'sidebar_bg_color_right' => '#ffffff',
            'sidebar_menu_hover_color' => '#2c2f3fe6',
            'sidebar_text_color' => '#0d0d12',
            'card_border_color' => '#87ceeb',
            'card_header_color' => '#ffffff',
            'card_body_color' => '#ffffff',
            'card_text_color' => '#0d0d12',
            'label_color' => '#0d0d12',
            'input_bg_color' => '#ffffff',
            'input_color' => '#0d0d12',
            'table_header_bg_color' => '#e3e3e3',
            'table_header_text_color' => '#2c2f3f',
            'table_text_color' => '#2c2f3f',
            'table_border_color' => '#6e6e6e',
            'success_btn_color' => '#0ba360',
            'danger_btn_color' => '#f53c5b',
            'info_btn_color' => '#17a2b8',
            'warning_btn_color' => '#ffc107',
            'primary_btn_color' => '#3858f9',
            'secondary_btn_color' => '#7987a1',
            'dark_btn_color' => '#2c2f3fe6',

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
