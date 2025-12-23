@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $erpdemo = request()->getHost() == 'erpdemo.bhisab.com';
    @endphp
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                </div>
                <div class="card-body">
                    <div class="d-lg-flex justify-content-lg-between">
                        <div>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link active" id="pills-general-tab" data-bs-toggle="pill" data-bs-target="#pills-general" type="button" role="tab" aria-controls="pills-general" aria-selected="true">{{ __('messages.general') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-invoice-tab" data-bs-toggle="pill" data-bs-target="#pills-invoice" type="button" role="tab" aria-controls="pills-invoice" aria-selected="false">{{ __('messages.invoice') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-receive-tab" data-bs-toggle="pill" data-bs-target="#pills-receive" type="button" role="tab" aria-controls="pills-receive" aria-selected="false">{{ __('messages.receive') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-expense-tab" data-bs-toggle="pill" data-bs-target="#pills-expense" type="button" role="tab" aria-controls="pills-expense" aria-selected="false">{{ __('messages.expense') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-product-tab" data-bs-toggle="pill" data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-product" aria-selected="false">{{ __('messages.product') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-purchase-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase" type="button" role="tab" aria-controls="pills-purchase" aria-selected="false">{{ __('messages.purchase') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-clients-tab" data-bs-toggle="pill" data-bs-target="#pills-clients" type="button" role="tab" aria-controls="pills-clients" aria-selected="false">{{ __('messages.client') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-supplier-tab" data-bs-toggle="pill" data-bs-target="#pills-supplier" type="button" role="tab" aria-controls="pills-supplier" aria-selected="false">{{ __('messages.supplier') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-sms-tab" data-bs-toggle="pill" data-bs-target="#pills-sms" type="button" role="tab" aria-controls="pills-sms" aria-selected="false">{{ __('messages.sms') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-email-tab" data-bs-toggle="pill" data-bs-target="#pills-email" type="button" role="tab" aria-controls="pills-email" aria-selected="false">{{ __('messages.email') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-colors-tab" data-bs-toggle="pill" data-bs-target="#pills-colors" type="button" role="tab" aria-controls="pills-colors" aria-selected="false">{{ __('messages.color') }}</button>
                                </li>
                                {{-- <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-preset-tab" data-bs-toggle="pill" data-bs-target="#pills-preset" type="button" role="tab" aria-controls="pills-preset" aria-selected="false">{{ __('messages.preset') }}</button>
                                </li> --}}
                                <li class="nav-item shadow-sm me-1 my-2" role="presentation">
                                    <button class="nav-link" id="pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#pills-dashboard" type="button" role="tab" aria-controls="pills-dashboard" aria-selected="false">{{ __('messages.dashboard') }}</button>
                                </li>
                                <li class="nav-item shadow-sm me-1 my-2 {{ config('dashboard.backup') == 1 ? '' : 'd-none' }}" role="presentation">
                                    <button class="nav-link" id="pills-backup-tab" data-bs-toggle="pill" data-bs-target="#pills-backup" type="button" role="tab" aria-controls="pills-backup" aria-selected="false">{{ __('messages.backup') }}</button>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item shadow-sm me-1" role="presentation">
                                    <a href="{{ route('user.staff.index') }}?user" class="nav-link active">{{ __('messages.user') }} {{ __('messages.permissions') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-general" role="tabpanel" aria-labelledby="pills-general-tab">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="language">{{ __('messages.language') }}</label>
                                        <div class="input-group">
                                            <select name="language" id="language" class="form-control change-lang">
                                                @if (!$erpdemo)
                                                    <option value="ar" {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>{{ __('messages.arabic') }}</option>
                                                @endif
                                                <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>{{ __('messages.bangla') }}</option>
                                                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                                                @if (!$erpdemo)
                                                    <option value="hi" {{ session()->get('locale') == 'hi' ? 'selected' : '' }}>{{ __('messages.hindi') }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="menu_size">{{ __('messages.menu_size') }}</label>
                                        <div class="input-group">
                                            <select name="menu_size" id="menu_size" class="form-control menu-size">
                                                <option {{ smallMenu() == 'large' ? 'selected' : '' }} value="large">{{ __('messages.large') }}</option>
                                                @if (!$erpdemo)
                                                    <option {{ smallMenu() == 'small' ? 'selected' : '' }} value="small">{{ __('messages.small') }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="page_length">{{ __('messages.page_length') }}</label>
                                        <div class="input-group">
                                            <select name="page_length" id="page_length" class="form-control page-length">
                                                <option {{ siteSettings()->page_length == 10 ? 'selected' : '' }} value="10">10</option>
                                                <option {{ siteSettings()->page_length == 25 ? 'selected' : '' }} value="25">25</option>
                                                <option {{ siteSettings()->page_length == 50 ? 'selected' : '' }} value="50">50</option>
                                                <option {{ siteSettings()->page_length == 100 ? 'selected' : '' }} value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                            <span class="form-switch-description tx-15 me-2">{{ __('messages.invoice_header') }} ({{ __('messages.custom') }})</span>
                                            <input type="checkbox" name="custom_header" class="form-switch-input" {{ config('settings_custom_header') == 1 ? 'checked' : '' }}>
                                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-invoice" role="tabpanel" aria-labelledby="pills-invoice-tab">
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.print_destination') }}</span>
                                        <input type="checkbox" name="print_destination" class="form-switch-input" {{ config('invoices_print_destination') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">Issued_date</span>
                                        <input type="checkbox" name="issued_date" class="form-switch-input" {{ config('invoices_issued_date') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">Issued Time</span>
                                        <input type="checkbox" name="issued_time" class="form-switch-input" {{ config('invoices_issued_time') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}


                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.open_product_after_select') }}</span>
                                        <input type="checkbox" name="open_product_after_select" class="form-switch-input" {{ config('invoices_open_product_after_select') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.track_number') }}</span>
                                        <input type="checkbox" name="track_number" class="form-switch-input" {{ config('invoices_track_number') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.over_stock_selling') }}</span>
                                        <input type="checkbox" name="over_stock_selling" class="form-switch-input" {{ config('invoices_over_stock_selling') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.seperate_item') }}</span>
                                        <input type="checkbox" name="seperate_item" class="form-switch-input" {{ config('invoices_seperate_item') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.discount') }}</span>
                                        <input type="checkbox" name="discount" class="form-switch-input" {{ config('invoices_discount') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.discount_type') . ' ' . __('messages.flat') }}</span>
                                        <input type="checkbox" name="discount_type" class="form-switch-input" {{ config('invoices_discount_type') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.transport_fare') }}</span>
                                        <input type="checkbox" name="transport_fare" class="form-switch-input" {{ config('invoices_transport_fare') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.labour_cost') }}</span>
                                        <input type="checkbox" name="labour_cost" class="form-switch-input" {{ config('invoices_labour_cost') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">Accounts</span>
                                        <input type="checkbox" name="account_id" class="form-switch-input" {{ config('invoices_account_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">Category</span>
                                        <input type="checkbox" name="category_id" class="form-switch-input" {{ config('invoices_category_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.receive') }} {{ __('messages.amount') }}</span>
                                        <input type="checkbox" name="receive_amount" class="form-switch-input" {{ config('invoices_receive_amount') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">Bill Amount</span>
                                        <input type="checkbox" name="bill_amount" class="form-switch-input" {{ config('invoices_bill_amount') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.due') }} {{ __('messages.amount') }}</span>
                                        <input type="checkbox" name="due_amount" class="form-switch-input" {{ config('invoices_due_amount') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.highest') }} {{ __('messages.due') }}</span>
                                        <input type="checkbox" name="highest_due" class="form-switch-input" {{ config('invoices_highest_due') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.vat') }}</span>
                                        <input type="checkbox" name="vat" class="form-switch-input" {{ config('invoices_vat') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.vat_type') . ' ' . __('messages.flat') }}</span>
                                        <input type="checkbox" name="vat_type" class="form-switch-input" {{ config('invoices_vat_type') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.sms') }}</span>
                                        <input type="checkbox" name="send_sms" class="form-switch-input" {{ config('invoices_send_sms') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.email') }}</span>
                                        <input type="checkbox" name="send_email" class="form-switch-input" {{ config('invoices_send_email') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.description') }}</span>
                                        <input type="checkbox" name="description" class="form-switch-input" {{ config('invoices_description') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-qr_code tx-15 me-2">{{ __('messages.view_qr_code') }}</span>
                                        <input type="checkbox" name="qr_code" class="form-switch-input" {{ config('invoices_qr_code') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-receive" role="tabpanel" aria-labelledby="pills-receive-tab">
                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.invoice_payment_from_receive') }}</span>
                                        <input type="checkbox" name="invoice_id" class="form-switch-input" {{ config('receives_invoice_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-expense" role="tabpanel" aria-labelledby="pills-expense-tab">
                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.show_only_cost_list') }}</span>
                                        <input type="checkbox" name="show_only_cost_list" class="form-switch-input" {{ config('expenses_show_only_cost_list') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.show_money_return_into_list') }}</span>
                                        <input type="checkbox" name="show_money_return_into_list" class="form-switch-input" {{ config('expenses_show_money_return_into_list') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.opening_stock') }}</span>
                                        <input type="checkbox" name="opening_stock" class="form-switch-input form-control-sm" {{ config('products_opening_stock') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">
                                            {{ __('messages.view') }} {{ __('messages.stock_warning') }}
                                        </span>
                                        <input type="checkbox" name="show_stock_warning" id="show_stock_warning" class="form-switch-input form-control-sm" {{ config('products_show_stock_warning') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">
                                            {{ __('messages.manual_barcode') }}
                                        </span>
                                        <input type="checkbox" name="custom_barcode_no" id="custom_barcode_no" class="form-switch-input form-control-sm" {{ config('products_custom_barcode_no') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">
                                            {{ __('messages.multi_pricing') }}
                                        </span>
                                        <input type="checkbox" name="multi_pricing" id="multi_pricing" class="form-switch-input form-control-sm" {{ config('products_multi_pricing') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">
                                            {{ __('messages.new_price_sale_only') }}
                                        </span>
                                        <input type="checkbox" name="new_price_sale_only" id="new_price_sale_only" class="form-switch-input form-control-sm" {{ config('products_new_price_sale_only') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">
                                            {{ __('messages.sale_price_with_percentage') }}
                                        </span>
                                        <input type="checkbox" name="sale_price_with_percentage" id="sale_price_with_percentage" class="form-switch-input form-control-sm" {{ config('products_sale_price_with_percentage') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                @if (config('products_sale_price_with_percentage') == 1)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input name="sale_price_percentage" id="sale_price_percentage" class="form-control clear-input" placeholder="{{ __('messages.sale_price_percentage') }}" value="{{ siteSettings()->sale_price_percentage ?? 0 }}" min="0" type="number">
                                            <label for="sale_price_percentage" class="animated-label active-label"> {{ __('messages.sale_price_percentage') }}</label>
                                        </div>
                                        <span class="text-danger small" id="sale_price_percentage_Error"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-purchase" role="tabpanel" aria-labelledby="pills-purchase-tab">
                            <div class="row mt-3">
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.invoice') }}</span>
                                        <input type="checkbox" name="invoice_id" class="form-switch-input" {{ config('purchases_invoice_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.purchase_seperate_item') }}</span>
                                        <input type="checkbox" name="seperate_item" class="form-switch-input" {{ config('purchases_seperate_item') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.issued_date') }}</span>
                                        <input type="checkbox" name="issued_date" class="form-switch-input" {{ config('purchases_issued_date') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.supplier') }}</span>
                                        <input type="checkbox" name="supplier_id" class="form-switch-input" {{ config('purchases_supplier_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.warehouse') }}</span>
                                        <input type="checkbox" name="warehouse_id" class="form-switch-input" {{ config('purchases_warehouse_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.discount') }}</span>
                                        <input type="checkbox" name="discount" class="form-switch-input" {{ config('purchases_discount') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.transport_fare') }}</span>
                                        <input type="checkbox" name="transport_fare" class="form-switch-input" {{ config('purchases_transport_fare') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.vat') }}</span>
                                        <input type="checkbox" name="vat" class="form-switch-input" {{ config('purchases_vat') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.account') }}</span>
                                        <input type="checkbox" name="account_id" class="form-switch-input" {{ config('purchases_account_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.category') }}</span>
                                        <input type="checkbox" name="category_id" class="form-switch-input" {{ config('purchases_category_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}

                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.receive_amount') }}</span>
                                        <input type="checkbox" name="receive_amount" class="form-switch-input" {{ config('purchases_receive_amount') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab">
                            <div class="row mt-3">
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.id_no') }}</span>
                                        <input type="checkbox" name="id_no" class="form-switch-input" {{ config('clients_id_no') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.client') }} {{ __('messages.name') }}</span>
                                        <input type="checkbox" name="client_name" class="form-switch-input" {{ config('clients_client_name') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.company') }} {{ __('messages.name') }}</span>
                                        <input type="checkbox" name="company_name" class="form-switch-input" {{ config('clients_company_name') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me75">{{ __('messages.address') }}</span>
                                        <input type="checkbox" name="address" class="form-switch-input" {{ config('clients_address') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me75">{{ __('messages.phone_number') }}</span>
                                        <input type="checkbox" name="phone" class="form-switch-input" {{ config('clients_phone') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }} 2</span>
                                        <input type="checkbox" name="phone_optional" class="form-switch-input" {{ config('clients_phone_optional') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.previous_due') }}</span>
                                        <input type="checkbox" name="previous_due" class="form-switch-input" {{ config('clients_previous_due') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.max_due_limit') }}</span>
                                        <input type="checkbox" name="max_due_limit" class="form-switch-input" {{ config('clients_max_due_limit') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.email') }}</span>
                                        <input type="checkbox" name="email" class="form-switch-input" {{ config('clients_email') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.date_of_birth') }}</span>
                                        <input type="checkbox" name="date_of_birth" class="form-switch-input" {{ config('clients_date_of_birth') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.upzilla') }}</span>
                                        <input type="checkbox" name="upazilla_thana" class="form-switch-input" {{ config('clients_upazilla_thana') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.zip_code') }}</span>
                                        <input type="checkbox" name="zip_code" class="form-switch-input" {{ config('clients_zip_code') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.client') }} {{ __('messages.group') }}</span>
                                        <input type="checkbox" name="group_id" class="form-switch-input" {{ config('clients_group_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.image') }}</span>
                                        <input type="checkbox" name="image" class="form-switch-input" {{ config('clients_image') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.status') }}</span>
                                        <input type="checkbox" name="status" class="form-switch-input" {{ config('clients_status') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-supplier" role="tabpanel" aria-labelledby="pills-supplier-tab">
                            <div class="row mt-3">
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.supplier') }} {{ __('messages.name') }}</span>
                                        <input type="checkbox" name="supplier_name" class="form-switch-input" {{ config('suppliers_supplier_name') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.company') }} {{ __('messages.name') }}</span>
                                        <input type="checkbox" name="company_name" class="form-switch-input" {{ config('suppliers_company_name') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }}</span>
                                        <input type="checkbox" name="phone" class="form-switch-input" {{ config('suppliers_phone') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                {{-- <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }} ({{ __('messages.optional') }})</span>
                                        <input type="checkbox" name="phone_optional" class="form-switch-input" {{ config('suppliers_phone_optional') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div> --}}
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.email') }}</span>
                                        <input type="checkbox" name="email" class="form-switch-input" {{ config('suppliers_email') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.previous_due') }}</span>
                                        <input type="checkbox" name="previous_due" class="form-switch-input" {{ config('suppliers_previous_due') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me75">{{ __('messages.present') }} {{ __('messages.address') }}</span>
                                        <input type="checkbox" name="address" class="form-switch-input" {{ config('suppliers_address') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.city') }}</span>
                                        <input type="checkbox" name="city_state" class="form-switch-input" {{ config('suppliers_city_state') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.zip_code') }}</span>
                                        <input type="checkbox" name="zip_code" class="form-switch-input" {{ config('suppliers_zip_code') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.country') }} {{ __('messages.name') }}</span>
                                        <input type="checkbox" name="country_name" class="form-switch-input" {{ config('suppliers_country_name') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.domain') }}</span>
                                        <input type="checkbox" name="domain" class="form-switch-input" {{ config('suppliers_domain') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.bank') }} {{ __('messages.account') }}</span>
                                        <input type="checkbox" name="bank_account" class="form-switch-input" {{ config('suppliers_bank_account') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.image') }}</span>
                                        <input type="checkbox" name="image" class="form-switch-input" {{ config('suppliers_image') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.supplier') }} {{ __('messages.group') }}</span>
                                        <input type="checkbox" name="group_id" class="form-switch-input" {{ config('suppliers_group_id') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">{{ __('messages.status') }}</span>
                                        <input type="checkbox" name="status" class="form-switch-input" {{ config('suppliers_status') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="pills-sms" role="tabpanel" aria-labelledby="pills-sms-tab">
                            <div class="row">
                                <div class="col-md-12 mt-3 text-center">
                                    <a href="javascript:;" class="btn btn-white py-2 px-3 border rounded-pill shadow-lg" id="getBalanceBtn">{{ __('messages.click_here_to_see_balance') }}</a>
                                    <a href="{{ route('recharge.sms.balance') }}" class="btn btn-white py-2 px-3 border rounded-pill shadow-lg">{{ __('messages.recharge_now') }}</a>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <p>Shortcodes: {client_name} {receive_amount} {due_amount} {description} {company_name} {company_mobile}</p>
                                    <hr>
                                    <label for="receive_sms">{{ __('messages.receive') }} {{ __('messages.sms') }}</label>
                                    <textarea name="" id="receive_sms" rows="10" class="form-control shadow border-info">{{ strip_tags(str_replace('<br>', PHP_EOL, siteSettings()->receive_sms)) }}</textarea>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <p>Shortcodes: {client_name} {total_bill} {total_payment} {invoice_due} {client_total_due} {company_name} {company_mobile}</p>
                                    <hr>
                                    <label for="invoice_sms">{{ __('messages.invoice') }} {{ __('messages.sms') }}</label>
                                    <textarea name="" id="invoice_sms" rows="10" class="form-control shadow border-info">{{ strip_tags(str_replace('<br>', PHP_EOL, siteSettings()->invoice_sms)) }}</textarea>
                                </div>

                                @if (siteSettings()->partial_api == 1)
                                    <div class="col-md-6 mt-3">
                                        <label for="api_key">{{ __('messages.api_key') }}</label>
                                        <input name="api_key" value="{{ siteSettings()->api_key }}" id="api_key" rows="10" class="form-control shadow border-info">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="api_url">{{ __('messages.api_url') }}</label>
                                        <input name="api_url" value="{{ siteSettings()->api_url }}" id="api_url" rows="10" class="form-control shadow border-info">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="sender_id">{{ __('messages.sender_id') }}</label>
                                        <input name="sender_id" value="{{ siteSettings()->sender_id }}" id="sender_id" rows="10" class="form-control shadow border-info">
                                    </div>
                                @endif

                                <div class="col-md-12 mt-5 mb-3 d-flex justify-content-center">
                                    <button id="saveSmsFormat" class="btn btn-success w-50">{{ __('messages.save') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab">
                            <div class="card mt-3">
                                <div class="card-body">{{ __('messages.email') }}</div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-colors" role="tabpanel" aria-labelledby="pills-colors-tab">
                            <div class="row mt-3">
                                @include('user.settings.color-settings')
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="pills-preset" role="tabpanel" aria-labelledby="pills-preset-tab">
                            <div class="row mt-3 mx-auto">
                                @include('user.settings.preset')
                            </div>
                        </div> --}}
                        <div class="tab-pane fade" id="pills-dashboard" role="tabpanel" aria-labelledby="pills-dashboard-tab">
                            <div class="row mt-3 mx-auto">
                                <div class="form-group col-md-4">
                                    <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                        <span class="form-switch-description tx-15 me-2">
                                            {{ __('messages.view') }} {{ __('messages.stock_warning') }}
                                        </span>
                                        <input type="checkbox" name="show_stock_warning" id="show_stock_warning" class="form-switch-input form-control-sm" {{ config('products_show_stock_warning') == 1 ? 'checked' : '' }}>
                                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-backup" role="tabpanel" aria-labelledby="pills-backup-tab">
                            <div class="row mt-3 mx-auto">
                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center gap-5">
                                            <input id="folder_id" type="text" class="form-control w-50" name="folder_id" placeholder="Enter google drive folder id" value="{{ siteSettings()->google_drive_folder_id }}">
                                            <div>{{ __('messages.type_and_hit_enter') }}</div>
                                        </div>
                                        <label class="animated-label active-label" for="folder_id"><i class="fas fa-folder-open"></i> {{ __('messages.google_drive_folder_id') }}</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 {{ config('settings.google_client_credentials') == 1 ? '' : 'd-none' }}">
                                    <div class="form-group">
                                        <label for="credentials"><i class="fas fa-folder-open"></i> {{ __('messages.google_drive_folder_id') }}</label>
                                        <div class="d-flex">
                                            <textarea id="credentials" type="text" rows="12" class="form-control w-75" name="credentials" placeholder="Enter your credentials here">{{ old('credentials', $credentials) }}</textarea>
                                        </div>
                                        <button type="button" id="save-credential" class="btn btn-success">{{ __('messages.update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(".change-lang").change(function() {
            var url = "{{ route('language') }}";
            window.location.href = url + "?lang=" + $(this).val();
        });

        $(".menu-size").change(function() {
            var url = "{{ route('menu.size') }}";
            window.location.href = url + "?size=" + $(this).val();
        });

        $(".page-length").change(function() {
            var url = "{{ route('page.length') }}";
            window.location.href = url + "?page_length=" + $(this).val();
        });

        $(document).ready(function() {
            $("#getBalanceBtn").click();
        });

        $("#getBalanceBtn").on('click', function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('user.settings.check.sms.balance') }}",
                success: function(balance) {
                    var svg = '';
                    svg += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 75 200 50" style="height: 20px">';
                    svg += '<circle fill="#1E2336" stroke="#1E2336" stroke-width="4" r="15" cx="40" cy="100">';
                    svg += '<animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate>';
                    svg += '</circle>';
                    svg += '<circle fill="#1E2336" stroke="#1E2336" stroke-width="4" r="15" cx="100" cy="100">';
                    svg += '<animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate>';
                    svg += '</circle>';
                    svg += '<circle fill="#1E2336" stroke="#1E2336" stroke-width="4" r="15" cx="160" cy="100">';
                    svg += '<animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate>';
                    svg += '</circle>';
                    svg += '</svg>';

                    var svg2 = '';
                    svg2 += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 75 200 50" style="height: 20px">';
                    svg2 += '<circle fill="%231E2336" stroke="%231E2336" stroke-width="4" r="15" cx="35" cy="100">';
                    svg2 += '<animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin="0"></animate>';
                    svg2 += '</circle>';
                    svg2 += '<circle fill="%231E2336" stroke="%231E2336" stroke-width="4" opacity=".8" r="15" cx="35" cy="100">';
                    svg2 += '<animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin="0.05"></animate>';
                    svg2 += '</circle>';
                    svg2 += '<circle fill="%231E2336" stroke="%231E2336" stroke-width="4" opacity=".6" r="15" cx="35" cy="100">';
                    svg2 += '<animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".1"></animate>';
                    svg2 += '</circle>';
                    svg2 += '<circle fill="%231E2336" stroke="%231E2336" stroke-width="4" opacity=".4" r="15" cx="35" cy="100">';
                    svg2 += '<animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".15"></animate>';
                    svg2 += '</circle>';
                    svg2 += '<circle fill="%231E2336" stroke="%231E2336" stroke-width="4" opacity=".2" r="15" cx="35" cy="100">';
                    svg2 += '<animate attributeName="cx" calcMode="spline" dur="2" values="35;165;165;35;35" keySplines="0 .1 .5 1;0 .1 .5 1;0 .1 .5 1;0 .1 .5 1" repeatCount="indefinite" begin=".2"></animate>';
                    svg2 += '</circle>';
                    svg2 += '</svg>';
                    $("#getBalanceBtn").html(svg);
                    setTimeout(() => {
                        $("#getBalanceBtn").addClass('text-dark shadow-lg');
                        $("#getBalanceBtn").text('Balance: ' + balance + ' TK');
                    }, 1000);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
    </script>
@endpush

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function capitalizeWords(str) {
            return str.replace(/\b\w/g, function(match) {
                return match.toUpperCase();
            });
        }
        $("#pills-general input").on('click', function() {
            var table_name = 'settings';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
        $("#pills-invoice .form-group input").on('click', function() {
            var table_name = 'invoices';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#pills-invoice #labour_cost_rate").on('keyup', function() {
            var labour_cost_rate = $(this).val();

            var url = '{{ route('update.labour.cost.rate') }}';

            $.ajax({
                type: "GET",
                dataType: "json",
                data: {
                    labour_cost_rate: labour_cost_rate
                },
                url: url,
                success: function(data) {
                    toastr.success("Sale Labour Cost Rate Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#pills-receive input").on('click', function() {
            var table_name = 'receives';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
        $("#pills-expense input").on('click', function() {
            var table_name = 'expenses';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
        $("#pills-product .form-group input").on('click', function() {
            var table_name = 'products';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#pills-dashboard .form-group input").on('click', function() {
            var table_name = 'products';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#pills-product #sale_price_percentage").on('input', function() {
            var percentage = $(this).val();

            var url = '{{ route('update.sale.percentage') }}';

            $.ajax({
                type: "GET",
                dataType: "json",
                data: {
                    percentage: percentage
                },
                url: url,
                success: function(data) {
                    toastr.success("Sale Percentage Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#pills-purchase input").on('click', function() {
            var table_name = 'purchases';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
        $("#pills-clients input").on('click', function() {
            var table_name = 'clients';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
        $("#pills-supplier input").on('click', function() {
            var table_name = 'suppliers';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#saveSmsFormat").on('click', function() {
            var receive_sms = $("#receive_sms").val();
            var invoice_sms = $("#invoice_sms").val();
            var api_key = $("#api_key").val();
            var api_url = $("#api_url").val();
            var sender_id = $("#sender_id").val();
            console.log(receive_sms);

            var url = '{{ route('user.settings.update.sms') }}';

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                data: {
                    receive_sms: receive_sms,
                    invoice_sms: invoice_sms,
                    api_key: api_key,
                    api_url: api_url,
                    sender_id: sender_id,
                },
                success: function(data) {
                    toastr.success(data.message);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#pills-backup #folder_id").on('change', function() {
            var folder_id = $(this).val();

            var url = '{{ route('update.folder.id') }}';

            $.ajax({
                type: "GET",
                dataType: "json",
                data: {
                    google_drive_folder_id: folder_id
                },
                url: url,
                success: function(data) {
                    toastr.success("Backup directory updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $("#save-credential").on('click', function() {
            var credentials = $("#credentials").val();

            var url = '{{ route('user.settings.update.credentials') }}';

            $.ajax({
                type: "GET",
                dataType: "json",
                data: {
                    credentials: credentials
                },
                url: url,
                success: function(data) {
                    toastr.success("Backup credentials updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
    </script>
@endpush
