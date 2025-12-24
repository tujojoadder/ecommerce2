<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

Route::get('update/client/wallet/{id}', [AjaxController::class, 'updateClientWallet'])->name('update.client.wallet');
Route::get('update/supplier/wallet/{id}', [AjaxController::class, 'updateSupplierWallet'])->name('update.supplier.wallet');
Route::get('update/total/balance', [AjaxController::class, 'updateTotalBalance'])->name('update.total.balance');

Route::get('clients', [AjaxController::class, 'get_clients'])->name('get.clients');
Route::get('clients-group', [AjaxController::class, 'get_clients_group'])->name('get.clients.group');
Route::get('get-category', [AjaxController::class, 'get_category'])->name('get.category');
Route::get('get-sub-category/{category_id}', [AjaxController::class, 'get_sub_category'])->name('get.sub.category');
Route::get('get-sub-sub-category/{category_id}/{subcategory_id}', [AjaxController::class, 'get_sub_sub_category'])->name('get.sub.sub.category');
Route::get('get-branches', [AjaxController::class, 'getBranches'])->name('get.branches');
Route::get('get-branch/{id}', [AjaxController::class, 'getBranch'])->name('get.branch');
Route::get('suppliers', [AjaxController::class, 'get_suppliers'])->name('get.suppliers');
Route::get('suppliers-group', [AjaxController::class, 'get_suppliers_group'])->name('get.suppliers.group');
Route::get('accounts', [AjaxController::class, 'get_accounts'])->name('get.accounts');
Route::get('account/{id}', [AjaxController::class, 'get_account'])->name('get.account');
Route::get('payment-methods', [AjaxController::class, 'get_payment_methods'])->name('get.payment_methods');
Route::get('projects', [AjaxController::class, 'get_projects'])->name('get.projects');
Route::get('invoices', [AjaxController::class, 'get_invoices'])->name('get.invoices');
Route::get('products', [AjaxController::class, 'get_products'])->name('get.products');
Route::get('get-stock-warning-products', [AjaxController::class, 'get_stock_warning_products'])->name('get.stock.warning.products');
Route::get('warehouses', [AjaxController::class, 'get_warehouses'])->name('get.warehouses');
Route::get('product-groups', [AjaxController::class, 'get_product_groups'])->name('get.product.groups');
Route::get('get-product-group/{id}', [AjaxController::class, 'get_product_group'])->name('get.product.group');
Route::get('get-product/{id}', [AjaxController::class, 'get_product'])->name('get.product');
Route::get('get-product2/{id}', [AjaxController::class, 'get_product2'])->name('get.product2');
Route::get('purchased-products', [AjaxController::class, 'get_purchased_products'])->name('get.purchased.products');
Route::get('get-purchased-product/{id}', [AjaxController::class, 'get_purchased_product'])->name('get.purchased.product');
Route::get('products-units', [AjaxController::class, 'get_product_units'])->name('get.product.units');
Route::get('get-product-unit/{id}', [AjaxController::class, 'get_product_unit'])->name('get.product.unit');
Route::get('products-sizes', [AjaxController::class, 'get_product_sizes'])->name('get.product.sizes');
Route::get('get-product-size/{id}', [AjaxController::class, 'get_product_size'])->name('get.product.size');
Route::get('products-colors', [AjaxController::class, 'get_product_colors'])->name('get.product.colors');
Route::get('get-product-color/{id}', [AjaxController::class, 'get_product_color'])->name('get.product.color');
Route::get('products-brands', [AjaxController::class, 'get_product_brands'])->name('get.product.brands');
Route::get('get-product-brand/{id}', [AjaxController::class, 'get_product_brand'])->name('get.product.brand');
Route::get('get-receive-categories', [AjaxController::class, 'receive_category'])->name('get.receive.categories');
Route::get('get-receive-subcategories', [AjaxController::class, 'receive_subcategory'])->name('get.receive.subcategories');
Route::get('get-expense-categories', [AjaxController::class, 'expense_category'])->name('get.expense.categories');
Route::get('get-expense-subcategories', [AjaxController::class, 'expense_subcategory'])->name('get.expense.subcategories');
Route::get('get-company-information', [AjaxController::class, 'companyInformation'])->name('get.company.information');
Route::get('get-banks', [AjaxController::class, 'get_banks'])->name('get.banks');
Route::get('get-chart-of-accounts', [AjaxController::class, 'get_chart_of_acounts'])->name('get.chart_of_accounts');
Route::get('get-chart-of-account-groups', [AjaxController::class, 'get_chart_of_acount_groups'])->name('get.chart_of_account_groups');
Route::get('all-wallets', [AjaxController::class, 'getAllWallets'])->name('get.wallets');
Route::get('staffs', [AjaxController::class, 'get_staffs'])->name('get.all.staff');
Route::get('get-staff-department', [AjaxController::class, 'getStaffDepartment'])->name('get.staff.departments');
Route::get('get-staff-designation', [AjaxController::class, 'getStaffDesignation'])->name('get.staff.designations');
Route::get('enable-disable-field/{table}/{field}', [AjaxController::class, 'enableOrDisableField'])->name('enable.disable.field');
Route::get('update-sale-percentage', [AjaxController::class, 'updateSalePricePercentage'])->name('update.sale.percentage');
Route::get('update-labour-cost-rate', [AjaxController::class, 'updateLabourCostRate'])->name('update.labour.cost.rate');
Route::get('update-folder-id', [AjaxController::class, 'updateGoogleDriveFolderId'])->name('update.folder.id');

// supplier due, supplier invoice due, and supplier invoices
Route::get('get-supplier-due/{id}', [AjaxController::class, 'getSupplierDue'])->name('get.supplier.due');
Route::get('get-supplier-info/{id}', [AjaxController::class, 'getSupplierInfo'])->name('get.supplier.info');
Route::get('get-supplier-invoices/{id}', [AjaxController::class, 'getSupplierInvoices'])->name('get.supplier.invoices');
Route::get('get-supplier-invoice-due/{id}', [AjaxController::class, 'getSupplierInvoicesDue'])->name('get.supplier.invoices.due');

// client Due, client invoice due, and client invoices
Route::get('get-client-due/{id}', [AjaxController::class, 'getClientDue'])->name('get.client.due');
Route::get('get-client-info/{id}', [AjaxController::class, 'getClientInfo'])->name('get.client.info');
Route::get('get-client-invoices/{id}', [AjaxController::class, 'getClientInvoices'])->name('get.client.invoices');
Route::get('get-client-invoice-due/{id}', [AjaxController::class, 'getClientInvoiceDue'])->name('get.client.invoices.due');
Route::get('get-staff-due/{id}', [AjaxController::class, 'getStaffDue'])->name('get.staff.due');

Route::get('get-client-group/{id}', [AjaxController::class, 'getClientGroup'])->name('get.client.group');
Route::get('get-cateogry-info/{id}', [AjaxController::class, 'getCategoryInfo'])->name('get.category.info');
Route::get('get-sub-cateogry-info/{id}', [AjaxController::class, 'getSubCategoryInfo'])->name('get.sub.category.info');
Route::get('get-sub-sub-cateogry-info/{id}', [AjaxController::class, 'getSubSubCategoryInfo'])->name('get.sub.sub.category.info');
Route::get('get-payment-method/{id}', [AjaxController::class, 'getPaymentMethod'])->name('get.payment.method');
Route::get('get-supplier-group/{id}', [AjaxController::class, 'getSupplierGroup'])->name('get.supplier.group');
Route::get('get-expense-category/{id}', [AjaxController::class, 'getExpenseCategory'])->name('get.expense.category');
Route::get('get-expense-subcategory/{id}', [AjaxController::class, 'getExpenseSubCategory'])->name('get.expense.subcategory');
Route::get('get-receive-category/{id}', [AjaxController::class, 'getReceiveCategory'])->name('get.receive.category');
Route::get('get-account/{id}', [AjaxController::class, 'getAccount'])->name('get.account');

Route::post('set-site-preset/{type}/{value}', [AjaxController::class, 'setSitePreset'])->name('set.site.preset');