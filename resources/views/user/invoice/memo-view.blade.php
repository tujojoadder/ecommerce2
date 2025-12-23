@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <link rel="stylesheet" href="{{ asset('dashboard/css/invoice.css') }}">
    <style>
        #footer {}
    </style>
    <div class="card p-2">
        <div class="card-body">
            <div class="d-flex">
                <a href="javascript:;" onclick="printDiv('printableArea')" class="btn btn-info rounded-0 me-1">
                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                </a>
                <a href="{{ route('user.invoice.create') }}" class="btn btn-success rounded-0 me-1"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
            </div>
        </div>
        <div class="card rounded-0 summery_copy" style="border-radius: 0 !important; border-bottom: 1px !important;">
            <div class="card-body rounded-0 p-2" id="printableArea">
                <div class="section1">
                    <div class="row mx-auto justify-content-center align-items-center">
                        <div class="col-12">
                            <h4 style="font-weight: 600;" class="text-center">{{ config('company.invoice-greetings') }}</h4>
                        </div>
                        <div class="col-2"><img src="{{ config('company.logo') }}" alt=""></div>
                        <div class="col-8">
                            <h1 style="font-size: 55px; text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold;">{{ config('company.name') }}</h1>
                        </div>
                        <div class="col-2"><img src="{{ config('company.logo') }}" alt=""></div>
                        <div class="col-12">
                            <h2 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold; color: rgb(0, 176, 80);">{{ config('company.proprietor') }}</h2>
                            <h4 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold;">{{ config('company.description') }}</h4>
                            <h4 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold;">{{ config('company.address_optional') }}</h4>
                            <h4 style="text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold;">{{ __('messages.contact') }}: {{ config('company.phone') }}</h4>
                        </div>
                        <div class="col-12 row justify-content-between">
                            <div class="col-8">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.client_id') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:100%"> {{ $invoice->client->id ?? '' }}</span>
                                    </div>
                                </h4>
                            </div>
                            <div class="col-4 text-start">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.date') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:100%"></span>
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 row justify-content-between">
                            <div class="col-7">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.name') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:95%"> {{ $invoice->client->client_name ?? '' }}</span>
                                    </div>
                                </h4>
                            </div>
                            <div class="col-5 text-start">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.contact_no') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:100%"> {{ $invoice->client->phone ?? '' }}</span>
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 row justify-content-between">
                            <div class="col-12">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.fathers_name') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:86%"> {{ $invoice->client->fathers_name ?? '' }}</span>
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <div class="col-12 row justify-content-between">
                            <div class="col-7">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.address') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:100%"> {{ $invoice->client->address ?? '' }}</span>
                                    </div>
                                </h4>
                            </div>
                            <div class="col-5 text-start">
                                <h4 style="font-family: 'Times New Roman', Times, serif;">
                                    <div class="d-flex">
                                        <b>{{ __('messages.street_road') }}:</b> <span style="border-bottom: 3px dashed steelblue; width:68%"> {{ $invoice->client->street_road ?? '' }}</span>
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid black !important;">
                                            <h5 class="text-center mb-0">{{ __('messages.sl') }}</h5>
                                        </th>
                                        <th style="border: 1px solid black !important;">
                                            <h5 class="text-center mb-0">{{ __('messages.product') }} {{ __('messages.description') }}</h5>
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
                                            <td style="border: 1px solid black !important; font-weight: bolder">{{ $loop->iteration }}.</td>
                                            <td style="border: 1px solid black !important;">
                                                {{ $item->product->name ?? '' }}
                                            </td>
                                            <td style="border: 1px solid black !important;">{{ $item->quantity }}</td>
                                            <td style="border: 1px solid black !important;">{{ $item->unit->name ?? '' }}</td>
                                            <td style="border: 1px solid black !important;">{{ $item->selling_price ?? '' }}</td>
                                            <td style="border: 1px solid black !important;">{{ $item->total ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td style="border: 0px !important;" colspan="4" rowspan="9" style="vertical-align: baseline !important;">
                                            <span class="font-weight-bolder">{{ __('messages.in_words') }}:</span>
                                        </td>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.total') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $invoice->grand_total + $invoice->discount }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.discount') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $invoice->discount }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.labour_cost') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $invoice->labour_cost }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.transport_fare') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $invoice->transport_fare }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.previous_due') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $previousDue = $clientDue - $due }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.invoice') }} {{ __('messages.due') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $due }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.payment') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $payment }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid black !important; font-weight: bolder;">{{ __('messages.total') }} {{ __('messages.due') }}</td>
                                        <td style="border: 1px solid black !important;" class="text-center">{{ $previousDue + $due - $payment }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 mt-5 pt-5 mx-auto" id="footer">
                            <div class="row justify-content-between" style="display: flex !important; justify-content: space-between !important;">
                                <div class="col-2 text-start"><span class="font-weight-bolder">{{ __('messages.received_by') }}</span></div>
                                <div class="col-2 text-center"><span class="font-weight-bolder">{{ __('messages.reference_by') }}</span></div>
                                <div class="col-3 text-end"><span class="font-weight-bolder">{{ __('messages.authorization_signature') }}</span></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-center my-5 text-danger">{{ config('company.invoice-footer') }}</p>
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
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            // Reload the page after the print dialog is closed
            var mediaQueryList = window.matchMedia('print');
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
        }
    </script>
@endpush
