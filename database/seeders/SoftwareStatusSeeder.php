<?php

namespace Database\Seeders;

use App\Models\SoftwareStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftwareStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoftwareStatus::insert(
            [
                [
                    'key' => 'a6d61f315c89fe61c9fa7d114100c2',
                    'invoice_id' => 'S-2501211',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
