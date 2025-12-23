<?php

namespace Database\Seeders;

use App\Models\FieldManager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldManager::insert(
            [

                [
                    'table_name' => 'clients',
                    'field_name' => 'id_no',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'client_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'company_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'fathers_name',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'staff_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'mothers_name',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'address',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'phone',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'phone_optional',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'previous_due',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'max_due_limit',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'street_road',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'reference',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'email',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'date_of_birth',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'upazilla_thana',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'zip_code',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'group_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'image',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'clients',
                    'field_name' => 'status',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // ---------------------------------------

                [
                    'table_name' => 'client_groups',
                    'field_name' => 'name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'client_groups',
                    'field_name' => 'status',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // ---------------------------------------

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'supplier_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'company_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'phone',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'phone_optional',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'email',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'previous_due',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'address',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'city_state',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'zip_code',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'country_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'domain',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'bank_account',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'image',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'group_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'suppliers',
                    'field_name' => 'status',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'supplier_groups',
                    'field_name' => 'name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'supplier_groups',
                    'field_name' => 'status',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // ---------------------------------------

                [
                    'table_name' => 'receives',
                    'field_name' => 'client_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'invoice_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'date',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'account_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'description',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'amount',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'project_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'chart_account_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'chart_group_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'category_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'subcategory_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'payment_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'bank_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'cheque_no',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'sms',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'receives',
                    'field_name' => 'email',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // ---------------------------------------

                [
                    'table_name' => 'transfers',
                    'field_name' => 'with_insufficient_balance',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // ---------------------------------------

                [
                    'table_name' => 'expenses',
                    'field_name' => 'date',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'month',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'year',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'staff_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'account_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'client_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'supplier_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'purchase_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'amount',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'category_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'subcategory_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'payment_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'bank_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'cheque_no',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'image',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'description',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'expense_type',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'show_only_cost_list',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'expenses',
                    'field_name' => 'show_money_return_into_list',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // --------------------------------------

                [
                    'table_name' => 'users',
                    'field_name' => 'name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'username',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'email',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'phone',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'fathers_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'mothers_name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'present_address',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'parmanent_address',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'date_of_birth',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'nationality',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'religion',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'marital_status',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'nid',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'birth_certificate',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'blood_group',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'gender',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'edu_qualification',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'experience',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'staff_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'image',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'staff_type',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'department_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'designation_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'office_zone',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'joining_date',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'discharge_date',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'machine_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'status',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'users',
                    'field_name' => 'description',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // --------------------------------------------------------------

                [
                    'table_name' => 'settings',
                    'field_name' => 'custom_header',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'print_destination',
                    'status' => 1, // 1 = Invoice View, 0 = POS View
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'client_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'staff_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'track_number',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'seperate_item',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'set_receive_amount',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'over_stock_selling',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'issued_date',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'issued_time',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'discount',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'discount_type',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'transport_fare',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'labour_cost',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'account_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'category_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'cash_amount',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'change_amount',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'receive_amount',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'bill_amount',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'due_amount',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'highest_due',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'vat',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'vat_type',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'send_sms',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'send_email',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'warranty',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'description',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'qr_code',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'invoices',
                    'field_name' => 'open_product_after_select',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                // --------------------------------------------------------------

                [
                    'table_name' => 'purchases',
                    'field_name' => 'invoice_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'seperate_item',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'issued_date',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'supplier_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'warehouse_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'discount',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'transport_fare',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'vat',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'account_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'category_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'purchases',
                    'field_name' => 'receive_amount',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // ----------------------------------------------------------------

                [
                    'table_name' => 'products',
                    'field_name' => 'name',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'image',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'description',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'buying_price',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'selling_price',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'wholesale_price',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'unit_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'color_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'size_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'brand_id',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'opening_stock',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'custom_barcode_no',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'imei_no',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'warehouse_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'carton',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'group_id',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'stock_warning',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'show_stock_warning',
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'multi_pricing',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'new_price_sale_only',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'table_name' => 'products',
                    'field_name' => 'sale_price_with_percentage',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
        );
    }
}
