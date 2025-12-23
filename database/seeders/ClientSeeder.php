<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10000; $i++) {
            Client::insert(
                [
                    [
                        'id_no' => time(),
                        'client_name' => 'Test Client' . $i,
                        'company_name' => 'Test Company' . $i,
                        'address' => 'Test Address' . $i,
                        'phone' => '01900000000',
                        'phone_optional' => '01900000000',
                        'previous_due' => 150,
                        'email' => $i . 'test@gmail.com',
                        'date_of_birth' => date('d/m/Y'),
                        'upazilla_thana' => 'Kotalipara',
                        'zip_code' => '8010',
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
}
