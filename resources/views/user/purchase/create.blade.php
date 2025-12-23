@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
    @endphp
    <div class="main-content-body">
        <div class="card mb-5 pb-5">
            <div class="card-header border-bottom d-flex justify-content-between">
                <div>
                    @if (request()->has('purchase-return'))
                        <h6 class="card-title my-0" id="addInvoiceText">{{ __('messages.purchase') }} {{ __('messages.return') }}</h6>
                    @else
                        <h6 class="card-title my-0" id="addInvoiceText">{{ __('messages.purchase') }} {{ __('messages.create') }}</h6>
                    @endif
                    <h6 class="card-title d-none" id="updateInvoiceText">{{ __('messages.update') }} {{ __('messages.purchase') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                </div>
                <div class="d-flex">
                    {{-- <a href="javascript:;" id="uploadBulkFile" class="btn btn-secondary text-white me-2"><i class="fas fa-upload d-inline"></i> {{ __('messages.bulk_upload') }}</a>
                    <a href="{{ route('download.purchase.bulk') }}" class="btn btn-secondary text-white me-2"><i class="fas fa-download d-inline"></i> {{ __('messages.download_bulk_file') }}</a> --}}
                    <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2 d-flex align-items-center">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- form field start --}}
                <div class="row justify-content-between" id="invoice-form">
                    <div class="{{ config('purchases_supplier_id') == 1 ? '' : 'd-none' }} form-group mb-1 col-md-6">
                        <div class="d-flex form-group mb-0" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                            <div class="input-group">
                                <select name="supplier_id" id="supplier_id" class="form-control select2">
                                </select>
                            </div>
                            <a id="supplierAddModalBtn" class="add-btn btn btn-success" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="supplier_id_Error"></span>

                        {{-- <div class="mb-1">
                            asdfasdf
                        </div> --}}
                    </div>
                    <div class="{{ config('purchases_issued_date') == 1 ? '' : 'd-none' }} col-md-6">
                        <div class="form-group">
                            <input name="issued_date" id="issued_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ date('d/m/Y') }}" type="text" autocomplete="off">
                            <label class="animated-label active-label" for="issued_date"><i class="fas fa-balance-scale"></i> {{ __('messages.date') }}</label>
                        </div>
                        <span class="text-danger small" id="issued_date_Error"></span>

                        <div class="{{ config('purchases_invoice_id') == 1 ? '' : 'd-none' }} mb-1">
                            <div class="form-group">
                                <input id="invoice_id" type="number" name="invoice_id" class="form-control" value="" placeholder="Invoice Id">
                                <label for="invoice_id" class="animated-label active-label"><i class="fas fa-list-ol"></i> {{ __('messages.invoice') }} {{ __('messages.id_no') }}</label>
                            </div>
                        </div>
                    </div>
                    @if (config('sidebar.warehouse') == 1)
                        <div class="{{ config('purchases_warehouse_id') == 1 ? '' : 'd-none' }} form-group mb-1 col-md-6">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.ware_house') }}">
                                <div class="input-group">
                                    <select name="warehouse_id" id="warehouse_id" class="form-control select2"></select>
                                </div>
                                <a id="warehouseAddModalBtn" class="add-btn btn btn-success" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="warehouse_id_Error"></span>
                        </div>
                    @endif
                    <div class="form-group mb-4 col-md-12">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.product') }} {{ __('messages.name') }}">
                            <div class="input-group">
                                <select id="product_search" class="form-control select2">
                                </select>
                            </div>
                            <a id="productAddModalBtn" class="add-btn btn border disabled" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="col-12 mb-4 table-responsive">
                        <table class="table table-secondary" id="order_table">
                            <thead>
                                <th class="py-2 text-center">{{ __('messages.sl') }}</th>
                                <th class="py-2 text-center">{{ __('messages.product') }}</th>
                                <th class="py-2 text-center">{{ __('messages.quantity') }}</th>
                                <th class="py-2 text-center">{{ __('messages.buying') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.total') }} {{ __('messages.buying') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.sale') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.total') }} {{ __('messages.sale') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.wholesale_price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.unit') }}</th>
                                <th class="py-2 text-center">{{ __('messages.description') }}</th>
                                <th class="py-2 text-center">{{ __('messages.barcode') }}</th>
                                <th class="py-2 text-center">{{ __('messages.action') }}</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 ps-0">
                        <div class="{{ config('purchases_discount') == 1 ? '' : 'd-none' }} form-group mb-0 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="discount" id="discount" class="form-control clear-input" placeholder="{{ __('messages.discount') }}" value="0" type="number" min="0" max="100" autocomplete="off">
                                        <label class="animated-label active-label" for="discount"><i class="fas fa-balance-scale"></i> {{ __('messages.discount') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="discount_type" id="discount_type" class="form-control SelectBox" required>
                                            <option label="Flat" selected></option>
                                            <option value="percentage">{{ __('messages.percentage') }} (%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger small" id="discount_Error"></span>
                        </div>

                        <div class="{{ config('purchases_transport_fare') == 1 ? ($queryString == 'purchase-return' ? 'd-none' : '') : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="transport_fare" id="transport_fare" class="form-control clear-input" placeholder="{{ __('messages.transport_fare') }}" value="0" min="0" type="number">
                                <label class="animated-label active-label" for="transport_fare"><i class="fas fa-balance-scale"></i> {{ __('messages.transport_fare') }}</label>
                            </div>
                            <span class="text-danger small" id="transport_fare_Error"></span>
                        </div>

                        <div class="{{ config('purchases_vat') == 1 ? ($queryString == 'purchase-return' ? 'd-none' : '') : 'd-none' }} form-group mb-0 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="vat" id="vat" class="form-control clear-input" placeholder="{{ __('messages.vat') }}" value="0" type="text" autocomplete="off">
                                        <label class="animated-label active-label" for="vat"><i class="fas fa-balance-scale"></i> {{ __('messages.vat') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="vat_type" id="vat_type" class="form-control SelectBox" required>
                                            <option label="Flat"></option>
                                            <option value="percentage" selected>{{ __('messages.percentage') }} (%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger small" id="vat_Error"></span>
                        </div>

                        <div class="{{ config('purchases_account_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.account') }}">
                                <div class="input-group">
                                    <select name="account_id" id="account_id" class="form-control select2 account_id"></select>
                                </div>
                                <a id="accountAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="account_id_Error"></span>
                        </div>

                        @if ($queryString == 'purchase-return')
                            <div class="{{ config('purchases_category_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                                <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.receive') . ' ' . __('messages.category') }}">
                                    <div class="input-group">
                                        <select name="category_id" id="receive_category_id" class="form-control select2"></select>
                                    </div>
                                    <a id="receiveCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="receive_category_id_Error"></span>
                            </div>
                        @else
                            <div class="{{ config('purchases_category_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                                <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.expense') . ' ' . __('messages.category') }}">
                                    <div class="input-group">
                                        <select name="category_id" id="expense_category_id" class="form-control select2"></select>
                                    </div>
                                    <a id="expenseCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="expense_category_id_Error"></span>
                            </div>
                        @endif
                        <div class="{{ config('purchases_receive_amount') == 1 ? '' : 'd-none' }} {{ $queryString == 'purchase-return' ? '' : '' }} col-md-12">
                            <div class="form-group">
                                <input name="receive_amount" id="receive_amount" class="form-control clear-input" value="0" min="0" type="number" step="any" autocomplete="off" placeholder="{{ __('messages.payment') }} {{ __('messages.amount') }}">
                                <label class="animated-label active-label" for="receive_amount"><i class="fas fa-balance-scale"></i> {{ __('messages.payment') }} {{ __('messages.amount') }}</label>
                            </div>
                            <span class="text-danger small" id="receive_amount_Error"></span>
                        </div>

                        <input type="hidden" id="pucrhased_row_id">
                    </div>
                    <div class="col-md-4">
                        <table class="table table-borderless">
                            <tr class="border">
                                <td width="50%">{{ __('messages.total') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 purchase_bill" id="purchase_bill" name="purchase_bill" readonly value="0"></td>
                            </tr>
                            <tr class="border {{ $queryString == 'purchase-return' ? 'd-none' : '' }}">
                                <td width="50%">{{ __('messages.vat') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_vat" id="total_vat" name="total_vat" readonly value="0"></td>
                            </tr>
                            <tr class="border {{ $queryString == 'purchase-return' ? 'd-none' : '' }}">
                                <td width="50%">{{ __('messages.transport_fare') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 transport_fare" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.discount') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_discount" id="total_discount" name="total_discount" readonly value="0"></td>
                            </tr>

                            <tr class="border">
                                <td width="50%">{{ __('messages.grand_total') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 grand_total" id="grand_total" name="grand_total" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.payment') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_payment" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.total') }} {{ $queryString == 'purchase-return' ? __('messages.return') : __('messages.due') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_due" id="total_due" name="total_due" readonly value="0"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- form field end --}}
            </div>
            <div class="card-body d-flex justify-content-center fixed-bottom bg-white border rounded-0" id="button-group">
                {{-- <button class="btn me-1 btn-danger" data-bs-toggle="collapse" data-bs-target="#invoiceCollapse" aria-expanded="false" aria-controls="invoiceCollapse" type="button">{{ __('messages.cancel') }}</button> --}}
                <button class="btn mx-1 btn-success" type="button" id="addInvoice" onclick="addInvoice();"><i class="fas fa-save"></i> {{ $queryString == 'purchase-return' ? __('messages.return') : __('messages.buy_product') }}</button>
                <button class="btn ms-1 btn-info d-none" type="button" id="updateInvoice" onclick="updateInvoice();"><i class="fas fa-save"></i> {{ __('messages.update') }}</button>
            </div>
        </div>
    </div>
    @include('user.accounts.account.account-modal')
    @include('user.accounts.expense.expense-category-modal')
    @include('user.accounts.receive.category.modal')
    @include('user.supplier.supplier-add-modal')
    @include('user.purchase.form-setting-modal')
@endsection
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    @include('user.purchase.purchase-js')

    <script>
        $(document).ready(function() {
            fetchProducts();
        });
    </script>
@endpush
