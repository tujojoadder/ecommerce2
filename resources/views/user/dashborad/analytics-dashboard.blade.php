@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="card p-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <p class="card-title my-0">{{ $pageTitle }}</p>
                <a href="{{ route('user.home') }}" class="btn btn-info">
                    <img src="{{ asset('icon/new/dashboard.svg') }}" alt=""> {{ __('messages.dashboard') }}
                </a>
            </div>
            <div class="row mt-4">
                <div class="col-xl-4">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title my-0">Sales</div>
                        </div>
                        <div class="card-body p-1">
                            <div class="salesChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title my-0">Receive</div>
                        </div>
                        <div class="card-body p-1">
                            <div class="receiveChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title my-0">Due</div>
                        </div>
                        <div class="card-body p-1">
                            <div class="dueChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0"><span style="color: #00879E !important;">Income</span> | <span style="color: #EC8305 !important;">Expense</span> | <span style="color: #347928 !important;">Balance</span></div>
                        </div>
                        <div class="card-body">
                            <div class="balances"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">Top Product</div>
                            <form action="" method="GET">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- <label for="">Search With Date</label> --}}
                                        <div class="input-group">
                                            <input type="text" name="start_date" class="form-control fc-datepicker" value="{{ $_GET['start_date'] ?? '' }}" placeholder="Start Date" required>
                                            <input type="text" name="end_date" class="form-control fc-datepicker" value="{{ $_GET['end_date'] ?? '' }}" placeholder="End Date" required>
                                            <button type="submit" class="btn btn-info">{{ __('messages.search') }}</button>
                                            <a href="{{ route('user.analytics') }}" class="btn add-btn btn-secondary">{{ __('messages.clear_filter') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <canvas id="productBar" class="chartjs-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('user.dashborad.chart.sales-bar')
    @include('user.dashborad.chart.receive-bar')
    @include('user.dashborad.chart.due-bar')
    @include('user.dashborad.chart.expense-bar')
    {{-- @include('user.dashborad.chart.pie-chart') --}}
    @include('user.dashborad.chart.product-bar')
    @include('user.dashborad.chart.balance-bar')
@endpush
