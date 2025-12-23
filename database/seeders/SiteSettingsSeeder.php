<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::insert(
            [
                // sidebar start ------------------------------------------------------------------------------------
                [
                    'language' => 'en',
                    'menu_size' => 'large',
                    'receive_sms' => 'Dear {client_name},<br />Thank you for the payment of {receive_amount} TK<br />Due : {due_amount} for {description}. <br /><br />{company_name}<br />HELPLINE: {company_mobile}',
                    'invoice_sms' => 'Dear {client_name},<br />Thank you for purchasing our products.<br />Total bill: {total_bill} TK<br />Payment: {total_payment}<br />Due : {invoice_due}<br />Total Due: {client_total_due}. <br /><br />{company_name}<br />HELPLINE: {company_mobile}',

                    'partial_api' => 0,
                    'api_key' => null,
                    'api_url' => null,
                    'sender_id' => null,
                    'google_drive_folder_id' => '',
                    'package' => 'basic',

                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
