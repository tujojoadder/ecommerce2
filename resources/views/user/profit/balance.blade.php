@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">{{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.account.create') }}" class="btn btn-success me-2">{{ __('messages.add_new') }}</a>
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/936WX3EYwJk?si=KsO6JmLPCBwaedI9">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card-body bg-white table-responsive" id="printableArea">
                            @include('layouts.user.print-header')
                            <div class="d-flex justify-content-between">
                                <h5 class="my-0">
                                    @if (request()->starting_date)
                                        <span class="text-danger">{{ __('messages.profit') }} of </span> {{ bnToEnDate(request()->starting_date)->format('d M Y') }} <span class="text-danger">to</span> {{ bnToEnDate(request()->ending_date)->format('d M Y') }}
                                    @endif
                                </h5>
                                <a href="javascript:;" onclick="printDiv('printableArea')" class="btn btn-sm btn-info rounded-0 me-1 hide-on-print">
                                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                                </a>
                            </div>
                            <table id="yajra-datatable" class="table table-bordered table-hover text-left">
                                <thead>
                                    <tr class="text-center">
                                        <th>{{ __('messages.title') }}</th>
                                        <th>{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total_self_investment') }}</td>
                                        <td class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($selfInvestment, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total_supplier_due') }}</td>
                                        <td class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalSupplierDue, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total_stock_value') }}</td>
                                        <td class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format(getStockValue(), 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total_loan') }}</td>
                                        <td class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalLoanAmount, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total_client_advance') }}</td>
                                        <td class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalClientAdvance, 2)) }}</td>
                                    </tr>
                                    <tr class="font-weight-bolder">
                                        <td class="p-1">{{ __('messages.total_running_capital') }}</td>
                                        <td class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalRunningCapital, 2)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function printDiv(divName) {
            var hideOnPrintClass = 'hide-on-print';

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            var style = document.createElement('style');
            style.innerHTML = '@media print {.' + hideOnPrintClass + ' { display: none; } }';
            document.head.appendChild(style);

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

            document.head.removeChild(style);

            var mediaQueryList = window.matchMedia('print');
            if (!mediaQueryList.matches) {
                location.reload();
            } else {
                mediaQueryList.addEventListener('change', function(mql) {
                    if (!mql.matches) {
                        location.reload();
                    }
                });
            }
        }
    </script>
@endpush
