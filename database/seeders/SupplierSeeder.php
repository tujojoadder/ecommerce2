<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::insert(
            [
                [
                    'supplier_name' => 'Test Supplier',
                    'company_name' => 'test company',
                    'phone' => '01900000000',
                    'phone_optional' => '01900000000',
                    'email' => 'test@gmail.com',
                    'previous_due' => 100,
                    'address' => 'Test address',
                    'city_state' => 'Kotalipara, Gopalganj',
                    'zip_code' => '8010',
                    'country_name' => 'Bangladesh',
                    'domain' => '',
                    'bank_account' => '',
                    'image' => '',
                    'group_id' => 1,
                    'status' => 1,
                    'created_by' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
    }
}
