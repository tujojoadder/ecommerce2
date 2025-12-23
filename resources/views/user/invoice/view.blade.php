@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <link rel="stylesheet" href="{{ asset('dashboard/css/invoice.css') }}">
    <div class="card p-2">
        <div class="card-body">
            <div class="d-flex">
                <a href="javascript:;" onclick="printDiv('printableArea')" class="btn btn-info rounded-0 me-1 printBtn">
                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                </a>
                <a href="javascript:;" onclick="printWithoutHeader('printableAreaWithoutHeader')" class="btn btn-info rounded-0 me-1 printBtn">
                    <i class="fas fa-print"></i> {{ __('messages.print_without_header') }}
                </a>
                <a href="{{ route('user.invoice.share.invoice', $invoice->id) }}" class="btn btn-info rounded-0 me-1">
                    <i class="fas fa-share"></i> {{ __('messages.share') }}
                </a>
                <a href="{{ route('user.invoice.index') }}?create" class="btn btn-success rounded-0 me-1"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
            </div>
        </div>
        <div class="rounded-0 summery_copy p-2">
            <div class="card-body rounded-0 p-2" id="printableArea" style="background-color: #e7e5f559;">
                @include('user.invoice.invoice-header')
                <div class="section1" id="printableAreaWithoutHeader">
                    <div class="section2">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between" style="">
                                @if (config('settings_custom_header') == 1)
                                    <table class="table table-bordered text-left mt-3" style="width: 40% !important; margin-bottom: -1px !important;">
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.company_name') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ $invoice->client->company_name ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.client') }} {{ __('messages.name') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ $invoice->client->client_name ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.phone_number') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ $invoice->client->phone ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.transport') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ $invoice->client->transport ?? '--' }}</td>
                                        </tr>
                                    </table>
                                    {{-- <div class="position-absolute" style="margin-top: -11%; margin-left: 13%;"> --}}
                                    @if (config('invoices_qr_code') == 1)
                                        <style>
                                            .position- svg {
                                                margin-top: 16px;
                                                height: 80px !important;
                                            }
                                        </style>
                                        <div class="position-">
                                            {{ generateQrCode(clientInfo($invoice->client_id, $invoice->id)) }}
                                        </div>
                                    @endif
                                    <table class="table table-bordered text-left mt-3" style="width: 40% !important; margin-bottom: -1px !important;">
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.invoice_no') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ $invoice->id }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.issued_date') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ bnDateFormat($invoice->issued_date) }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;"><strong>{{ __('messages.address') }}</strong></td>
                                            <td style="border:1px solid black; padding-top: 0px !important; padding-bottom: 0px !important;" style="font-weight:600;">{{ $invoice->client->address ?? '--' }}</td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="section3">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-dark">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.sl') }}</h5>
                                            </th>
                                            <th colspan="5" style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.product') }} {{ __('messages.details') }}</h5>
                                            </th>
                                            <th colspan="2" style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.bill_amount') }}</h5>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.product') }}</h5>
                                            </th>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.description') }}</h5>
                                            </th>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.selling_type') }}</h5>
                                            </th>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.quantity') }}</h5>
                                            </th>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.unit') }}</h5>
                                            </th>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.rate') }}</h5>
                                            </th>
                                            <th style="border: 1px solid black !important;">
                                                <h5 class="text-center mb-0">{{ __('messages.amount') }}</h5>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->invoiceItems as $item)
                                            <tr class="text-center">
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder">{{ $loop->iteration }}.</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; ">{{ $item->product->name ?? '' }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; ">{{ $item->description ?? '' }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; ">{{ str_replace('_', ' ', ucwords($item->selling_type)) }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; ">{{ $item->quantity }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; ">{{ $item->unit->name ?? '' }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; ">{{ $item->selling_price ?? '' }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ $item->total ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td style="border: 0px !important; vertical-align: baseline !important; padding-top: 10px !important;" colspan="6" rowspan="10">
                                                <span class="font-weight-bolder">{{ __('messages.in_words') }}: </span>{{ ucwords(number2word($netDue)) }}
                                                <br>
                                                <br>
                                                <span class="font-weight-bolder">{{ __('messages.description') }}: </span><br>{!! $invoice->description !!}
                                                {{-- @if ($invoiceDue > 0 && $payment > 0)
                                                    <img style="position: relative; left: 50%; margin-top: -4%;" width="100" src="{{ asset('invoice-status/partial_paid.png') }}" alt="">
                                                @elseif ($invoiceDue > 0)
                                                    <img style="position: relative; left: 50%; margin-top: -4%;" width="100" src="{{ asset('invoice-status/unpaid.png') }}" alt="">
                                                @elseif ($invoiceDue <= 0)
                                                    <img style="position: relative; left: 50%; margin-top: -4%;" width="100" src="{{ asset('invoice-status/paid.png') }}" alt="">
                                                @endif --}}
                                            </td>
                                            <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.sub_total') }}</td>
                                            <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($invoice->billAmount($invoice->id), 2) }}</td>
                                        </tr>
                                        @if (!Route::is('user.invoice.challan') && $invoice->status !== 5)
                                            @if ($invoice->transport_fare >= 1)
                                                <tr>
                                                    <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.transport_fare') }}</td>
                                                    <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($invoice->transport_fare, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($invoice->vat >= 1)
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.vat') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($invoice->total_vat, 2) }}</td>
                                            </tr>
                                            @endif
                                            @if ($invoice->labour_cost >= 1)
                                                <tr>
                                                    <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.labour_cost') }}</td>
                                                    <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($invoice->labour_cost, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($invoice->discount >= 1)
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.discount') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($invoice->total_discount, 2) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.shipping_charge') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ $invoice->total_shipping_charge ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.invoice_bill') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ $invoice->grand_total }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.payment') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($payment, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.invoice') }} {{ __('messages.due') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($invoiceDue, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.previous_due') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ $previousDue = number_format($invoice->previous_due, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black !important; font-size: 16px !important;  font-weight: bolder;">{{ __('messages.net_due') }}</td>
                                                <td style="border: 1px solid black !important; font-size: 16px !important; " class="text-end">{{ number_format($netDue, 2) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (!Route::is('user.invoice.challan'))
                        @if ($invoice->account->title == 'cheque' || $invoice->account->title == 'Cheque' || $invoice->account->title == 'চেক')
                            <div class="">
                                <p class="my-0">{{ __('messages.bank') }}: {{ $invoice->bank->name ?? '' }}</p>
                                <p class="my-0">{{ __('messages.cheque_number') }}: {{ $invoice->cheque_number }}</p>
                                <p class="my-0">{{ __('messages.cheque_issued_date') }}: {{ bnDateFormat($invoice->cheque_issued_date) }}</p>
                            </div>
                        @endif
                        <hr>
                        {!! nl2br(e($invoice->warranty)) !!}
                    @endif

                    <div class="section4">
                        <div class="d-flex justify-content-between my-5 position-relative">
                            <div class="font-weight-bolder p-2" style="width:30%; color: black !important;">{{ __('messages.buyer') }} {{ __('messages.signature') }} : </div>
                            <div class="font-weight-bolder p-2" style="width:30%; color: black !important;">{{ __('messages.seller') }} {{ __('messages.signature') }} : </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @if (request()->query('print') == 1)
        <script>
            $(document).ready(function() {
                setTimeout(() => {
                    printDiv('printableArea');
                }, 1000);
            });
        </script>
    @endif
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;

            var styleTag = document.createElement('style');
            styleTag.innerHTML = `
                @media print {
                    .overlay-img{
                        position: absolute !important;
                        top: 20% !important;
                        width: 70% !important;
                        filter: opacity(1) !important;
                        left: 15% !important;
                        z-index: 9999999 !important;
                    }
                    table.table{
                        width: 100% !important;
                        background-color: transparent !important;
                    }
                    table.table td{
                        background-color: transparent !important;
                    }
                }
            `;
            document.head.appendChild(styleTag);

            window.print();
            document.body.innerHTML = originalContents;
            // Reload the page after the print dialog is closed
            var mediaQueryList = window.matchMedia('print');
            @if (request()->query('print') == 1)
                if (!mediaQueryList.matches) {
                    location.href = "{{ route('user.invoice.index') }}";
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.href = "{{ route('user.invoice.index') }}";
                        }
                    });
                }
            @else
                if (!mediaQueryList.matches) {
                    location.reload();
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.reload();
                        }
                    });
                }
            @endif
        }
    </script>
    <script>
        function printWithoutHeader(divIdName) {
            var printContents = document.getElementById(divIdName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;

            var styleTag = document.createElement('style');
            styleTag.innerHTML = `
                @media print {
                    .overlay-img{
                        display: none !important;
                    }
                    table.table{
                        width: 100% !important;
                        background-color: transparent !important;
                    }
                    table.table td{
                        background-color: transparent !important;
                    }
                }
            `;
            document.head.appendChild(styleTag);

            window.print();
            document.body.innerHTML = originalContents;
            // Reload the page after the print dialog is closed
            var mediaQueryList = window.matchMedia('print');
            @if (request()->query('print') == 1)
                if (!mediaQueryList.matches) {
                    location.href = "{{ route('user.invoice.index') }}";
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.href = "{{ route('user.invoice.index') }}";
                        }
                    });
                }
            @else
                if (!mediaQueryList.matches) {
                    location.reload();
                } else {
                    // Use the change event to detect when the print media query is no longer matching
                    mediaQueryList.addEventListener('change', function(mql) {
                        if (!mql.matches) {
                            location.reload();
                        }
                    });
                }
            @endif
        }
    </script>
@endpush
