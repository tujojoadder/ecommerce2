<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\ClientGroup;
use App\Models\SupplierGroup;
use App\Models\Department;
use App\Models\Designation;
use App\Models\ProductGroup;
use App\Models\ReceiveCategory;
use App\Models\ExpenseCategory;
use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountGroup;
use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::insert(
            [
                [
                    'title' => 'Demo',
                    'initial_balance' => '1000',
                    'account_number' => '101010',
                    'contact_person' => '01345687591',
                    'phone' => '01345687591',
                    'description' => 'demo account',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );

        ClientGroup::insert(
            [
                [
                    'name' => 'test group',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );

        SupplierGroup::insert(
            [
                [
                    'name' => 'test group',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );

        Department::insert(
            [
                [
                    'name' => 'test group',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );

        Designation::insert(
            [
                [
                    'name' => 'test group',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );

        ProductGroup::insert(
            [
                [
                    'name' => 'test group',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );


        ProductUnit::insert(
            [
                [
                    'name' => 'Test Group',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );


        ReceiveCategory::insert(
            [
                [
                    'name' => 'test category',
                    'type' => '',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );


        ExpenseCategory::insert(
            [
                [
                    'name' => 'test category',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );


        ChartOfAccount::insert(
            [
                [
                    'name' => 'Test COA',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );


        ChartOfAccountGroup::insert(
            [
                [
                    'chart_id' => '1',
                    'name' => 'Test COA',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );


        Product::insert(
            [
                [
                    'name' => 'Test Product',
                    'image' => '',
                    'description' => 'Test Product',
                    'buying_price' => '10',
                    'selling_price' => '12',
                    'unit_id' => '1',
                    'opening_stock' => '1',
                    'group_id' => '1',
                    'stock_warning' => '1',
                    'created_by' => 'admin',
                    'updated_by' => 'admin',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );
    }
}
