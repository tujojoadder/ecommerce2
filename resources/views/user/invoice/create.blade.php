@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
        $draftSection = request()->routeIs('user.invoice.create.draft');
        $edit = request()->routeIs('user.invoice.edit');
        $salesReturnSection = request()->routeIs('user.invoice.create.return');
        if ($salesReturnSection) {
            $invoiceType = 'invoice-return';
        } elseif ($draftSection) {
            $invoiceType = 'invoice-draft';
        } else {
            $invoiceType = 'invoice';
        }

        $edit ? ($status = $data->status) : ($status = 0);

    @endphp
    <style>
        .select2-selection--single {
            height: 32px !important;
            border-radius: 5px !important;
        }
    </style>
    <div class="main-content-body">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <p class="card-title my-0">{{ $pageTitle }}</p>
                <div class="d-flex">
                    @if ($draftSection)
                        <a href="{{ route('user.invoice.index') }}?draft" class="btn btn-secondary me-2">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.draft') }} {{ __('messages.list') }}
                        </a>
                    @elseif ($salesReturnSection || $status == 4)
                        <a href="{{ route('user.invoice.sales.return') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.sales') }} {{ __('messages.return') }} {{ __('messages.list') }}
                        </a>
                    @else
                        <a href="{{ route('user.invoice.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.invoice') }} {{ __('messages.list') }}
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row" id="invoice-form">
                    <input type="hidden" id="invoice_type" value="{{ $invoiceType ?? 'invoice' }}">
                    <div class="{{ config('invoices_client_id') == 1 ? '' : 'd-none' }} mb-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                            <div class="input-group">
                                <select name="client_id" id="client_id" class="form-control select2" {{ Request::is('user/invoice/sales-return') ? 'disabled' : '' }}></select>
                            </div>
                            <a id="clientAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="client_id_Error" style="color: #ff3f3f !important"></span>
                        @if (config('client.remaining_due_date') == 1)
                            <div class="d-none mt-3" id="remaining-due">
                                <div class="input-group">
                                    <input type="text" name="remaining_due_date" id="remaining_due_date" class="fc-datepicker form-control" placeholder="DD/MM/YYYY">
                                    <input type="hidden" id="client_id_for_due" value="">
                                    <label for="remaining_due_date" class="ms-2 animated-label active-label">{{ __('messages.remaining_due_date') }}</label>
                                    <button onclick="updateRemainingDueDate();" type="button" class="btn add-btn btn-success">{{ __('messages.update') }}</button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="{{ config('invoices_staff_id') == 1 ? '' : '' }} mb-3 col-xl-3 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.staff') }}">
                            <div class="input-group">
                                <select name="staff_id" id="staff_id" class="form-control select2"></select>
                            </div>
                            <a id="staffAddModalBtn" class="add-btn btn border" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="staff_id_Error" style="color: #ff3f3f !important"></span>
                    </div>

                    <div class="{{ config('invoices_issued_date') == 1 ? '' : 'd-none' }} {{ config('invoices_issued_time') == 0 ? 'col-xl-6 col-lg-6 col-md-6' : 'col-xl-3 col-lg-3 col-md-3' }}">
                        <div class="form-group">
                            <input name="issued_date" id="issued_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ date('d/m/Y') }}" type="text">
                            <label class="animated-label active-label" for="issued_date"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.issued_date') }}</label>
                        </div>
                        <span class="text-danger small" id="issued_date_Error" style="color: #ff3f3f !important"></span>
                    </div>
                    <div class="{{ config('invoices_issued_time') == 1 ? '' : 'd-none' }} form-group mb-3 col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <input name="issued_time" id="issued_time" class="form-control" placeholder="{{ __('messages.time') }}" value="{{ now()->format('H:i') }}" type="time" autocomplete="off" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Issue Time">
                        </div>
                        <span class="text-danger small" id="issued_time_Error" style="color: #ff3f3f !important"></span>
                    </div>
                    @if (config('sidebar.product_barcode') == 1)
                        <div class="form-group mb-3 col-xl-6 col-lg-6 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-radius: 10px 0px 0px 10px;"><i class="fas fa-barcode text-dark" style="font-size: 30px; width: 50px"></i></span>
                                <input id="barcode_number" name="barcode" class="form-control" placeholder="{{ __('messages.barcode') }} {{ __('messages.number') }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.barcode') }} {{ __('messages.number') }}" autofocus>
                            </div>
                        </div>
                    @endif
                    <div class="form-group mb-3 {{ config('invoices_track_number') == 1 || config('sidebar.product_barcode') == 1 ? 'col-xl-6 col-lg-6 col-md-6' : 'col-xl-12 col-lg-12 col-md-12' }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.search_with_product_messages_name') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select id="product_search" class="form-control select2">
                                </select>
                            </div>
                            <a class="add-btn btn border" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    @if (config('invoices_track_number') == 1)
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input name="track_number" id="track_number" class="form-control" placeholder="{{ __('messages.track_number') }}" min="0" type="number">
                                <label class="animated-label active-label" for="track_number"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.track_number') }}</label>
                            </div>
                            <span class="text-danger small" id="track_number_Error" style="color: #ff3f3f !important"></span>
                        </div>
                    @endif

                    <div class="col-12 table-responsive mb-4">
                        <table class="table table-secondary" id="order_table">
                            <thead>
                                <th class="py-2 text-center">{{ __('messages.sl') }}</th>
                                <th class="py-2 text-center">{{ __('messages.sale') }} {{ __('messages.type') }}</th>
                                <th class="py-2 text-center">{{ __('messages.product') }}</th>
                                @if (!$salesReturnSection || $status == 4)
                                    <th class="py-2 text-center">{{ __('messages.description') }}</th>
                                @endif
                                <th class="py-2 text-center">{{ __('messages.stock') }}</th>
                                <th class="py-2 text-center">{{ __('messages.quantity') }}</th>
                                @if ($salesReturnSection || $status == 4)
                                    <th class="py-2 text-center">{{ __('messages.return') . ' ' . __('messages.type') }}</th>
                                    <th class="py-2 text-center">{{ __('messages.description') }}</th>
                                @endif
                                <th class="py-2 text-center {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">{{ __('messages.buy') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.selling') }} {{ __('messages.price') }}</th>
                                <th class="py-2 text-center">{{ __('messages.unit') }}</th>
                                <th class="py-2 text-center">{{ __('messages.total') }}</th>
                                <th class="py-2 text-center">{{ __('messages.action') }}</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 ps-0">
                        <div class="{{ config('invoices_discount') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <input name="discount" id="discount" class="form-control clear-input" placeholder="{{ __('messages.discount') }}" type="number" min="0" value="0">
                                        <label class="animated-label active-label" for="discount"><i class="far fa-sticky-note"></i> {{ __('messages.discount') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select name="discount_type" id="discount_type" class="form-control SelectBox" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.discount') }} {{ __('messages.type') }}" required>
                                        <option label="Choose One"></option>
                                        <option value="flat" {{ config('invoices_discount_type') == 1 ? 'selected' : '' }}>{{ __('messages.flat') }}</option>
                                        <option value="percentage" {{ config('invoices_discount_type') == 1 ? '' : 'selected' }}>{{ __('messages.percentage') }} (%)</option>
                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="discount_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_vat') == 1 && !$salesReturnSection && $status != 4 ? '' : 'd-none' }} form-group mb-3 col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input name="vat" id="vat" class="form-control clear-input" placeholder="{{ __('messages.vat') }}" value="0" min="0" type="text" autocomplete="off">
                                        <label class="animated-label active-label" for="vat"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.vat') }}</label>
                                    </div>
                                    <span class="text-danger small" id="vat_Error" style="color: #ff3f3f !important"></span>
                                </div>
                                <div class="col-md-6">
                                    <select name="vat_type" id="vat_type" class="form-control SelectBox" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.vat') }} {{ __('messages.type') }}" required>
                                        <option label="Choose One"></option>
                                        <option value="flat" {{ config('invoices_vat_type') == 1 ? 'selected' : '' }}>{{ __('messages.flat') }}</option>
                                        <option value="percentage" {{ config('invoices_vat_type') == 1 ? '' : 'selected' }}>{{ __('messages.percentage') }} (%)</option>
                                    </select>
                                    <span class="text-danger small" id="vat_type_Error" style="color: #ff3f3f !important"></span>
                                </div>
                            </div>
                        </div>

                        <div class="{{ $salesReturnSection || $status == 4 ? 'd-none' : '' }} form-group mb-3 col-md-12">
                            <div class="row">
                                <div class="col-md-{{ config('invoices_labour_cost') == 0 ? '12' : '6' }}">
                                    <div class="form-group mb-0">
                                        @if (config('invoices_transport_fare') == 1)
                                            <input name="transport_fare" id="transport_fare" class="form-control clear-input" value="0" min="0" type="number" placeholder="{{ __('messages.transport_fare') }}">
                                            <label class="animated-label active-label" for="transport_fare"><i class="far fa-sticky-note"></i> {{ __('messages.transport_fare') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        @if (config('invoices_labour_cost') == 1)
                                            <input name="labour_cost" id="labour_cost" class="form-control clear-input" placeholder="{{ __('messages.labour_cost') }}" value="0" min="0" type="number">
                                            <label class="animated-label active-label" for="labour_cost"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.labour_cost') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger small" id="transport_fare_Error" style="color: #ff3f3f !important"></span>
                            <span class="text-danger small" id="labour_cost_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_account_id') == 1 ? '' : 'd-none' }} form-group mb-3 col-md-12">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.account') }}">
                                <div class="input-group">
                                    <select name="account_id" id="account_id" class="form-control select2"></select>
                                </div>
                                <a id="accountAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="account_id_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="cheque-form d-none">
                            <div class="form-group mb-4 col-md-12">
                                <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.bank') }}">
                                    <div class="input-group">
                                        <select name="bank_id" id="bank_id" class="form-control bank_id select2"></select>
                                    </div>
                                    <a id="bankAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="bank_id_Error" style="color: #ff3f3f !important"></span>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <input name="cheque_number" id="cheque_number" class="form-control" placeholder="{{ __('messages.cheque_number') }}" type="text" step="any" autocomplete="off">
                                    <label class="animated-label active-label" for="cheque_number"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.cheque_number') }}</label>
                                </div>
                                <span class="text-danger small" id="cheque_number_Error" style="color: #ff3f3f !important"></span>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="cheque_issued_date" id="cheque_issued_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ date('d/m/Y') }}" type="text">
                                    <label class="animated-label active-label" for="cheque_issued_date"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.cheque_issued_date') }}</label>
                                </div>
                                <span class="text-danger small" id="cheque_issued_date_Error" style="color: #ff3f3f !important"></span>
                            </div>
                        </div>

                        @if ($salesReturnSection || $status == 4)
                            <div class="{{ config('invoices_category_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                                <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.expense') }} {{ __('messages.category') }}">
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-control select2 expense_category_id"></select>
                                    </div>
                                    <a id="expenseCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="category_id_Error" style="color: #ff3f3f !important"></span>
                            </div>
                        @else
                            <div class="{{ config('invoices_category_id') == 1 ? '' : 'd-none' }} form-group mb-4 col-md-12">
                                <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.receive') }} {{ __('messages.category') }}">
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-control select2 receive_category_id"></select>
                                    </div>
                                    <a id="receiveCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="category_id_Error" style="color: #ff3f3f !important"></span>
                            </div>
                        @endif

                        <div class="{{ config('invoices_cash_receive') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="cash_receive" id="cash_receive" class="form-control clear-input" placeholder="{{ __('messages.cash') }} {{ __('messages.amount') }}" value="0" min="0" type="number" step="any" autocomplete="off">
                                <label class="animated-label active-label" for="cash_receive"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.cash') }} {{ __('messages.amount') }}</label>
                            </div>
                            <span class="text-danger small" id="cash_receive_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_change_amount') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="change_amount" id="change_amount" class="form-control clear-input" placeholder="{{ __('messages.change_amount') }}" value="0" min="0" type="number" step="any" autocomplete="off">
                                <label class="animated-label active-label" for="change_amount"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.change_amount') }}</label>
                            </div>
                            <span class="text-danger small" id="change_amount_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_receive_amount') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="receive_amount" id="receive_amount" class="form-control clear-input" {{-- $salesReturnSection || $status == 4 == 'sales-return' ? 'readonly' : '' --}} placeholder="{{ __('messages.receive') }} {{ __('messages.amount') }}" value="0" min="0" type="number" step="any" autocomplete="off">
                                <label class="animated-label active-label" for="receive_amount">
                                    @if ($salesReturnSection || $status == 4)
                                        <i class="typcn typcn-calendar-outline"></i> {{ __('messages.return') }} {{ __('messages.amount') }}
                                    @else
                                        <i class="typcn typcn-calendar-outline"></i> {{ __('messages.receive') }} {{ __('messages.amount') }}
                                    @endif
                                </label>
                            </div>
                            <span class="text-danger small" id="receive_amount_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_bill_amount') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="bill_amount" id="bill_amount" class="form-control bg-light" placeholder="{{ $salesReturnSection || $status == 4 ? __('messages.return') : __('messages.bill') }} {{ __('messages.amount') }}" value="0" min="0" type="number" step="any" readonly>
                                <label class="animated-label active-label" for="bill_amount"><i class="typcn typcn-calendar-outline"></i> {{ $salesReturnSection || $status == 4 ? __('messages.return') : __('messages.bill') }} {{ __('messages.amount') }} <small class="text-warning">(Not Editable)</small></label>
                            </div>
                            <span class="text-danger small" id="bill_amount_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_due_amount') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="due_amount" id="due_amount" class="form-control" placeholder="{{ __('messages.due') }} {{ __('messages.amount') }}" value="0" min="0" type="number" step="any" readonly>
                                <label class="animated-label active-label" for="due_amount"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.due') }} {{ __('messages.amount') }} <small class="text-warning">(Not Editable)</small></label>
                            </div>
                            <span class="text-danger small" id="due_amount_Error" style="color: #ff3f3f !important"></span>
                        </div>

                        <div class="{{ config('invoices_highest_due') == 1 ? '' : 'd-none' }} col-md-12">
                            <div class="form-group">
                                <input name="highest_due" id="highest_due" class="form-control clear-input" placeholder="{{ __('messages.max_due_limit') }}" value="0" min="0" type="text" readonly>
                                <label class="animated-label active-label" for="highest_due"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.max_due_limit') }}</label>
                            </div>
                            <span class="text-danger small" id="highest_due_Error" style="color: #ff3f3f !important"></span>
                        </div>
                        <input type="hidden" id="row_id">
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr class="border">
                                <td width="50%">{{ __('messages.product') }} {{ __('messages.total') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_bill" readonly value="0"></td>
                            </tr>
                            @if (config('invoices_transport_fare') == 1)
                                <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                    <td width="50%">{{ __('messages.transport_fare') }}</td>
                                    <td width="1%">:</td>
                                    <td width="50"><input class="form-control from-control-sm bg-white border-0 transport_fare" readonly value="0"></td>
                                </tr>
                            @endif
                            @if (config('invoices_vat') == 1)
                                <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                    <td width="50%">{{ __('messages.vat') }}</td>
                                    <td width="1%">:</td>
                                    <td width="50"><input class="form-control from-control-sm bg-white border-0 total_vat" id="total_vat" readonly value="0"></td>
                                </tr>
                            @endif
                            @if (config('invoices_labour_cost') == 1)
                                <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                    <td width="50%">{{ __('messages.labour_cost') }}</td>
                                    <td width="1%">:</td>
                                    <td width="50"><input class="form-control from-control-sm bg-white border-0 labour_cost" readonly value="0"></td>
                                </tr>
                            @endif
                            @if (config('invoices_discount') == 1)
                                <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                    <td width="50%">{{ __('messages.discount') }}</td>
                                    <td width="1%">:</td>
                                    <td width="50"><input class="form-control from-control-sm bg-white border-0 total_discount" id="total_discount" readonly value="0"></td>
                                </tr>
                            @endif
                            <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                <td width="50%">{{ __('messages.invoice') }} {{ __('messages.bill') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 invoice_bill" id="invoice_bill" readonly value="0"></td>
                            </tr>
                            <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}" id="previousDueBox">
                                <td width="50%">{{ __('messages.previous') }} {{ __('messages.due') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 previous_due" id="previous_due" readonly value="0"></td>
                            </tr>
                            <tr class="border d-none {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                <td width="50%">{{ __('messages.total') }} {{ __('messages.bill') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 grand_total" id="grand_total" readonly value="0"></td>
                            </tr>
                            @if ($salesReturnSection || $status == 4)
                                <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                    <td width="50%">{{ __('messages.previous') }} {{ __('messages.due') }}</td>
                                    <td width="1%">:</td>
                                    <td width="50"><input class="form-control from-control-sm bg-white border-0 previous_due_show_only" id="previous_due_show_only" readonly value="0"></td>
                                </tr>
                                <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : '' }}">
                                    <td width="50%">{{ __('messages.upcoming') }} {{ __('messages.due') }}</td>
                                    <td width="1%">:</td>
                                    <td width="50"><input class="form-control from-control-sm bg-white border-0 upcoming_due_show_only" id="upcoming_due_show_only" readonly value="0"></td>
                                </tr>
                            @endif
                            <tr class="border">
                                <td width="50%">{{ $salesReturnSection || $status == 4 ? __('messages.return') : __('messages.payment') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_payment" readonly value="0"></td>
                            </tr>
                            <tr class="border {{ $salesReturnSection || $status == 4 ? 'd-none' : 'd-none' }}">
                                <td width="50%">{{ __('messages.adjusting_amount') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 adjusting_amount" id="adjusting_amount" readonly value="0"></td>
                            </tr>
                            <tr class="border">
                                <td width="50%">{{ __('messages.total') }} {{ __('messages.due') }}</td>
                                <td width="1%">:</td>
                                <td width="50"><input class="form-control from-control-sm bg-white border-0 total_due" id="total_due" readonly value="0"></td>
                            </tr>
                        </table>

                        <div class="row">
                            <div class="{{ $salesReturnSection && $status == 4 ? 'd-none' : '' }} form-group mb-3 col-md{{ config('invoices_send_email') == 0 ? '12' : '6' }}">
                                <label class="input-group form-control d-flex justify-content-between py-1 checkbox-input" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.sms') }}">
                                    <span class="form-switch-description tx-15 me-2">
                                        <i class="fas fa-sms"></i> {{ __('messages.sms') }}
                                    </span>
                                    <input type="checkbox" name="send_sms" id="send_sms" class="form-switch-input form-control-sm" {{ config('invoices_send_sms') == 1 ? 'checked' : '' }}>
                                    <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                </label>
                                <span class="text-danger small" id="send_sms_Error" style="color: #ff3f3f !important"></span>
                            </div>
                            <div class="{{ config('invoices_send_email') == 1 ? '' : 'd-none' }} form-group mb-3 col-md-6">
                                <label class="input-group form-control d-flex justify-content-between py-1 checkbox-input" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.email') }}">
                                    <span class="form-switch-description tx-15 me-2">
                                        <i class="fas fa-at"></i> {{ __('messages.email') }}
                                    </span>
                                    <input type="checkbox" name="send_email" id="send_email" class="form-switch-input form-control-sm" {{ config('invoices_send_email') == 1 ? 'checked' : '' }}>
                                    <span class="form-switch-indicator form-switch-indicator-lg"></span>
                                </label>
                                <span class="text-danger small" id="send_email_Error" style="color: #ff3f3f !important"></span>
                            </div>
                        </div>
                    </div>
                    <div class="{{ config('invoices_warranty') == 1 ? '' : 'd-none' }} form-group mb-3 col-xl-12 col-lg-12 col-md-12" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="warranty">
                        <textarea name="warranty" id="warranty" class="form-control shadow border-info" rows="10" placeholder="{{ __('messages.warranty_description') }}" type="text" autocomplete="off">{{ config('invoices_warranty_description') }}</textarea>
                        <span class="text-danger small" id="warranty_Error" style="color: #ff3f3f !important"></span>
                    </div>
                    <div class="{{ config('invoices_description') == 1 ? '' : 'd-none' }} form-group mb-3 col-xl-12 col-lg-12 divol-md-12" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Description">
                        <textarea name="description" id="description" class="form-control shadow border-info" rows="2" placeholder="{{ __('messages.description') }}" value="" type="text" autocomplete="off"></textarea>
                        <span class="text-danger small" id="description_Error" style="color: #ff3f3f !important"></span>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between fixed-bottom bg-white border rounded-0" id="button-group">
                    <a class="btn btn-danger" href="{{ route('user.invoice.index') }}"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</a>
                    @if (!$salesReturnSection)
                        @if (config('sidebar.draft_invoice') == 1)
                            @canany(['access-all', 'draft-invoice-visibility'])
                                <button class="btn btn-success" type="button" id="saveAsDraft" onclick="addInvoice(this);"><i class="fab fa-firstdraft"></i> {{ __('messages.save_as_draft') }}</button>
                                <button class="btn btn-success d-none" type="button" id="saveAsDraftUpdate" onclick="updateInvoice(this);"><i class="fab fa-firstdraft"></i> {{ __('messages.save_as_draft') }}</button>
                            @endcanany
                        @endif
                        @if (!request()->routeIs('user.invoice.create.draft'))
                            <button class="btn btn-success" type="button" id="saveandprint" onclick="addInvoice('saveAndPrint');"><i class="fas fa-print"></i> {{ __('messages.save') }} & {{ __('messages.print') }}</button>
                        @endif
                    @endif
                    <button class="btn btn-success {{ $draftSection || $queryString == 'create-draft' || $queryString == 'draft' ? 'd-none' : '' }}" type="button" id="addInvoice" onclick="addInvoice();"><i class="fas fa-save"></i>
                        @if (request()->routeIs('user.invoice.sales.return') || request()->routeIs('user.invoice.create.return') || $queryString == 'sales-return')
                            {{ __('messages.return') }} {{ __('messages.invoice') }}
                        @else
                            {{ __('messages.add_invoice') }}
                        @endif
                    </button>
                    <button class="btn btn-info d-none" type="button" id="updateInvoice" onclick="updateInvoice();"> <i class="fas fa-save"></i>
                        @if (Route::is('user.invoice.sales.return') || $queryString == 'sales-return')
                            {{ __('messages.update') }} {{ __('messages.return') }}
                        @else
                            {{ __('messages.update') }} {{ __('messages.invoice') }}
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('user.client.client-add-modal')
    @include('user.accounts.account.account-modal')
    @include('user.accounts.receive.category.modal')
    @include('user.accounts.expense.expense-category-modal')
    @include('user.config.bank.bank-modal')
@endsection
@push('scripts')
    @include('user.invoice.invoice-js')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#receiveCategoryAddModalBtn").on('click', function() {
                $("#receiveCategoryModal").modal('show');
            });
            $("#expenseCategoryAddModalBtn").on('click', function() {
                $("#expenseCategoryModal").modal('show');
            });

            @if ($edit) // for edit
                edit("{{ $data->id }}");
            @endif
        });

        $(document).ready(function() {
            fetchClients();
            fetchAccounts();
            fetchProducts();
            fetchStaffs();
            @if ($salesReturnSection || $status == 4)
                fetchExpenseCategories();
            @else
                fetchReceiveCategories();
            @endif
            fetchBanks();

            $("#cash_receive").on('keyup', function() {
                var cashAmount = $(this).val();
                var receiveAmount = $("#receive_amount").val()
                var changeAmount = cashAmount - receiveAmount;
                $("#change_amount").val(changeAmount);
            });
        });
        @if (config('client.remaining_due_date') == 1)
            function updateRemainingDueDate() {
                var date = $("#remaining_due_date").val();
                var client_id = $("#client_id_for_due").val();
                var url = '{{ route('user.client.update.remaining.due.date', ':id') }}';
                url = url.replace(':id', client_id);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    data: {
                        remaining_due_date: date,
                    },
                    url: url,
                    success: function(data) {
                        $("#remainingDueDate").modal('hide');
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'Remaining Due Date Updated!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.file-export-datatable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Someting went wrong!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        @endif
    </script>
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
@endpush
