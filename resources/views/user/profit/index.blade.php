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
                        <form action="">
                            <div class="row justify-content-center mt-3">
                                <div id="dateSearch" class="col-md-8">
                                    <label for="">{{ __('messages.search_by_date') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="starting_date" class="fc-datepicker starting_date form-control" value="{{ request()->starting_date }}" placeholder="DD/MM/YYYY" required>
                                        <input type="text" name="ending_date" class="fc-datepicker ending_date form-control" value="{{ request()->ending_date }}" placeholder="DD/MM/YYYY" required>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-lg-2 mb-5">
                                    <label for="button">&nbsp;</label>
                                    <button type="submit" class="btn btn-block btn-lg btn-secondary">{{ __('messages.search') }}</button>
                                </div>
                            </div>
                        </form>
                        <div class="card-body bg-white table-responsive" id="printableArea">
                            @include('layouts.user.print-header')
                            <div class="d-flex justify-content-between">
                                <h5 class="my-0">
                                    @if (request()->starting_date)
                                        <span class="text-danger">{{ __('messages.profit') }} of </span> {{ bnToEnDate(request()->starting_date)->format('d M Y') }} <span class="text-danger">to</span> {{ bnToEnDate(request()->ending_date)->format('d M Y') }}
                                    @endif
                                </h5>
                                <a href="javascript:;" onclick="printDiv('printableArea')" class="btn btn-sm btn-info rounded-0 me-0 mb-1 hide-on-print">
                                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                                </a>
                            </div>
                            <table id="yajra-datatable" class="table table-bordered table-hover text-left">
                                <thead style="background-color: gray !important;">
                                    <tr class="text-center">
                                        <th colspan="2">{{ __('messages.profit') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.sales') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalSales, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.buy') }} {{ __('messages.price') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalBuyPrice, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.discount') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalDiscount, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.gross_profit') }} / {{ __('messages.product') }} {{ __('messages.profit') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($grossProfit = ($totalSales - $totalBuyPrice - $totalDiscount), 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.other') }} {{ __('messages.expense') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalExpense, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.net_profit') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($grossProfit - $totalExpense, 2)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <table id="yajra-datatable" class="table table-bordered table-hover text-left">
                                <thead style="background-color: gray !important;">
                                    <tr class="text-center">
                                        <th colspan="2">{{ __('messages.balance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.purchase') }} {{ __('messages.price') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalPurchasePrice, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.supplier') }} {{ __('messages.payment') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalSupplierPayment, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.supplier') }} {{ __('messages.due') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalPurchasePrice - $totalSupplierPayment, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.client') }} {{ __('messages.due') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalDue, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.opening_balance') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($openingBalance, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.receive') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalReceive, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.other') }} {{ __('messages.expense') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalExpense - $totalMoneyReturn, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.money') }} {{ __('messages.return') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalMoneyReturn, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.expense') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalExpense + $totalSupplierPayment, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.personal_expense') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalPersonalExpense, 2)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-1">{{ __('messages.total') }} {{ __('messages.balance') }}</td>
                                        <td width="30%" class="p-1 text-end">{{ config('company.currency_symbol') }} {{ str_replace(',', '', number_format($totalBalance + $openingBalance, 2)) }}</td>
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
