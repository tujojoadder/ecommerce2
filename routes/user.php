<?php

use App\Http\Controllers\Frontend\BlogCategoryController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\AnalyticsDashboardController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\ClientController;
use App\Http\Controllers\User\SupplierController;
use App\Http\Controllers\User\Accounts\AccountController;
use App\Http\Controllers\User\BatchProductController;
use App\Http\Controllers\User\Accounts\ReceiveController;
use App\Http\Controllers\User\Accounts\ExpenseController;
use App\Http\Controllers\User\ClientGroupController;
use App\Http\Controllers\User\TransferController;
use App\Http\Controllers\User\ConfigController;
use App\Http\Controllers\User\Project\ProjectController;
use App\Http\Controllers\User\AssetAndStockController;
use App\Http\Controllers\User\BackupDatabaseController;
use App\Http\Controllers\User\ChequeSchuduleController;
use App\Http\Controllers\User\ClientLoanController;
use App\Http\Controllers\User\BranchController;
use App\Http\Controllers\User\BulkManagementController;
use App\Http\Controllers\User\Metarial\MetarialController;
use App\Http\Controllers\User\Products\ProductController;
use App\Http\Controllers\User\Products\ProductGroupController;
use App\Http\Controllers\User\Products\ProductUnitController;
use App\Http\Controllers\User\Products\ProductAssetController;
use App\Http\Controllers\User\Products\ProductBarcodeController;
use App\Http\Controllers\User\Products\Buy\ProductReturnController;
use App\Http\Controllers\User\Configuration\ReceiveCategory\ReceiveCategoryController;
use App\Http\Controllers\User\Configuration\ReceiveCategory\ReceiveSubcategoryController;
use App\Http\Controllers\User\Configuration\ExpenseCategory\ExpenseCategoryController;
use App\Http\Controllers\User\Configuration\ExpenseCategory\ExpenseSubcategoryController;
use App\Http\Controllers\User\Configuration\ChartOfAccount\ChartOfAccountController;
use App\Http\Controllers\User\Invoices\InvoiceController;
use App\Http\Controllers\User\DepartmentController;
use App\Http\Controllers\User\DesignationController;
use App\Http\Controllers\User\Configuration\ChartOfAccount\ChartOfAccountSubcategoryController;
use App\Http\Controllers\User\Configuration\ChartOfAccount\ChartOfAccountGroupController;
use App\Http\Controllers\User\Configuration\ShortcutMenu\ShortcutMenuController;
use App\Http\Controllers\User\Configuration\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\User\Configuration\CompanyInformation\CompanyInformationController;
use App\Http\Controllers\User\Configuration\Bank\BankController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ProfitController;
use App\Http\Controllers\User\Purchase\PurchaseController;
use App\Http\Controllers\User\Reports\DepositReportsController;
use App\Http\Controllers\User\Reports\ExpenseReportController;
use App\Http\Controllers\User\Reports\SalesReportController;
use App\Http\Controllers\User\Reports\DueReportController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\BackupLogController;
use App\Http\Controllers\User\BannerController;
use App\Http\Controllers\User\BrandController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\DeleteLogController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ServerInfoController;
use App\Http\Controllers\User\SiteManagerController;
use App\Http\Controllers\User\SliderController;
use App\Http\Controllers\User\SmsManagerController;
use App\Http\Controllers\User\StaffAttendanceController;
use App\Http\Controllers\User\StaffSalaryController;
use App\Http\Controllers\User\Stock\ProductStockController;
use App\Http\Controllers\User\SubCategoryController;
use App\Http\Controllers\User\SubSubCategoryController;
use App\Http\Controllers\User\SupplierGroupController;
use App\Http\Controllers\User\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/analytics', [AnalyticsDashboardController::class, 'index'])->name('analytics');
    Route::get('logout', [DashboardController::class, 'logout'])->name('user.logout');

    // Profile routes
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/privacy/change/password', [ProfileController::class, 'changePasswordIndex'])->name('change.password.index');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change.password.update');
        Route::put('update/{id}', [ProfileController::class, 'update'])->name('update');
        Route::put('update-image/{id}', [ProfileController::class, 'updateImage'])->name('update.image');
    });

    // Account routes
    Route::prefix('account')->as('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index')->middleware(['permission:access-all|account-visibility']);
        Route::get('/total', [AccountController::class, 'total'])->name('total')->middleware(['permission:access-all|account-visibility']);
        Route::get('create', [AccountController::class, 'create'])->name('create')->middleware(['permission:access-all|account-create']);
        Route::post('store', [AccountController::class, 'store'])->name('store')->middleware(['permission:access-all|account-create']);
        Route::get('view-account/{id}', [AccountController::class, 'show'])->name('view')->middleware(['permission:access-all|account-view|account-visibility']);
        Route::get('edit/{id}', [AccountController::class, 'edit'])->name('edit')->middleware(['permission:access-all|account-edit']);
        Route::put('update/{id}', [AccountController::class, 'update'])->name('update')->middleware(['permission:access-all|account-edit']);
        Route::get('delete/{id}', [AccountController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|account-delete']);
        Route::get('view/balance', [AccountController::class, 'balance'])->name('view.balance')->middleware(['permission:access-all|account-view|account-visibility']);
        Route::get('view/statement', [AccountController::class, 'viewStatement'])->name('view.statement')->middleware(['permission:access-all|account-visibility']);
    });

    //blog
    Route::prefix('blog')->as('blog.')->group(function () {

        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/store', [BlogController::class, 'store'])->name('store');

        Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');
        Route::post('/{blog}/status', [BlogController::class, 'updateStatus'])->name('status');
        //blog category
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
            Route::get('/create', [BlogCategoryController::class, 'create'])->name('create');
            Route::post('/store', [BlogCategoryController::class, 'store'])->name('store');

            Route::get('/{blogCategory}/edit', [BlogCategoryController::class, 'edit'])->name('edit');
            Route::put('/{blogCategory}', [BlogCategoryController::class, 'update'])->name('update');
            Route::delete('/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('destroy');
            Route::post('/{blogCategory}/status', [BlogCategoryController::class, 'updateStatus'])->name('status');
        });
    });


    // Staff routes
    Route::prefix('staff')->as('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index')->middleware(['permission:access-all|staff-visibility']);
        Route::get('create', [StaffController::class, 'create'])->name('create')->middleware(['permission:access-all|staff-create']);
        Route::post('store', [StaffController::class, 'store'])->name('store')->middleware(['permission:access-all|staff-create', 'check_limitation']);
        Route::get('view/{id}', [StaffController::class, 'show'])->name('view')->middleware(['permission:access-all|staff-view|staff-visibility']);
        Route::get('edit/{id}', [StaffController::class, 'edit'])->name('edit')->middleware(['permission:access-all|staff-edit']);
        Route::put('update/{id}', [StaffController::class, 'update'])->name('update')->middleware(['permission:access-all|staff-edit']);
        Route::get('delete/{id}', [StaffController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|staff-delete']);

        Route::get('assign/role/{userId}', [StaffController::class, 'assignRole'])->name('assing.role')->middleware(['permission:access-all']);
        Route::post('assign/role/{userId}', [StaffController::class, 'saveAssignedRole'])->name('assing.role.store')->middleware(['permission:access-all']);
        Route::get('assign/permission/{userId}', [StaffController::class, 'assignPermission'])->name('assing.permission')->middleware(['permission:access-all']);
        Route::post('assign/permission/{userId}', [StaffController::class, 'saveAssignedPermission'])->name('assing.permission.store')->middleware(['permission:access-all']);

        Route::prefix('salary')->as('salary.')->group(function () {
            Route::get('/', [StaffSalaryController::class, 'index'])->name('index')->middleware(['permission:access-all|staff-salary-visibility']);
            Route::get('create', [StaffSalaryController::class, 'create'])->name('create')->middleware(['permission:access-all|staff-salary-create']);
            Route::post('store', [StaffSalaryController::class, 'store'])->name('store')->middleware(['permission:access-all|staff-salary-create']);
        });

        Route::prefix('attendance')->as('attendance.')->group(function () {
            Route::get('/', [StaffAttendanceController::class, 'index'])->name('index')->middleware(['permission:access-all|staff-attendance-visibility']);
            Route::get('create', [StaffAttendanceController::class, 'create'])->name('create')->middleware(['permission:access-all|staff-attendance-create']);
            Route::post('store', [StaffAttendanceController::class, 'store'])->name('store')->middleware(['permission:access-all|staff-attendance-create']);
            Route::get('monthly', [StaffAttendanceController::class, 'monthly'])->name('monthly')->middleware(['permission:access-all|staff-attendance-visibility']);
        });
    });
    Route::prefix('staff')->group(function () {
        // Designation
        Route::resource('designation', DesignationController::class)->except('destroy')->middleware(['permission:access-all|staff-designation-visibility|staff-designation-view|staff-designation-create']);
        Route::prefix('designation')->as('designation.')->group(function () {
            Route::get('delete/{id}', [DesignationController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|staff-designation-delete']);
        });
        // Department
        Route::resource('department', DepartmentController::class)->except('destroy')->middleware(['permission:access-all|staff-department-visibility|staff-department-view|staff-department-create']);
        Route::prefix('department')->as('department.')->group(function () {
            Route::get('delete/{id}', [DepartmentController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|staff-department-delete']);
        });
    });

    // Client routes
    Route::prefix('client')->as('client.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index')->middleware(['permission:access-all|client-visibility']);
        Route::get('/remaining/due/date', [ClientController::class, 'remainingDueList'])->name('remaining.due.list')->middleware(['permission:access-all|client-visibility']);
        Route::get('/loan', [ClientController::class, 'loanClient'])->name('loan.client')->middleware(['permission:access-all|client-visibility']);
        Route::get('create', [ClientController::class, 'create'])->name('create')->middleware(['permission:access-all|client-create']);
        Route::post('store', [ClientController::class, 'store'])->name('store')->middleware(['permission:access-all|client-create', 'check_limitation']);
        Route::get('view/{id}', [ClientController::class, 'show'])->name('view')->middleware(['permission:access-all|client-view|client-visibility']);
        Route::get('statements', [ClientController::class, 'statements'])->name('statements')->middleware(['permission:access-all|client-view|client-visibility']);
        Route::get('edit/{id}', [ClientController::class, 'edit'])->name('edit')->middleware(['permission:access-all|client-edit']);
        Route::put('update/{id}', [ClientController::class, 'update'])->name('update')->middleware(['permission:access-all|client-edit']);
        Route::get('delete/{id}', [ClientController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|client-delete']);
        Route::get('activeToggle/{id}', [ClientController::class, 'activeToggle'])->name('activeToggle')->middleware(['permission:access-all|client-edit']);
        Route::get('adjust-balance/{id}', [ClientController::class, 'addAdjustBalance'])->name('adjust.balance')->middleware(['permission:access-all|client-create']);
        Route::get('update-adjust-balance/{id}', [ClientController::class, 'updateAdjustBalance'])->name('update.adjust.balance')->middleware(['permission:access-all|client-create']);
        Route::get('edit-adjust-balance/{id}', [ClientController::class, 'editAdjustBalance'])->name('edit.adjust.balance')->middleware(['permission:access-all|client-create']);
        Route::get('get-adjusted-balance/{id}', [ClientController::class, 'getAdjustBalance'])->name('get.adjust.balance')->middleware(['permission:access-all|client-create']);
        Route::get('delete-adjust-balance/{id}', [ClientController::class, 'destroyAdjustBalance'])->name('destroy.adjust.balance')->middleware(['permission:access-all|client-create']);

        Route::get('client-remaining-due-date/{id}', [ClientController::class, 'remainingDueDate'])->name('remaining.due.date')->middleware(['permission:access-all|client-remaining-due-date-create']);
        Route::get('update-due-date/{id}', [ClientController::class, 'updateRemainingDueDate'])->name('update.remaining.due.date')->middleware(['permission:access-all|client-remaining-due-date-create']);

        Route::put('update-image/{id}', [ClientController::class, 'updateImage'])->name('update.image')->middleware(['permission:access-all|client-edit|client-create']);
    });
    Route::prefix('client-group')->as('client-group.')->group(function () {
        Route::get('/', [ClientGroupController::class, 'index'])->name('index')->middleware(['permission:access-all|client-group-visibility']);
        Route::get('create', [ClientGroupController::class, 'create'])->name('create')->middleware(['permission:access-all|client-group-create']);
        Route::post('store', [ClientGroupController::class, 'store'])->name('store')->middleware(['permission:access-all|client-group-create']);
        Route::get('view/{id}', [ClientGroupController::class, 'show'])->name('view')->middleware(['permission:access-all|client-group-view|client-group-visibility']);
        Route::get('edit/{id}', [ClientGroupController::class, 'edit'])->name('edit')->middleware(['permission:access-all|client-group-edit']);
        Route::put('update/{id}', [ClientGroupController::class, 'update'])->name('update')->middleware(['permission:access-all|client-group-edit']);
        Route::get('delete/{id}', [ClientGroupController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|client-group-delete']);
    });

    // Supplier routes
    Route::prefix('supplier')->as('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index')->middleware(['permission:access-all|supplier-visibility']);
        Route::get('/remaining/due/date', [SupplierController::class, 'remainingDueList'])->name('remaining.due.list')->middleware(['permission:access-all|supplier-visibility']);
        Route::get('/statements', [SupplierController::class, 'statements'])->name('statements')->middleware(['permission:access-all|supplier-visibility']);
        Route::get('create', [SupplierController::class, 'create'])->name('create')->middleware(['permission:access-all|supplier-create']);
        Route::post('store', [SupplierController::class, 'store'])->name('store')->middleware(['permission:access-all|supplier-create']);
        Route::get('view/{id}', [SupplierController::class, 'show'])->name('view')->middleware(['permission:access-all|supplier-view|supplier-visibility']);
        Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('edit')->middleware(['permission:access-all|supplier-edit']);
        Route::put('update/{id}', [SupplierController::class, 'update'])->name('update')->middleware(['permission:access-all|supplier-edit']);
        Route::get('delete/{id}', [SupplierController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|supplier-delete']);

        Route::get('supplier-remaining-due-date/{id}', [SupplierController::class, 'remainingDueDate'])->name('remaining.due.date')->middleware(['permission:access-all|supplier-remaining-due-date-create']);
        Route::get('update-due-date/{id}', [SupplierController::class, 'updateRemainingDueDate'])->name('update.remaining.due.date')->middleware(['permission:access-all|supplier-remaining-due-date-create']);

        Route::put('update-image/{id}', [SupplierController::class, 'updateImage'])->name('update.image')->middleware(['permission:access-all|supplier-edit|supplier-create']);
    });
    // supplier cheque schedule
    Route::prefix('supplier/cheque/schedule')->as('cheque.schudule.')->group(function () {
        Route::get('/', [ChequeSchuduleController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::get('create', [ChequeSchuduleController::class, 'create'])->name('create')->middleware(['permission:access-all']);
        Route::post('store', [ChequeSchuduleController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [ChequeSchuduleController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [ChequeSchuduleController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [ChequeSchuduleController::class, 'delete'])->name('delete')->middleware(['permission:access-all']);
    });
    Route::resource('supplier-group', SupplierGroupController::class)->except('destroy');
    Route::prefix('supplier-group')->as('supplier-group.')->group(function () {
        Route::get('/', [SupplierGroupController::class, 'index'])->name('index')->middleware(['permission:access-all|supplier-group-visibility']);
        Route::get('create', [SupplierGroupController::class, 'create'])->name('create')->middleware(['permission:access-all|supplier-group-create']);
        Route::post('store', [SupplierGroupController::class, 'store'])->name('store')->middleware(['permission:access-all|supplier-group-create']);
        Route::get('view/{id}', [SupplierGroupController::class, 'show'])->name('view')->middleware(['permission:access-all|supplier-group-view|supplier-group-visibility']);
        Route::get('edit/{id}', [SupplierGroupController::class, 'edit'])->name('edit')->middleware(['permission:access-all|supplier-group-edit']);
        Route::put('update/{id}', [SupplierGroupController::class, 'update'])->name('update')->middleware(['permission:access-all|supplier-group-edit']);
        Route::get('delete/{id}', [SupplierGroupController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|supplier-group-delete']);
    });

    // Account routes
    Route::resource('receive', ReceiveController::class)->except('destroy');
    Route::prefix('receive')->as('receive.')->group(function () {
        Route::get('/', [ReceiveController::class, 'index'])->name('index')->middleware(['permission:access-all|receive-visibility']);
        Route::get('create', [ReceiveController::class, 'create'])->name('create')->middleware(['permission:access-all|receive-create']);
        Route::post('store', [ReceiveController::class, 'store'])->name('store')->middleware(['permission:access-all|receive-create']);
        Route::get('view/{id}', [ReceiveController::class, 'show'])->name('view')->middleware(['permission:access-all|receive-view|receive-visibility']);
        Route::get('edit/{id}', [ReceiveController::class, 'edit'])->name('edit')->middleware(['permission:access-all|receive-edit']);
        Route::put('update/{id}', [ReceiveController::class, 'update'])->name('update')->middleware(['permission:access-all|receive-edit']);
        Route::get('delete/{id}', [ReceiveController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|receive-delete']);
    });

    Route::prefix('loan')->as('loan.')->group(function () {
        Route::get('/', [ClientLoanController::class, 'index'])->name('index')->middleware(['permission:access-all|loan-visibility']);
        Route::get('create', [ClientLoanController::class, 'create'])->name('create')->middleware(['permission:access-all|loan-create']);
        Route::post('store', [ClientLoanController::class, 'loanReceiveOrPayment'])->name('store')->middleware(['permission:access-all|loan-create']);
        Route::get('view/{id}', [ClientLoanController::class, 'show'])->name('view')->middleware(['permission:access-all|loan-view|loan-visibility']);
        Route::get('edit/{id}', [ClientLoanController::class, 'edit'])->name('edit')->middleware(['permission:access-all|loan-edit']);
        Route::put('update/{id}', [ClientLoanController::class, 'update'])->name('update')->middleware(['permission:access-all|loan-edit']);
        Route::get('delete/{id}', [ClientLoanController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|loan-delete']);
    });

    Route::prefix('profit')->as('profit.')->group(function () {
        Route::get('/', [ProfitController::class, 'index'])->name('index');
    });
    Route::prefix('total')->as('total.')->group(function () {
        Route::get('/balance/report', [ProfitController::class, 'totalBalanceReport'])->name('balance.report');
    });

    // Receive Category routes
    Route::resource('receive-category', ReceiveCategoryController::class)->except('destroy');
    Route::prefix('receive-category')->as('receive-category.')->group(function () {

        Route::get('/', [ReceiveCategoryController::class, 'index'])->name('index')->middleware(['permission:access-all|receive-category-visibility']);
        Route::get('create', [ReceiveCategoryController::class, 'create'])->name('create')->middleware(['permission:access-all|receive-category-create']);
        Route::post('store', [ReceiveCategoryController::class, 'store'])->name('store')->middleware(['permission:access-all|receive-category-create']);
        Route::get('view/{id}', [ReceiveCategoryController::class, 'show'])->name('view')->middleware(['permission:access-all|receive-category-view|receive-category-visibility']);
        Route::get('edit/{id}', [ReceiveCategoryController::class, 'edit'])->name('edit')->middleware(['permission:access-all|receive-category-edit']);
        Route::put('update/{id}', [ReceiveCategoryController::class, 'update'])->name('update')->middleware(['permission:access-all|receive-category-edit']);
        Route::get('delete/{id}', [ReceiveCategoryController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|receive-category-delete']);
    });

    // Account routes
    Route::prefix('expense')->as('expense.')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index')->middleware(['permission:access-all|expense-visibility']);
        Route::get('create', [ExpenseController::class, 'create'])->name('create')->middleware(['permission:access-all|expense-create']);
        Route::post('store', [ExpenseController::class, 'store'])->name('store')->middleware(['permission:access-all|expense-create']);
        Route::get('view/{id}', [ExpenseController::class, 'show'])->name('view')->middleware(['permission:access-all|expense-view|expense-visibility']);
        Route::get('edit/{id}', [ExpenseController::class, 'edit'])->name('edit')->middleware(['permission:access-all|expense-edit']);
        Route::put('update/{id}', [ExpenseController::class, 'update'])->name('update')->middleware(['permission:access-all|expense-edit']);
        Route::get('delete/{id}', [ExpenseController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|expense-delete|staff-payment-delete']);

        // permission needed
        Route::get('/client-loan', [ExpenseController::class, 'clientLoan'])->name('client.loan');
        Route::get('/client-money-return', [ExpenseController::class, 'clientMoneyReturn'])->name('client.money_return');

        Route::get('/staff-payment', [ExpenseController::class, 'staffPayment'])->name('staff.payment')->middleware(['permission:access-all|staff-payment-visibility']);
        Route::post('staff/payment/store', [ExpenseController::class, 'staffPaymentStore'])->name('staff.payment.store')->middleware(['permission:access-all|staff-payment-create']);
        Route::post('staff/payment/update', [ExpenseController::class, 'staffPaymentUpdate'])->name('staff.payment.update')->middleware(['permission:access-all|staff-payment-edit']);
    });


    // Bill Invoice
    Route::prefix('invoice')->as('invoice.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index')->middleware(['permission:access-all|invoice-visibility|draft-invoice-visibility']);
        Route::get('sales-return', [InvoiceController::class, 'salesReturn'])->name('sales.return')->middleware(['permission:access-all|invoice-visibility|draft-invoice-visibility']);
        Route::get('create', [InvoiceController::class, 'create'])->name('create')->middleware(['permission:access-all|invoice-create|draft-invoice-create']);
        Route::get('create-return', [InvoiceController::class, 'create'])->name('create.return')->middleware(['permission:access-all|invoice-visibility|draft-invoice-visibility']);
        Route::get('create-draft', [InvoiceController::class, 'create'])->name('create.draft')->middleware(['permission:access-all|invoice-visibility|draft-invoice-visibility']);
        Route::post('store', [InvoiceController::class, 'store'])->name('store')->middleware(['permission:access-all|invoice-create|draft-invoice-create', 'check_limitation']);
        Route::get('view/{id}', [InvoiceController::class, 'show'])->name('show')->middleware(['permission:access-all|invoice-view|draft-invoice-view|invoice-visibility|draft-invoice-visibility']);
        Route::get('challan/{id}', [InvoiceController::class, 'challan'])->name('challan')->middleware(['permission:access-all|invoice-view|draft-invoice-view|invoice-visibility|draft-invoice-visibility']);
        Route::get('pos/view/{id}', [InvoiceController::class, 'posShow'])->name('pos.show')->middleware(['permission:access-all|invoice-view|draft-invoice-view|invoice-visibility|draft-invoice-visibility']);
        Route::get('edit/{id}', [InvoiceController::class, 'edit'])->name('edit')->middleware(['permission:access-all|invoice-edit|draft-invoice-edit']);
        Route::put('update/{id}', [InvoiceController::class, 'update'])->name('update')->middleware(['permission:access-all|invoice-edit|draft-invoice-edit']);
        Route::get('delete/{id}', [InvoiceController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|invoice-delete|draft-invoice-delete']);
        Route::get('share/{id}', [InvoiceController::class, 'shareInvoice'])->name('share.invoice')->middleware(['permission:access-all|invoice-delete|draft-invoice-delete']);

        Route::get('delete/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
        Route::get('delete-item/{id}', [InvoiceController::class, 'destroyItem'])->name('destroy.item');
    });

    Route::prefix('order')->as('order.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::post('/change/status/{order_id}/{status}', [OrderController::class, 'changeStatus'])->name('change.status')->middleware(['permission:access-all']);
        Route::get('order/view/{id}', [OrderController::class, 'view'])->name('view')->middleware(['permission:access-all']);
    });

    // Branch routes
    Route::prefix('branch')->as('branch.')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('index')->middleware(['permission:access-all|branch-visibility']);
        Route::get('create', [BranchController::class, 'create'])->name('create')->middleware(['permission:access-all|branch-create']);
        Route::post('store', [BranchController::class, 'store'])->name('store')->middleware(['permission:access-all|branch-create']);
        Route::get('view/{id}', [BranchController::class, 'show'])->name('view')->middleware(['permission:access-all|branch-view|branch-visibility']);
        Route::get('edit/{id}', [BranchController::class, 'edit'])->name('edit')->middleware(['permission:access-all|branch-edit']);
        Route::put('update/{id}', [BranchController::class, 'update'])->name('update')->middleware(['permission:access-all|branch-edit']);
        Route::get('delete/{id}', [BranchController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|branch-delete']);
    });

    // transfer routes
    Route::prefix('transfer')->as('transfer.')->group(function () {
        Route::get('/', [TransferController::class, 'index'])->name('index')->middleware(['permission:access-all|transfer-visibility']);
        Route::get('create', [TransferController::class, 'create'])->name('create')->middleware(['permission:access-all|transfer-create']);
        Route::post('store', [TransferController::class, 'store'])->name('store')->middleware(['permission:access-all|transfer-create']);
        Route::get('view/{id}', [TransferController::class, 'show'])->name('view')->middleware(['permission:access-all|transfer-view|transfer-visibility']);
        Route::get('edit/{id}', [TransferController::class, 'edit'])->name('edit')->middleware(['permission:access-all|transfer-edit']);
        Route::put('update/{id}', [TransferController::class, 'update'])->name('update')->middleware(['permission:access-all|transfer-edit']);
        Route::get('delete/{id}', [TransferController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|transfer-delete']);
    });

    // Configurtion routes
    Route::resource('config', ConfigController::class);
    Route::prefix('config')->as('config.')->group(function () {});

    // Project routes
    Route::prefix('project')->as('project.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index')->middleware(['permission:access-all|project-visibility']);
        Route::get('create', [ProjectController::class, 'create'])->name('create')->middleware(['permission:access-all|project-create']);
        Route::post('store', [ProjectController::class, 'store'])->name('store')->middleware(['permission:access-all|project-create']);
        Route::get('view/{id}', [ProjectController::class, 'show'])->name('view')->middleware(['permission:access-all|project-view|project-visibility']);
        Route::get('edit/{id}', [ProjectController::class, 'edit'])->name('edit')->middleware(['permission:access-all|project-edit']);
        Route::put('update/{id}', [ProjectController::class, 'update'])->name('update')->middleware(['permission:access-all|project-edit']);
        Route::get('delete/{id}', [ProjectController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|project-delete']);
    });

    // Asset And Stock routes
    Route::prefix('asset/and/stock')->as('asset-and-stock.')->group(function () {
        Route::get('/', [AssetAndStockController::class, 'index'])->name('index')->middleware(['permission:access-all|asset-n-stock-visibility']);
        Route::get('create', [AssetAndStockController::class, 'create'])->name('create')->middleware(['permission:access-all|asset-n-stock-create']);
        Route::post('store', [AssetAndStockController::class, 'store'])->name('store')->middleware(['permission:access-all|asset-n-stock-create']);
        Route::get('view/{id}', [AssetAndStockController::class, 'show'])->name('view')->middleware(['permission:access-all|asset-n-stock-view|asset-n-stock-visibility']);
        Route::get('edit/{id}', [AssetAndStockController::class, 'edit'])->name('edit')->middleware(['permission:access-all|asset-n-stock-edit']);
        Route::put('update/{id}', [AssetAndStockController::class, 'update'])->name('update')->middleware(['permission:access-all|asset-n-stock-edit']);
        Route::get('delete/{id}', [AssetAndStockController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|asset-n-stock-delete']);
    });

    // Metarial routes
    Route::resource('metarial', MetarialController::class);
    Route::prefix('metarial')->as('metarial.')->group(function () {

        Route::get('/', [MetarialController::class, 'index'])->name('index')->middleware(['permission:access-all|raw-material-visibility']);
        Route::get('create', [MetarialController::class, 'create'])->name('create')->middleware(['permission:access-all|raw-material-create']);
        Route::post('store', [MetarialController::class, 'store'])->name('store')->middleware(['permission:access-all|raw-material-create']);
        Route::get('view/{id}', [MetarialController::class, 'show'])->name('view')->middleware(['permission:access-all|raw-material-view|raw-material-visibility']);
        Route::get('edit/{id}', [MetarialController::class, 'edit'])->name('edit')->middleware(['permission:access-all|raw-material-edit']);
        Route::put('update/{id}', [MetarialController::class, 'update'])->name('update')->middleware(['permission:access-all|raw-material-edit']);
        Route::get('delete/{id}', [MetarialController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|raw-material-delete']);

        //       extra
        Route::get('/raw-metarial-list', [MetarialController::class, 'metarialList'])->name('metarial.list');
        Route::get('/raw-metarial-stock', [MetarialController::class, 'metarialStock'])->name('metarial.stock');
        Route::get('/raw-metarial-buy', [MetarialController::class, 'metarialBuy'])->name('metarial.buy');
        Route::get('/raw-metarial-group', [MetarialController::class, 'metarialGroup'])->name('group.old');
        //       extra

        Route::get('/buy/metarial', [MetarialController::class, 'buyMetarial'])->name('buy');
        Route::get('/metarial/stock', [MetarialController::class, 'stockMetarial'])->name('stock');
        Route::get('/metarial/group', [MetarialController::class, 'groupMetarial'])->name('group');
    });

    // Batch Product Route routes
    Route::prefix('batch-product')->as('batchProduct.')->group(function () {
        Route::get('/', [BatchProductController::class, 'index'])->name('index')->middleware(['permission:access-all|batch-product-visibility']);
        Route::get('create', [BatchProductController::class, 'create'])->name('create')->middleware(['permission:access-all|batch-product-create']);
        Route::post('store', [BatchProductController::class, 'store'])->name('store')->middleware(['permission:access-all|batch-product-create']);
        Route::get('view/{id}', [BatchProductController::class, 'show'])->name('view')->middleware(['permission:access-all|batch-product-view|batch-product-visibility']);
        Route::get('edit/{id}', [BatchProductController::class, 'edit'])->name('edit')->middleware(['permission:access-all|batch-product-edit']);
        Route::put('update/{id}', [BatchProductController::class, 'update'])->name('update')->middleware(['permission:access-all|batch-product-edit']);
        Route::get('delete/{id}', [BatchProductController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|batch-product-delete']);

        Route::get('/batch-product/transfer', [BatchProductController::class, 'BatchProductTransfer'])->name('transfer');
        Route::get('/batch-product/transfer/report', [BatchProductController::class, 'BatchProductTransferReport'])->name('transfer.report');
    });

    // Product Route routes
    Route::prefix('product')->as('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index')->middleware(['permission:access-all|product-visibility']);
        Route::get('create', [ProductController::class, 'create'])->name('create')->middleware(['permission:access-all|product-create']);
        Route::post('store', [ProductController::class, 'store'])->name('store')->middleware(['permission:access-all|product-create', 'check_limitation']);
        Route::get('view/{id}', [ProductController::class, 'show'])->name('view')->middleware(['permission:access-all|product-view|product-visibility']);
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-edit']);
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update')->middleware(['permission:access-all|product-edit']);
        Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-delete']);
    });

    Route::resource('warehouse', WarehouseController::class)->except('destroy');
    Route::prefix('warehouse')->as('warehouse.')->group(function () {
        Route::get('delete/{id}', [WarehouseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('purchase')->as('purchase.')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('index')->middleware(['permission:access-all|product-purchase-visibility']);
        Route::get('/invoice', [PurchaseController::class, 'invoice'])->name('invoice')->middleware(['permission:access-all|product-purchase-visibility']);
        Route::get('/report', [PurchaseController::class, 'report'])->name('report')->middleware(['permission:access-all|product-purchase-visibility']);
        Route::get('create', [PurchaseController::class, 'create'])->name('create')->middleware(['permission:access-all|product-purchase-create']);
        Route::post('store', [PurchaseController::class, 'store'])->name('store')->middleware(['permission:access-all|product-purchase-create']);
        Route::get('view/{id}', [PurchaseController::class, 'show'])->name('view')->middleware(['permission:access-all|product-purchase-view|product-purchase-visibility']);
        Route::get('edit/{id}', [PurchaseController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-purchase-edit']);
        Route::get('edit-page/{id}', [PurchaseController::class, 'goToEdit'])->name('goToEdit')->middleware(['permission:access-all|product-purchase-edit']);
        Route::post('update/{id}', [PurchaseController::class, 'update'])->name('update')->middleware(['permission:access-all|product-purchase-edit']);
        Route::get('delete/{id}', [PurchaseController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-purchase-delete']);
        Route::get('delete-item/{id}', [PurchaseController::class, 'destroyItem'])->name('destroy.item')->middleware(['permission:access-all|product-purchase-delete']);
        Route::get('/return', [PurchaseController::class, 'index'])->name('return')->middleware(['permission:access-all|product-purchase-return-visibility']);
        Route::get('/return/invoice', [PurchaseController::class, 'invoice'])->name('return.invoice')->middleware(['permission:access-all|product-purchase-return-visibility']);
        Route::get('/return/report', [PurchaseController::class, 'report'])->name('return.report')->middleware(['permission:access-all|product-purchase-return-visibility']);
    });

    // Stock controller
    Route::prefix('stock')->as('stock.')->group(function () {
        Route::get('/', [ProductStockController::class, 'index'])->name('index')->middleware(['permission:access-all|product-visibility']);
    });

    //product group
    Route::prefix('product-group')->as('product-group.')->group(function () {
        Route::get('/', [ProductGroupController::class, 'index'])->name('index')->middleware(['permission:access-all|product-group-visibility']);
        Route::get('create', [ProductGroupController::class, 'create'])->name('create')->middleware(['permission:access-all|product-group-create']);
        Route::post('store', [ProductGroupController::class, 'store'])->name('store')->middleware(['permission:access-all|product-group-create']);
        Route::get('view/{id}', [ProductGroupController::class, 'show'])->name('view')->middleware(['permission:access-all|product-group-view|product-group-visibility']);
        Route::get('edit/{id}', [ProductGroupController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-group-edit']);
        Route::put('update/{id}', [ProductGroupController::class, 'update'])->name('update')->middleware(['permission:access-all|product-group-edit']);
        Route::get('delete/{id}', [ProductGroupController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-group-delete']);
    });
    //product Unit
    Route::prefix('product-unit')->as('product-unit.')->group(function () {
        Route::get('/', [ProductUnitController::class, 'index'])->name('index')->middleware(['permission:access-all|product-unit-visibility']);
        Route::get('create', [ProductUnitController::class, 'create'])->name('create')->middleware(['permission:access-all|product-unit-create']);
        Route::post('store', [ProductUnitController::class, 'store'])->name('store')->middleware(['permission:access-all|product-unit-create']);
        Route::get('view/{id}', [ProductUnitController::class, 'show'])->name('view')->middleware(['permission:access-all|product-unit-view|product-unit-visibility']);
        Route::get('edit/{id}', [ProductUnitController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-unit-edit']);
        Route::put('update/{id}', [ProductUnitController::class, 'update'])->name('update')->middleware(['permission:access-all|product-unit-edit']);
        Route::get('delete/{id}', [ProductUnitController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-unit-delete']);
    });
    //product asset
    Route::prefix('product-asset')->as('product-asset.')->group(function () {
        Route::get('/', [ProductAssetController::class, 'index'])->name('index')->middleware(['permission:access-all|product-asset-visibility']);
        Route::get('create', [ProductAssetController::class, 'create'])->name('create')->middleware(['permission:access-all|product-asset-create']);
        Route::post('store', [ProductAssetController::class, 'store'])->name('store')->middleware(['permission:access-all|product-asset-create']);
        Route::get('view/{id}', [ProductAssetController::class, 'show'])->name('view')->middleware(['permission:access-all|product-asset-view|product-asset-visibility']);
        Route::get('edit/{id}', [ProductAssetController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-asset-edit']);
        Route::put('update/{id}', [ProductAssetController::class, 'update'])->name('update')->middleware(['permission:access-all|product-asset-edit']);
        Route::get('delete/{id}', [ProductAssetController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-asset-delete']);
    });

    //product Barcode
    Route::prefix('product-barcode')->as('product-barcode.')->group(function () {
        Route::get('/', [ProductBarcodeController::class, 'index'])->name('index')->middleware(['permission:access-all|product-barcode-visibility']);
        Route::get('create', [ProductBarcodeController::class, 'create'])->name('create')->middleware(['permission:access-all|product-barcode-create']);
        Route::post('store', [ProductBarcodeController::class, 'store'])->name('store')->middleware(['permission:access-all|product-barcode-create']);
        Route::get('view/{id}', [ProductBarcodeController::class, 'show'])->name('view')->middleware(['permission:access-all|product-barcode-view|product-barcode-visibility']);
        Route::get('edit/{id}', [ProductBarcodeController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-barcode-edit']);
        Route::put('update/{id}', [ProductBarcodeController::class, 'update'])->name('update')->middleware(['permission:access-all|product-barcode-edit']);
        Route::get('delete/{id}', [ProductBarcodeController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-barcode-delete']);
    });


    //product Buy Return
    // Route::prefix('product-return')->as('product-return.')->group(function () {
    //     Route::get('/', [ProductReturnController::class, 'index'])->name('index')->middleware(['permission:access-all|product-return-visibility']);
    //     Route::get('create', [ProductReturnController::class, 'create'])->name('create')->middleware(['permission:access-all|product-return-create']);
    //     Route::post('store', [ProductReturnController::class, 'store'])->name('store')->middleware(['permission:access-all|product-return-create']);
    //     Route::get('view/{id}', [ProductReturnController::class, 'show'])->name('view')->middleware(['permission:access-all|product-return-view|product-return-visibility']);
    //     Route::get('edit/{id}', [ProductReturnController::class, 'edit'])->name('edit')->middleware(['permission:access-all|product-return-edit']);
    //     Route::put('update/{id}', [ProductReturnController::class, 'update'])->name('update')->middleware(['permission:access-all|product-return-edit']);
    //     Route::get('delete/{id}', [ProductReturnController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|product-return-delete']);
    // });


    Route::prefix('configuration')->as('configuration.')->group(function () {

        //configuration route start

        // Receive Subcategory routes
        Route::resource('receive-subcategory', ReceiveSubcategoryController::class)->except('destroy');
        Route::prefix('receive-subcategory')->as('receive-subcategory.')->group(function () {
            Route::get('delete/{id}', [ReceiveSubcategoryController::class, 'destroy'])->name('destroy');
        });

        // Expense Category routes
        Route::resource('expense-category', ExpenseCategoryController::class)->except('destroy');
        Route::prefix('expense-category')->as('expense-category.')->group(function () {
            Route::get('delete/{id}', [ExpenseCategoryController::class, 'destroy'])->name('destroy');
        });

        // Expense Subcategory routes
        Route::resource('expense-subcategory', ExpenseSubcategoryController::class)->except('destroy');
        Route::prefix('expense-subcategory')->as('expense-subcategory.')->group(function () {
            Route::get('delete/{id}', [ExpenseSubcategoryController::class, 'destroy'])->name('destroy');
        });

        // Chart Of Account routes
        Route::prefix('chart-of-account')->as('chart-of-account.')->group(function () {
            Route::get('/', [ChartOfAccountController::class, 'index'])->name('index')->middleware(['permission:access-all|coa-visibility']);
            Route::get('create', [ChartOfAccountController::class, 'create'])->name('create')->middleware(['permission:access-all|coa-create']);
            Route::post('store', [ChartOfAccountController::class, 'store'])->name('store')->middleware(['permission:access-all|coa-create']);
            Route::get('view/{id}', [ChartOfAccountController::class, 'show'])->name('view')->middleware(['permission:access-all|coa-view|coa-visibility']);
            Route::get('edit/{id}', [ChartOfAccountController::class, 'edit'])->name('edit')->middleware(['permission:access-all|coa-edit']);
            Route::put('update/{id}', [ChartOfAccountController::class, 'update'])->name('update')->middleware(['permission:access-all|coa-edit']);
            Route::get('delete/{id}', [ChartOfAccountController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|coa-delete']);
        });

        // Chart Of Account Group routes
        Route::prefix('chart-of-account-group')->as('chart-of-account-group.')->group(function () {
            Route::get('/', [ChartOfAccountGroupController::class, 'index'])->name('index')->middleware(['permission:access-all|coa-group-visibility']);
            Route::get('create', [ChartOfAccountGroupController::class, 'create'])->name('create')->middleware(['permission:access-all|coa-group-create']);
            Route::post('store', [ChartOfAccountGroupController::class, 'store'])->name('store')->middleware(['permission:access-all|coa-group-create']);
            Route::get('view/{id}', [ChartOfAccountGroupController::class, 'show'])->name('view')->middleware(['permission:access-all|coa-group-view|coa-group-visibility']);
            Route::get('edit/{id}', [ChartOfAccountGroupController::class, 'edit'])->name('edit')->middleware(['permission:access-all|coa-group-edit']);
            Route::put('update/{id}', [ChartOfAccountGroupController::class, 'update'])->name('update')->middleware(['permission:access-all|coa-group-edit']);
            Route::get('delete/{id}', [ChartOfAccountGroupController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|coa-group-delete']);
        });

        // Chart Of Account  Subcategory  routes
        Route::prefix('chart-of-account-subcategory')->as('chart-of-account-subcategory.')->group(function () {
            Route::get('/', [ChartOfAccountSubcategoryController::class, 'index'])->name('index')->middleware(['permission:access-all|coa-subcategory-visibility']);
            Route::get('create', [ChartOfAccountSubcategoryController::class, 'create'])->name('create')->middleware(['permission:access-all|coa-subcategory-create']);
            Route::post('store', [ChartOfAccountSubcategoryController::class, 'store'])->name('store')->middleware(['permission:access-all|coa-subcategory-create']);
            Route::get('view/{id}', [ChartOfAccountSubcategoryController::class, 'show'])->name('view')->middleware(['permission:access-all|coa-subcategory-view|coa-subcategory-visibility']);
            Route::get('edit/{id}', [ChartOfAccountSubcategoryController::class, 'edit'])->name('edit')->middleware(['permission:access-all|coa-subcategory-edit']);
            Route::put('update/{id}', [ChartOfAccountSubcategoryController::class, 'update'])->name('update')->middleware(['permission:access-all|coa-subcategory-edit']);
            Route::get('delete/{id}', [ChartOfAccountSubcategoryController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|coa-subcategory-delete']);
        });

        // Shortcut menu  routes
        Route::prefix('shortcut-menu')->as('shortcut-menu.')->group(function () {
            Route::get('/', [ShortcutMenuController::class, 'index'])->name('index')->middleware(['permission:access-all|shortcut-menu-visibility']);
            Route::get('create', [ShortcutMenuController::class, 'create'])->name('create')->middleware(['permission:access-all|shortcut-menu-create']);
            Route::post('store', [ShortcutMenuController::class, 'store'])->name('store')->middleware(['permission:access-all|shortcut-menu-create']);
            Route::get('view/{id}', [ShortcutMenuController::class, 'show'])->name('view')->middleware(['permission:access-all|shortcut-menu-view|shortcut-menu-visibility']);
            Route::get('edit/{id}', [ShortcutMenuController::class, 'edit'])->name('edit')->middleware(['permission:access-all|shortcut-menu-edit']);
            Route::put('update/{id}', [ShortcutMenuController::class, 'update'])->name('update')->middleware(['permission:access-all|shortcut-menu-edit']);
            Route::get('delete/{id}', [ShortcutMenuController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|shortcut-menu-delete']);
        });

        // Payment Method  routes
        Route::prefix('payment-method')->as('payment-method.')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('index')->middleware(['permission:access-all|payment-method-visibility']);
            Route::get('create', [PaymentMethodController::class, 'create'])->name('create')->middleware(['permission:access-all|payment-method-create']);
            Route::post('store', [PaymentMethodController::class, 'store'])->name('store')->middleware(['permission:access-all|payment-method-create']);
            Route::get('view/{id}', [PaymentMethodController::class, 'show'])->name('view')->middleware(['permission:access-all|payment-method-view|payment-method-visibility']);
            Route::get('edit/{id}', [PaymentMethodController::class, 'edit'])->name('edit')->middleware(['permission:access-all|payment-method-edit']);
            Route::put('update/{id}', [PaymentMethodController::class, 'update'])->name('update')->middleware(['permission:access-all|payment-method-edit']);
            Route::get('delete/{id}', [PaymentMethodController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|payment-method-delete']);
        });

        // Company Information routes
        Route::prefix('company-information')->as('company-information.')->group(function () {
            Route::get('/', [CompanyInformationController::class, 'index'])->name('index')->middleware(['permission:access-all|company-information-visibility']);
            Route::get('edit/{id}', [CompanyInformationController::class, 'edit'])->name('edit')->middleware(['permission:access-all|company-information-edit']);
            Route::put('update/{id}', [CompanyInformationController::class, 'update'])->name('update')->middleware(['permission:access-all|company-information-edit']);
        });
        // Bank routes
        Route::prefix('bank')->as('bank.')->group(function () {
            Route::get('/', [BankController::class, 'index'])->name('index')->middleware(['permission:access-all|bank-visibility']);
            Route::get('create', [BankController::class, 'create'])->name('create')->middleware(['permission:access-all|bank-create']);
            Route::post('store', [BankController::class, 'store'])->name('store')->middleware(['permission:access-all|bank-create']);
            Route::get('view/{id}', [BankController::class, 'show'])->name('view')->middleware(['permission:access-all|bank-view|bank-visibility']);
            Route::get('edit/{id}', [BankController::class, 'edit'])->name('edit')->middleware(['permission:access-all|bank-edit']);
            Route::put('update/{id}', [BankController::class, 'update'])->name('update')->middleware(['permission:access-all|bank-edit']);
            Route::get('delete/{id}', [BankController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all|bank-delete']);
        });
    });

    //Due Report Routes
    Route::prefix('report')->as('report.')->group(function () {
        Route::prefix('due-report')->as('due-report.')->middleware(['permission:access-all|due-report'])->group(function () {
            Route::get('/', [DueReportController::class, 'index'])->name('index');
            Route::get('customerwise/report', [DueReportController::class, 'customerwiseReport'])->name('customer.wise');
            Route::get('groupwise/report', [DueReportController::class, 'groupwiseReport'])->name('group.wise');
        });
        Route::prefix('deposit')->as('deposit.')->middleware(['permission:access-all|receive-report'])->group(function () {
            Route::get('all', [DepositReportsController::class, 'all'])->name('all');
            Route::get('category/wise', [DepositReportsController::class, 'categoryWise'])->name('category.wise');
            Route::get('customer/wise', [DepositReportsController::class, 'customerWise'])->name('customer.wise');
        });
        Route::prefix('expense')->as('expense.')->middleware(['permission:access-all|expense-report'])->group(function () {
            Route::get('all', [ExpenseReportController::class, 'all'])->name('all');
            Route::get('category/wise', [ExpenseReportController::class, 'categoryWise'])->name('category.wise');
            Route::get('subcategory/wise', [ExpenseReportController::class, 'subCategoryWise'])->name('subcategory.wise');
            Route::get('customer/wise', [ExpenseReportController::class, 'customerWise'])->name('customer.wise');
            Route::get('supplier/payment', [ExpenseReportController::class, 'supplierPayment'])->name('supplier.payment.report');
        });
        Route::prefix('sales')->as('sales.')->middleware(['permission:access-all|sales-report'])->group(function () {
            Route::get('/', [SalesReportController::class, 'index'])->name('index');
            Route::get('/sales', [SalesReportController::class, 'sales'])->name('sales');
            Route::get('/customer/wise', [SalesReportController::class, 'salesCustomerWise'])->name('sales.customer.wise');
            Route::get('product-wise', [SalesReportController::class, 'productWise'])->name('product.wise');
        });
    });

    Route::prefix('slider')->as('slider.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::post('store', [SliderController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [SliderController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [SliderController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [SliderController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all']);
    });

    Route::prefix('banner')->as('banner.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::post('store', [BannerController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [BannerController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [BannerController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all']);
    });

    Route::prefix('brand')->as('brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::post('store', [BrandController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [BrandController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [BrandController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [BrandController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all']);
    });

    Route::prefix('category')->as('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::get('create', [CategoryController::class, 'create'])->name('create')->middleware(['permission:access-all']);
        Route::post('store', [CategoryController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [CategoryController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all']);
        Route::post('category/{category}/status', [CategoryController::class, 'updateStatus'])->name('status');
    });

    Route::prefix('subcategory')->as('subcategory.')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::get('create', [SubCategoryController::class, 'create'])->name('create')->middleware(['permission:access-all']);
        Route::post('store', [SubCategoryController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [SubCategoryController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [SubCategoryController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [SubCategoryController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all']);
    });

    Route::prefix('subsubcategory')->as('subsubcategory.')->group(function () {
        Route::get('/', [SubSubCategoryController::class, 'index'])->name('index')->middleware(['permission:access-all']);
        Route::get('create', [SubSubCategoryController::class, 'create'])->name('create')->middleware(['permission:access-all']);
        Route::post('store', [SubSubCategoryController::class, 'store'])->name('store')->middleware(['permission:access-all']);
        Route::get('edit/{id}', [SubSubCategoryController::class, 'edit'])->name('edit')->middleware(['permission:access-all']);
        Route::put('update/{id}', [SubSubCategoryController::class, 'update'])->name('update')->middleware(['permission:access-all']);
        Route::get('delete/{id}', [SubSubCategoryController::class, 'destroy'])->name('destroy')->middleware(['permission:access-all']);
    });

    // settings routes
    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => 'permission:access-all|settings'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/update-colors', [SettingsController::class, 'updateColors'])->name('update.colors');
        Route::get('/update-credentials', [SettingsController::class, 'updateCredentials'])->name('update.credentials');
        Route::get('/reset-colors', [SettingsController::class, 'resetColor'])->name('reset.colors');
        Route::get('/update-sms', [SettingsController::class, 'updateSmsFormat'])->name('update.sms');
        Route::get('/check-sms-balance', [SettingsController::class, 'checkSmsBalance'])->name('check.sms.balance');

        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('store', [RoleController::class, 'store'])->name('store');
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [RoleController::class, 'update'])->name('update');
            Route::get('delete/{id}', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('give/permission/{id}', [RoleController::class, 'givePermission'])->name('give.permission');
            Route::post('give/permission/{id}', [RoleController::class, 'saveAssignedPermission'])->name('save.assigned.permission');
        });

        Route::get('/backup-log', [BackupLogController::class, 'backupLogs'])->name('backup.log');

        Route::prefix('server/info')->as('server.info.')->group(function () {
            Route::get('/', [ServerInfoController::class, 'index'])->name('index');
        });
    });

    Route::group(['prefix' => 'activity/logs', 'as' => 'log.'], function () {
        Route::get('/deleted', [DeleteLogController::class, 'deleted'])->name('deleted');
    });

    Route::group(['prefix' => 'sms', 'as' => 'sms.'], function () {
        Route::get('send-to-client', [SmsManagerController::class, 'sendToClient'])->name('send.to.client');
        Route::get('send-to-client-group', [SmsManagerController::class, 'sendToClientGroup'])->name('send.to.client.group');
        Route::get('send-to-supplier', [SmsManagerController::class, 'sendToSupplier'])->name('send.to.supplier');
        Route::get('send-to-supplier-group', [SmsManagerController::class, 'sendToSupplierGroup'])->name('send.to.supplier.group');
        Route::get('send-schedule-wise', [SmsManagerController::class, 'sendScheduleWise'])->name('send.schedule.wise');
        Route::get('schedule-sms/report', [SmsManagerController::class, 'scheduleSmsReport'])->name('schedule.sms.report');
    });

    Route::get('/backup/database', function () {
        try {
            $databaseName = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $backupFileName = 'backup_' . date('Y:m:d:H:i:s') . '.sql';

            $command = "mysqldump -u{$username} -p{$password} {$databaseName} > storage/app/{$backupFileName}";

            // Execute the command
            exec($command);

            // Download the created backup
            $filePath = storage_path("app/{$backupFileName}");

            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            toastr()->success('Failed to create database backup ', $e->getMessage());
            return redirect()->back();
        }
    })->name('backup.db');


    // Backup Database into csv
    Route::prefix('backup')->as('backup.')->group(function () {
        Route::get('download', [BackupDatabaseController::class, 'download'])->name('download');
        Route::get('download/locally', [BackupDatabaseController::class, 'downloadLocally'])->name('download.locally');
        Route::get('get/drive/permission', [BackupDatabaseController::class, 'getPermissionToDriveBackup'])->name('get.drive.permission');
    });

    Route::prefix('bulk')->as('bulk.')->group(function () {
        Route::get('/', [BulkManagementController::class, 'index'])->name('index');
        Route::post('/upload', [BulkManagementController::class, 'uploadJson'])->name('upload');
    });
});
Route::get('/oauth2callback', [BackupDatabaseController::class, 'handleOAuth2Callback'])->name('handle.oauth2callback');
Route::get('/start-google-auth', [BackupDatabaseController::class, 'startGoogleDriveAuth'])->name('start.google.auth');
