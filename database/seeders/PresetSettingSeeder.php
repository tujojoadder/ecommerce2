<?php

namespace Database\Seeders;

use App\Models\PresetSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresetSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PresetSetting::create([
            'client_id' => '',
            'supplier_id' => '',
            'client_group_id' => '',
            'supplier_group_id' => '',
            'expense_category_id' => '',
            'receive_category_id' => '',
            'account_id' => '',
            'created_at' => now(),
        ]);
    }
}
