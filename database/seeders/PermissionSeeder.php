<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert(
            [
                // --------------------------
                [
                    'name' => 'access-all',
                    'group' => 'Main',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'settings',
                    'group' => 'Main',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'dashboard-visibility',
                    'group' => 'Main',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-visibility',
                    'group' => 'Clients',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-create',
                    'group' => 'Clients',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-edit',
                    'group' => 'Clients',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-view',
                    'group' => 'Clients',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-delete',
                    'group' => 'Clients',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-remaining-due-date-visibility',
                    'group' => 'Clients Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-remaining-due-date-create',
                    'group' => 'Clients Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-remaining-due-date-edit',
                    'group' => 'Clients Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-remaining-due-date-view',
                    'group' => 'Clients Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-remaining-due-date-delete',
                    'group' => 'Clients Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-group-visibility',
                    'group' => 'Clients Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-group-create',
                    'group' => 'Clients Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-group-edit',
                    'group' => 'Clients Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-group-view',
                    'group' => 'Clients Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-group-delete',
                    'group' => 'Clients Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-loan-visibility',
                    'group' => 'Clients Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-loan-create',
                    'group' => 'Clients Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-loan-edit',
                    'group' => 'Clients Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-loan-view',
                    'group' => 'Clients Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-loan-delete',
                    'group' => 'Clients Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-money-return-visibility',
                    'group' => 'Clients Money Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-money-return-create',
                    'group' => 'Clients Money Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-money-return-edit',
                    'group' => 'Clients Money Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-money-return-view',
                    'group' => 'Clients Money Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'client-money-return-delete',
                    'group' => 'Clients Money Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-visibility',
                    'group' => 'Suppliers',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-create',
                    'group' => 'Suppliers',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-edit',
                    'group' => 'Suppliers',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-view',
                    'group' => 'Suppliers',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-delete',
                    'group' => 'Suppliers',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-cheque-schedule',
                    'group' => 'Suppliers',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-remaining-due-date-visibility',
                    'group' => 'Suppliers Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-remaining-due-date-create',
                    'group' => 'Suppliers Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-remaining-due-date-edit',
                    'group' => 'Suppliers Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-remaining-due-date-view',
                    'group' => 'Suppliers Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-remaining-due-date-delete',
                    'group' => 'Suppliers Remaining Due Date',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-group-visibility',
                    'group' => 'Suppliers Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-group-create',
                    'group' => 'Suppliers Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-group-edit',
                    'group' => 'Suppliers Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-group-view',
                    'group' => 'Suppliers Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-group-delete',
                    'group' => 'Suppliers Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'account-visibility',
                    'group' => 'Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'account-create',
                    'group' => 'Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'account-edit',
                    'group' => 'Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'account-view',
                    'group' => 'Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'account-delete',
                    'group' => 'Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'loan-visibility',
                    'group' => 'Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'loan-create',
                    'group' => 'Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'loan-edit',
                    'group' => 'Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'loan-view',
                    'group' => 'Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'loan-delete',
                    'group' => 'Loan',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-visibility',
                    'group' => 'Receives',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-create',
                    'group' => 'Receives',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-edit',
                    'group' => 'Receives',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-view',
                    'group' => 'Receives',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-delete',
                    'group' => 'Receives',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-visibility',
                    'group' => 'Expenses',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-create',
                    'group' => 'Expenses',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-edit',
                    'group' => 'Expenses',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-view',
                    'group' => 'Expenses',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-delete',
                    'group' => 'Expenses',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-payment-visibility',
                    'group' => 'Supplier Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-payment-create',
                    'group' => 'Supplier Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-payment-edit',
                    'group' => 'Supplier Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-payment-view',
                    'group' => 'Supplier Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'supplier-payment-delete',
                    'group' => 'Supplier Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'transfer-visibility',
                    'group' => 'Transfer',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'transfer-create',
                    'group' => 'Transfer',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'transfer-edit',
                    'group' => 'Transfer',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'transfer-view',
                    'group' => 'Transfer',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'transfer-delete',
                    'group' => 'Transfer',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'project-visibility',
                    'group' => 'Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'project-create',
                    'group' => 'Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'project-edit',
                    'group' => 'Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'project-view',
                    'group' => 'Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'project-delete',
                    'group' => 'Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-visibility',
                    'group' => 'Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-create',
                    'group' => 'Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-edit',
                    'group' => 'Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-view',
                    'group' => 'Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-delete',
                    'group' => 'Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'draft-invoice-visibility',
                    'group' => 'Draft Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'draft-invoice-create',
                    'group' => 'Draft Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'draft-invoice-edit',
                    'group' => 'Draft Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'draft-invoice-view',
                    'group' => 'Draft Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'draft-invoice-delete',
                    'group' => 'Draft Invoice',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-return-visibility',
                    'group' => 'Invoice Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-return-create',
                    'group' => 'Invoice Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-return-edit',
                    'group' => 'Invoice Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-return-view',
                    'group' => 'Invoice Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'invoice-return-delete',
                    'group' => 'Invoice Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'asset-n-stock-visibility',
                    'group' => 'Asset And Stock',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'asset-n-stock-create',
                    'group' => 'Asset And Stock',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'asset-n-stock-edit',
                    'group' => 'Asset And Stock',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'asset-n-stock-view',
                    'group' => 'Asset And Stock',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'asset-n-stock-delete',
                    'group' => 'Asset And Stock',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'raw-material-visibility',
                    'group' => 'Raw Material',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'raw-material-create',
                    'group' => 'Raw Material',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'raw-material-edit',
                    'group' => 'Raw Material',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'raw-material-view',
                    'group' => 'Raw Material',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'raw-material-delete',
                    'group' => 'Raw Material',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'batch-product-visibility',
                    'group' => 'Batch Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'batch-product-create',
                    'group' => 'Batch Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'batch-product-edit',
                    'group' => 'Batch Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'batch-product-view',
                    'group' => 'Batch Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'batch-product-delete',
                    'group' => 'Batch Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-visibility',
                    'group' => 'Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-create',
                    'group' => 'Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-edit',
                    'group' => 'Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-view',
                    'group' => 'Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-delete',
                    'group' => 'Product',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'warehouse-visibility',
                    'group' => 'Warehouse',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'warehouse-create',
                    'group' => 'Warehouse',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'warehouse-edit',
                    'group' => 'Warehouse',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'warehouse-view',
                    'group' => 'Warehouse',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'warehouse-delete',
                    'group' => 'Warehouse',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-group-visibility',
                    'group' => 'Product Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-group-create',
                    'group' => 'Product Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-group-edit',
                    'group' => 'Product Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-group-view',
                    'group' => 'Product Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-group-delete',
                    'group' => 'Product Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'branch-visibility',
                    'group' => 'Branch',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'branch-create',
                    'group' => 'Branch',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'branch-edit',
                    'group' => 'Branch',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'branch-view',
                    'group' => 'Branch',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'branch-delete',
                    'group' => 'Branch',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-unit-visibility',
                    'group' => 'Product Unit',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-unit-create',
                    'group' => 'Product Unit',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-unit-edit',
                    'group' => 'Product Unit',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-unit-view',
                    'group' => 'Product Unit',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-unit-delete',
                    'group' => 'Product Unit',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-asset-visibility',
                    'group' => 'Product Asset',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-asset-create',
                    'group' => 'Product Asset',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-asset-edit',
                    'group' => 'Product Asset',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-asset-view',
                    'group' => 'Product Asset',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-asset-delete',
                    'group' => 'Product Asset',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-barcode-visibility',
                    'group' => 'Product Barcode',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-barcode-create',
                    'group' => 'Product Barcode',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-barcode-edit',
                    'group' => 'Product Barcode',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-barcode-view',
                    'group' => 'Product Barcode',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-barcode-delete',
                    'group' => 'Product Barcode',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-visibility',
                    'group' => 'Product Purchase',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-create',
                    'group' => 'Product Purchase',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-edit',
                    'group' => 'Product Purchase',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-view',
                    'group' => 'Product Purchase',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-delete',
                    'group' => 'Product Purchase',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-return-visibility',
                    'group' => 'Product Purchase Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-return-create',
                    'group' => 'Product Purchase Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-return-edit',
                    'group' => 'Product Purchase Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-return-view',
                    'group' => 'Product Purchase Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-purchase-return-delete',
                    'group' => 'Product Purchase Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-return-visibility',
                    'group' => 'Product Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-return-create',
                    'group' => 'Product Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-return-edit',
                    'group' => 'Product Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-return-view',
                    'group' => 'Product Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'product-return-delete',
                    'group' => 'Product Return',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-visibility',
                    'group' => 'Staff',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-create',
                    'group' => 'Staff',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-edit',
                    'group' => 'Staff',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-view',
                    'group' => 'Staff',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-delete',
                    'group' => 'Staff',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-payment-visibility',
                    'group' => 'Staff Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-payment-create',
                    'group' => 'Staff Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-payment-edit',
                    'group' => 'Staff Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-payment-view',
                    'group' => 'Staff Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-payment-delete',
                    'group' => 'Staff Payment',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-salary-visibility',
                    'group' => 'Staff Salary',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-salary-create',
                    'group' => 'Staff Salary',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-salary-edit',
                    'group' => 'Staff Salary',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-salary-view',
                    'group' => 'Staff Salary',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-salary-delete',
                    'group' => 'Staff Salary',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-attendance-visibility',
                    'group' => 'Staff Attendance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-attendance-create',
                    'group' => 'Staff Attendance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-attendance-edit',
                    'group' => 'Staff Attendance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-attendance-view',
                    'group' => 'Staff Attendance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-attendance-delete',
                    'group' => 'Staff Attendance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-department-visibility',
                    'group' => 'Staff Department',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-department-create',
                    'group' => 'Staff Department',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-department-edit',
                    'group' => 'Staff Department',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-department-view',
                    'group' => 'Staff Department',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-department-delete',
                    'group' => 'Staff Department',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-designation-visibility',
                    'group' => 'Staff Designation',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-designation-create',
                    'group' => 'Staff Designation',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-designation-edit',
                    'group' => 'Staff Designation',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-designation-view',
                    'group' => 'Staff Designation',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'staff-designation-delete',
                    'group' => 'Staff Designation',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-cateogry-visibility',
                    'group' => 'Receive Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-cateogry-create',
                    'group' => 'Receive Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-cateogry-edit',
                    'group' => 'Receive Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-cateogry-view',
                    'group' => 'Receive Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-cateogry-delete',
                    'group' => 'Receive Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-cateogry-visibility',
                    'group' => 'Expense Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-cateogry-create',
                    'group' => 'Expense Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-cateogry-edit',
                    'group' => 'Expense Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-cateogry-view',
                    'group' => 'Expense Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-cateogry-delete',
                    'group' => 'Expense Category',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-visibility',
                    'group' => 'Chart Of Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-create',
                    'group' => 'Chart Of Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-edit',
                    'group' => 'Chart Of Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-view',
                    'group' => 'Chart Of Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-delete',
                    'group' => 'Chart Of Account',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-group-visibility',
                    'group' => 'Chart Of Account Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-group-create',
                    'group' => 'Chart Of Account Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-group-edit',
                    'group' => 'Chart Of Account Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-group-view',
                    'group' => 'Chart Of Account Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-group-delete',
                    'group' => 'Chart Of Account Group',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-subcategory-visibility',
                    'group' => 'Chart Of Account Subcategory',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-subcategory-create',
                    'group' => 'Chart Of Account Subcategory',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-subcategory-edit',
                    'group' => 'Chart Of Account Subcategory',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-subcategory-view',
                    'group' => 'Chart Of Account Subcategory',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'coa-subcategory-delete',
                    'group' => 'Chart Of Account Subcategory',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'shortcut-menu-visibility',
                    'group' => 'Shortcut Menu',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'shortcut-menu-create',
                    'group' => 'Shortcut Menu',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'shortcut-menu-edit',
                    'group' => 'Shortcut Menu',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'shortcut-menu-view',
                    'group' => 'Shortcut Menu',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'shortcut-menu-delete',
                    'group' => 'Shortcut Menu',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'payment-method-visibility',
                    'group' => 'Payment Method',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'payment-method-create',
                    'group' => 'Payment Method',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'payment-method-edit',
                    'group' => 'Payment Method',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'payment-method-view',
                    'group' => 'Payment Method',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'payment-method-delete',
                    'group' => 'Payment Method',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'bank-visibility',
                    'group' => 'Bank',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'bank-create',
                    'group' => 'Bank',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'bank-edit',
                    'group' => 'Bank',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'bank-view',
                    'group' => 'Bank',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'bank-delete',
                    'group' => 'Bank',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'company-information-visibility',
                    'group' => 'Company Information',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'company-information-edit',
                    'group' => 'Company Information',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'profit-view',
                    'group' => 'Profit',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'total-balance-report-view',
                    'group' => 'Total Balance Report',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'due-report',
                    'group' => 'Report',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'sales-report',
                    'group' => 'Report',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'receive-report',
                    'group' => 'Report',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
                [
                    'name' => 'expense-report',
                    'group' => 'Report',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // --------------------------
            ]
        );
    }
}
