<?php

namespace Database\Seeders;

use App\Models\CompanyInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CompanyInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyInformation::insert(
            [
                [
                    'company_name' => 'Your Company Name',
                    'company_type' => 'POS Software',
                    'logo' => '',
                    'banner' => '',
                    'invoice_greetings' => 'বিসমিল্লাহ্হির রাহমানির রাহিম',
                    'invoice_header' => '',
                    'invoice_footer' => '',
                    'proprietor' => 'MD. Palash Hossain',
                    'country' => 'Bangladesh',
                    'address' => 'Khulna',
                    'address_optional' => 'Khulna',
                    'email' => 'demo@gmail.com',
                    'phone' => '01900000000',
                    'city' => 'Khulna',
                    'state' => 'Bangladesh',
                    'post_code' => '9000',
                    'stock_warning' => '10',
                    'currency_symbol' => '৳',
                    'sms_api_code' => '',
                    'sms_sender_id' => '',
                    'sms_provider' => '',
                    'sms_setting' => '',
                    'created_by' => 'admin',
                    'updated_by' => '',
                    'deleted_by' => '',
                    'status' => 1,
                    'deleted_at' => null,
                    'created_at' => now(),
                ]
            ]
        );
    }
}
