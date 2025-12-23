@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <style>
        .short-card {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    </style>
    @canany(['access-all', 'dashboard-visibility'])
        <div class="main-content-body">
            <div class="row mx-auto justify-content-between">
                <div class="col-6 px-0">
                    <a href="{{ route('user.analytics') }}" class="btn btn-lg btn-info mb-3 py-1 ps-1">
                        <div class="d-flex align-items-center gap-2" style="color: white !important;">
                            <img height="45" class="rounded-5" src="{{ asset('dashboard/img/gif/analytics.gif') }}" alt=""> {{ __('messages.see_analytics_dashboard') }}
                        </div>
                    </a>
                </div>
                <div class="col-6 text-end px-0">
                    <a href="javascript:;" onclick="updateYearlyBalance();" class="btn btn-lg btn-warning mb-3 py-1 ps-1">
                        <div class="d-flex align-items-center gap-2" style="color: black !important;">
                            <img height="45" class="rounded-5" src="{{ asset('dashboard/img/gif/loading.gif') }}" alt=""> {{ __('messages.update_total_balance') }}
                        </div>
                    </a>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-md-{{ config('dashboard.yearly_calculation') == 1 ? '8' : '12' }}">
                    <div class="row">
                        @if (config('dashboard.daily_calculation'))
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                <a href="javascript:;" class="text-dark" id="today_sales_links">
                                    <div class="card overflow-hidden project-card">
                                        <div class="card-body pb-2">
                                            <div class="d-flex">
                                                <div class="my-auto">
                                                    <img src="{{ asset('dashboard/img/icons/daily-sale.png') }}" alt="" class="me-5 ht-40 wd-40 my-auto rounded-lg">
                                                </div>
                                                <div class="project-content d-grid align-items-center">
                                                    <h5>{{ __('messages.today') }} {{ __('messages.sales') }}</h5>
                                                    <ul>
                                                        <li>
                                                            <strong class="d-inline-flex mb-0" style="font-size: 15px !important;">{{ __('messages.total') }}:</strong>
                                                            <span><strong style="font-size: 15px !important;">{{ (siteSettings()->today_sales ?? config('today_sales')) . ' ' . config('company.currency_symbol') }}</strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <a href="{{ route('user.report.sales.sales') }}" class="btn btn-sm rounded-pill" style="background-color: hsla(188, 78%, 41%, 70%); !important;">
                                                        <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                                            <img height="15" src="{{ asset('dashboard/svg/list.svg') }}" alt=""> {{ __('messages.view') }} {{ __('messages.report') }}
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <a href="{{ route('user.invoice.index') }}?create" class="btn btn-sm rounded-pill" style="background-color: hsla(154, 87%, 34%, 70%); !important;">
                                                        <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                                            <img height="15" src="{{ asset('dashboard/svg/plus.svg') }}" alt=""> {{ __('messages.add_new') }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                <a href="javascript:;" class="text-dark" id="today_deposit_links">
                                    <div class="card overflow-hidden project-card">
                                        <div class="card-body pb-2">
                                            <div class="d-flex">
                                                <div class="my-auto">
                                                    <img src="{{ asset('dashboard/img/icons/daily-deposit.png') }}" alt="" class="me-5 ht-40 wd-40 my-auto rounded-lg">
                                                </div>
                                                <div class="project-content d-grid align-items-center">
                                                    <h5>{{ __('messages.today') }} {{ __('messages.receive') }}</h5>
                                                    <ul>
                                                        <li>
                                                            <strong class="d-inline-flex mb-0" style="font-size: 15px !important;">{{ __('messages.total') }}:</strong>
                                                            <span><strong style="font-size: 15px !important;">{{ (siteSettings()->today_deposit ?? config('today_deposit')) . ' ' . config('company.currency_symbol') }}</strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <a href="{{ route('user.report.deposit.all') }}" class="btn btn-sm rounded-pill" style="background-color: hsla(188, 78%, 41%, 70%); !important;">
                                                        <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                                            <img height="15" src="{{ asset('dashboard/svg/list.svg') }}" alt=""> {{ __('messages.view') }} {{ __('messages.report') }}
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <a href="{{ route('user.receive.index') }}?create" class="btn btn-sm rounded-pill" style="background-color: hsla(154, 87%, 34%, 70%); !important;">
                                                        <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                                            <img height="15" src="{{ asset('dashboard/svg/plus.svg') }}" alt=""> {{ __('messages.add_new') }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                <a href="javascript:;" class="text-dark" id="today_cost_links">
                                    <div class="card overflow-hidden project-card">
                                        <div class="card-body pb-2">
                                            <div class="d-flex">
                                                <div class="my-auto">
                                                    <img src="{{ asset('dashboard/img/icons/daily-expense.png') }}" alt="" class="me-5 ht-40 wd-40 my-auto rounded-lg">
                                                </div>
                                                <div class="project-content d-grid align-items-center">
                                                    <h5>{{ __('messages.today') }} {{ __('messages.expense') }}</h5>
                                                    <ul>
                                                        <li>
                                                            <strong class="d-inline-flex mb-0" style="font-size: 15px !important;">{{ __('messages.total') }}:</strong>
                                                            <span><strong style="font-size: 15px !important;">{{ (siteSettings()->today_cost ?? config('today_cost')) . ' ' . config('company.currency_symbol') }}</strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mt-3">
                                                <div class="col-6">
                                                    <a href="{{ route('user.report.expense.all') }}" class="btn btn-sm rounded-pill" style="background-color: hsla(188, 78%, 41%, 70%); !important;">
                                                        <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                                            <img height="15" src="{{ asset('dashboard/svg/list.svg') }}" alt=""> {{ __('messages.view') }} {{ __('messages.report') }}
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <a href="{{ route('user.expense.index') }}?create-expense" class="btn btn-sm rounded-pill" style="background-color: hsla(154, 87%, 34%, 70%); !important;">
                                                        <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                                            <img height="15" src="{{ asset('dashboard/svg/plus.svg') }}" alt=""> {{ __('messages.add_new') }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            {{-- ------------------------------------------------------------------------------------------------ --}}
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12" title="{{ __('messages.sales') }} + {{ __('messages.client') }} {{ __('messages.previous_due') }}">
                                <div class="card overflow-hidden project-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('dashboard/img/icons/due.png') }}" alt="" class="me-2 ht-30 wd-30 my-auto rounded-lg p-0">
                                                <h5 class="mb-0">{{ __('messages.today') }} {{ __('messages.due') }}</h5>
                                            </div>
                                            <h5 class="mb-0">{{ (siteSettings()->today_due ?? config('today_due')) . ' ' . config('company.currency_symbol') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12" title="{{ __('messages.receive') }} - {{ __('messages.expense') }}">
                                <div class="card overflow-hidden project-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('dashboard/img/icons/daily-deposit.png') }}" alt="" class="me-2 ht-30 wd-30 my-auto rounded-lg p-0">
                                                <h5 class="mb-0">{{ __('messages.today') }} {{ __('messages.balance') }}</h5>
                                            </div>
                                            <h5 class="mb-0">{{ (siteSettings()->today_balance ?? config('today_balance')) . ' ' . config('company.currency_symbol') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- ------------------------------------------------------------------------------------------------ --}}
                        @if (config('dashboard.monthly_calculation'))
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                <a href="javascript:;" class="text-dark" id="monthly_sales_links">
                                    <div class="card overflow-hidden project-card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="my-auto">
                                                    <img src="{{ asset('dashboard/img/icons/calendar.png') }}" alt="" class="me-5 ht-40 wd-40 my-auto rounded-lg">
                                                </div>
                                                <div class="project-content d-grid align-items-center">
                                                    <h5>{{ config('monthly_sales_name') . ' ' . __('messages.sales') }}</h5>
                                                    <ul>
                                                        <li>
                                                            <strong class="d-inline-flex mb-0" style="font-size: 15px !important;">{{ __('messages.total') }}:</strong>
                                                            <span><strong style="font-size: 15px !important;">{{ (siteSettings()->monthly_sales ?? config('monthly_sales')) . ' ' . config('company.currency_symbol') }}</strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                <a href="javascript:;" class="text-dark" id="monthly_deposit_links">
                                    <div class="card overflow-hidden project-card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="my-auto">
                                                    <img src="{{ asset('dashboard/img/icons/calendar.png') }}" alt="" class="me-5 ht-40 wd-40 my-auto rounded-lg">
                                                </div>
                                                <div class="project-content d-grid align-items-center">
                                                    <h5>{{ config('monthly_deposit_name') . ' ' . __('messages.receive') }}</h5>
                                                    <ul>
                                                        <li>
                                                            <strong class="d-inline-flex mb-0" style="font-size: 15px !important;">{{ __('messages.total') }}:</strong>
                                                            <span><strong style="font-size: 15px !important;">{{ (siteSettings()->monthly_deposit ?? config('monthly_deposit')) . ' ' . config('company.currency_symbol') }}</strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                <a href="javascript:;" class="text-dark" id="monthly_cost_links">
                                    <div class="card overflow-hidden project-card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="my-auto">
                                                    <img src="{{ asset('dashboard/img/icons/calendar.png') }}" alt="" class="me-5 ht-40 wd-40 my-auto rounded-lg">
                                                </div>
                                                <div class="project-content d-grid align-items-center">
                                                    <h5>{{ config('monthly_cost_name') . ' ' . __('messages.expense') }}</h5>
                                                    <ul>
                                                        <li>
                                                            <strong class="d-inline-flex mb-0" style="font-size: 15px !important;">{{ __('messages.total') }}:</strong>
                                                            <span><strong style="font-size: 15px !important;">{{ (siteSettings()->monthly_cost ?? config('monthly_cost')) . ' ' . config('company.currency_symbol') }}</strong></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            {{-- ------------------------------------------------------------------------------------------------ --}}
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12" title="{{ __('messages.sales') }} + {{ __('messages.client') }} {{ __('messages.previous_due') }}">
                                <div class="card overflow-hidden project-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('dashboard/img/icons/due.png') }}" alt="" class="me-2 ht-30 wd-30 my-auto rounded-lg p-0">
                                                <h5 class="mb-0">{{ config('monthly_due_name') . ' ' . __('messages.due') }}</h5>
                                            </div>
                                            <h5 class="mb-0">{{ (siteSettings()->monthly_due ?? config('monthly_due')) . ' ' . config('company.currency_symbol') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-12" title="{{ __('messages.receive') }} - {{ __('messages.expense') }}">
                                <div class="card overflow-hidden project-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('dashboard/img/icons/daily-deposit.png') }}" alt="" class="me-2 ht-30 wd-30 my-auto rounded-lg p-0">
                                                <h5 class="mb-0">{{ config('monthly_balance_name') . ' ' . __('messages.balance') }}</h5>
                                            </div>
                                            <h5 class="mb-0">{{ (siteSettings()->monthly_balance ?? config('monthly_balance')) . ' ' . config('company.currency_symbol') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- ------------------------------------------------------------------------------------------------ --}}
                    </div>
                </div>
                @if (config('dashboard.yearly_calculation'))
                    <div class="col-md-4 ps-4">
                        <div class="card border-0 mb-3">
                            <div class="card-body short-card d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/img/icons/shopping-cart.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                    <h5 class="mb-0">{{ __('messages.stock') }} {{ __('messages.value') }}</h5>
                                </div>
                                <h5 class="mb-0">{{ (siteSettings()->total_stock_value ?? config('total_stock_value')) . ' ' . config('company.currency_symbol') }}</h5>
                            </div>
                        </div>
                        <div class="card border-0 mb-3">
                            <div class="card-body short-card d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/img/icons/total-sales.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                    <h5 class="mb-0">{{ __('messages.total') }} {{ __('messages.sales') }}</h5>
                                </div>
                                <h5 class="mb-0">{{ (siteSettings()->total_sales ?? config('total_sales')) . ' ' . config('company.currency_symbol') }}</h5>
                            </div>
                        </div>
                        @if (config('dashboard.total_client_previous_due'))
                            <div class="card border-0 mb-3">
                                <div class="card-body short-card d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('dashboard/img/icons/due.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                        <h5 class="mb-0">{{ __('messages.client') }} {{ __('messages.previous_due') }}</h5>
                                    </div>
                                    <h5 class="mb-0">{{ (siteSettings()->total_previous_due ?? config('total_previous_due')) . ' ' . config('company.currency_symbol') }}</h5>
                                </div>
                            </div>
                        @endif
                        @if (config('dashboard.total_client_due') == 1)
                            <div class="card border-0 mb-3" title="{{ __('messages.sales') }} + {{ __('messages.client') }} {{ __('messages.previous_due') }}">
                                <div class="card-body short-card d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('dashboard/img/icons/total-due.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                        <h5 class="mb-0">{{ __('messages.client') }} {{ __('messages.due') }}</h5>
                                    </div>
                                    <h5 class="mb-0">{{ (siteSettings()->total_client_due ?? config('total_client_due')) . ' ' . config('company.currency_symbol') }}</h5>
                                </div>
                            </div>
                        @endif
                        @if (config('dashboard.total_client_advance') == 1)
                            <div class="card border-0 mb-3" title="{{ __('messages.sales') }} + {{ __('messages.client') }} {{ __('messages.previous_due') }}">
                                <div class="card-body short-card d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('dashboard/img/icons/total-due.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                        <h5 class="mb-0">{{ __('messages.client') }} {{ __('messages.advance') }}</h5>
                                    </div>
                                    <h5 class="mb-0">{{ (siteSettings()->total_client_advance ?? config('total_client_advance')) . ' ' . config('company.currency_symbol') }}</h5>
                                </div>
                            </div>
                        @endif
                        <div class="card border-0 mb-3" title="{{ __('messages.sales') }} + {{ __('messages.client') }} {{ __('messages.previous_due') }}">
                            <div class="card-body short-card d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/img/icons/total-due.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                    <h5 class="mb-0">{{ __('messages.total_due') }}</h5>
                                </div>
                                <h5 class="mb-0">{{ (siteSettings()->total_due ?? config('total_due')) . ' ' . config('company.currency_symbol') }}</h5>
                            </div>
                        </div>
                        <div class="card border-0 mb-3">
                            <div class="card-body short-card d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/img/icons/deposit.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                    <h5 class="mb-0">{{ __('messages.receive') }}</h5>
                                </div>
                                <h5 class="mb-0">{{ (siteSettings()->total_deposit ?? config('total_deposit')) . ' ' . config('company.currency_symbol') }}</h5>
                            </div>
                        </div>
                        <div class="card border-0 mb-3">
                            <div class="card-body short-card d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/img/icons/daily-expense.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                    <h5 class="mb-0">{{ __('messages.expense') }}</h5>
                                </div>
                                <h5 class="mb-0">{{ (siteSettings()->total_cost ?? config('total_cost')) . ' ' . config('company.currency_symbol') }}</h5>
                            </div>
                        </div>
                        @if (config('dashboard.total_client_advance') == 1)
                            <div class="card border-0 mb-3">
                                <div class="card-body short-card d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('dashboard/img/icons/return.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                        <h5 class="mb-0">{{ __('messages.total') }} {{ __('messages.return') }}</h5>
                                    </div>
                                    <h5 class="mb-0">{{ (siteSettings()->total_return ?? config('total_return')) . ' ' . config('company.currency_symbol') }}</h5>
                                </div>
                            </div>
                        @endif
                        <div class="card border-0 mb-3">
                            <div class="card-body short-card d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/img/icons/money-bag.png') }}" alt="" class="me-2 ht-25 wd-25 my-auto rounded-lg p-0">
                                    <h5 class="mb-0">{{ __('messages.balance') }}</h5>
                                </div>
                                <h5 class="mb-0">{{ (siteSettings()->total_balance ?? config('balance')) . ' ' . config('company.currency_symbol') }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-7 col-sm-6 col-12">
                    <div class="card mg-b-20">
                        <div class="card-body">
                            <div class="main-content-label mg-b-5 d-flex justify-content-between">
                                <p class="my-0 h5">{{ __('messages.invoice') }} {{ __('messages.list') }}</p>
                                <a href="{{ route('user.invoice.index') }}" class="btn btn-sm btn-info d-flex">
                                    <div class="d-flex align-items-center gap-1" style="color: white !important;">
                                        <img height="20" src="{{ asset('dashboard/svg/clipboard.svg') }}" alt=""> {{ __('messages.all') }} {{ __('messages.invoice') }} {{ __('messages.list') }}
                                    </div>
                                </a>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex">
                                        <div class="w-100 input-group">
                                            <select name="client_id" id="client_id" class="client_id form-control select2">
                                            </select>
                                        </div>
                                        <a href="javascript:;" class="btn border add-btn disabled"><i class="fas fa"></i></a>
                                    </div>
                                </div>
                                <div id="dateSearch" class="col-md-4 mb-2">
                                    <div class="input-group">
                                        <input type="text" name="date" class="invoice_id form-control" placeholder="{{ __('messages.invoice_no') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button class="btn w-100 btn-success d-flex justify-content-center clearFilter btn-lg">Clear Filter</button>
                                </div>
                            </div>
                            <table class="table table-sm table-bordered yajra-datatable" id="yajra-datatable">
                                <thead class="text-center">
                                    <th width="10%">{{ __('messages.issued_date') }}</th>
                                    <th width="15%">{{ __('messages.client') }}</th>
                                    <th>{{ __('messages.invoice') }} {{ __('messages.id_no') }}</th>
                                    <th>{{ __('messages.bill') . ' ' . __('messages.amount') }}</th>
                                    <th>{{ __('messages.discount') }}</th>
                                    <th>{{ __('messages.receive') . ' ' . __('messages.amount') }}</th>
                                    <th>{{ __('messages.due') . ' ' . __('messages.amount') }}</th>
                                    <th>{{ __('messages.type') }}</th>
                                    <th>{{ __('messages.printable') }}</th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                            {{-- <p class="mg-b-20">{{ __('messages.weekly_analysis') }}</p>
                            <div class="morris-wrapper-demo" id="weekly_sales_deposit_due_analysis_line"></div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
                    <div class="card mg-b-20">
                        <div class="card-body pb-2">
                            <div class="main-content-label mg-b-5">
                                {{ __('messages.receive') }} | {{ __('messages.expense') }} | {{ __('messages.balance') }}
                            </div>
                            <canvas class="chartjs-chart" id="balanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (config('products_show_stock_warning') == 1 || config('client.remaining_due_date') == 1)
            @include('layouts.user.stock-modal')
        @endif
    @endcan
@endsection
@push('scripts')
    {{-- @include('layouts.user.chart-morris') --}}
    @include('user.dashborad.chart.pie-chart')
    <script>
        $(document).ready(function() {
            $("#stockModal").modal("show");
        });
    </script>
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(".clearFilter").on('click', function() {
            $(".client_id").val('').trigger('change');
            $(".invoice_id").val('');
            $('.yajra-datatable').DataTable().ajax.reload();
            fetchClients();
            fetchAccounts();
        });

        function remainingDueDate(id) {
            var data_id = id;
            $("#client_id_for_due").val(id);
            $("#remainingDueDate").modal('show');
            var url = '{{ route('user.client.remaining.due.date', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    setTimeout(() => {
                        var dueDate = data.remaining_due_date ?? '';
                        $("#remaining_due_date").val(dueDate);
                    }, 200);
                }
            });
        }

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
                        title: 'Updated!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#client_id_for_due").val('');
                    location.reload();
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

        function updateYearlyBalance() {
            $.ajax({
                url: "{{ route('update.total.balance') }}",
                type: "GET",
                success: function(data) {
                    location.reload();
                }
            });
        }

        $(function() {
            fetchClients();
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#client_id, #account_id, #starting_date, #ending_date, .invoice_id").on("change input", function() {
                dataTable.ajax.reload();
            });
            @if ($_SERVER['QUERY_STRING'] == 'draft')
                setTimeout(() => {
                    var draft = $('#draft').keyup();
                }, 500);
            @endif
            dataTable = $('#yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 8,
                lengthMenu: [
                    [5, 10],
                    [5, 10],
                ],
                dom: '',
                buttons: [
                    'reset',
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $(".client_id").val();
                        d.invoice_id = $('.invoice_id').val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error, e.g., display a message or take appropriate action
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },
                columns: [{
                        data: 'issued_date',
                        name: 'issued_date',
                        orderable: false,
                    },
                    {
                        data: 'client_id',
                        name: 'client_id',
                        orderable: false,
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'bill_amount',
                        name: 'bill_amount',
                        orderable: false,
                    },
                    {
                        data: 'discount',
                        name: 'discount',
                        orderable: false,
                    },
                    {
                        data: 'receive_amount',
                        name: 'receive_amount',
                        orderable: false,
                    },
                    {
                        data: 'due_amount',
                        name: 'due_amount',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                    },
                    {
                        data: 'printable',
                        name: 'printable',
                        orderable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var billAmountTotal = 0;
                        var totalDiscount = 0;
                        var receiveAmountTotal = 0;
                        var dueAmountTotal = 0;

                        // Check if data is present before processing
                        if (json.data && json.data.length > 0) {
                            // Loop through the rows in the current page
                            $('#yajra-datatable tbody tr').each(function() {
                                var row = dataTable.row($(this)).data(); // Get the data for the row
                                if (typeof row.bill_amount !== 'undefined') {
                                    var billAmount = parseFloat(row.bill_amount);

                                    if (!isNaN(billAmount)) {
                                        billAmountTotal += billAmount;
                                    }
                                }
                                if (typeof row.discount !== 'undefined') {
                                    var discountAmount = parseFloat(row.discount);

                                    if (!isNaN(discountAmount)) {
                                        totalDiscount += discountAmount;
                                    }
                                }
                                if (typeof row.receive_amount !== 'undefined') {
                                    var receiveAmount = parseFloat(row.receive_amount);

                                    if (!isNaN(receiveAmount)) {
                                        receiveAmountTotal += receiveAmount;
                                    }
                                }
                                if (typeof row.due_amount !== 'undefined') {
                                    var dueAmount = parseFloat(row.due_amount);

                                    if (!isNaN(dueAmount)) {
                                        dueAmountTotal += dueAmount;
                                    }
                                }
                            });
                        }

                        // Remove existing footer (if any)
                        $('#yajra-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="4">Total</td><td>' + billAmountTotal + '</td><td>' + totalDiscount + '</td><td>' + receiveAmountTotal + '</td><td>' + dueAmountTotal + '</td><td colspan="4"></td></tr></tfoot>';
                        // $('#yajra-datatable').append(tfootContent);
                    }

                    // Calculate and add the footer totals initially
                    updateFooterTotals();

                    // Bind the updateFooterTotals function to the draw.dt event
                    dataTable.on('draw.dt', function() {
                        updateFooterTotals();
                    });
                }

            });
            var printButton = $('<a href="javascript:;" id="printButton" class="btn btn-primary dt-button"><i class="fas fa-print" style="font-size: 15px"></i> {{ __('messages.print') }}</a>');
            dataTable.buttons().container().prepend(printButton);
            printButton.on('click', function() {
                var scriptElement = document.createElement('script');
                scriptElement.src = '{{ asset('dashboard/js/custom-print-button.js') }}';
                document.body.appendChild(scriptElement);
            });
        });
    </script>
@endpush
