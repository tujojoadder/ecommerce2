<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        {!! file_get_contents(public_path('dashboard/plugin/bootstrap/css/bootstrap.css')) !!} body {
            font-family: Arial, sans-serif;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #000000;
        }

        strong {
            font-weight: bold;
        }

        .customer-details {
            width: 40% !important;
        }

        .customer-details tr td {
            border: 1px solid black !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        .customer-details td:nth-child(1),
        th,
        strong {
            background-color: gainsboro !important;
        }
    </style>
    @if (siteSettings()->language == 'bn')
        <style>
            .customer-details td:nth-child(1),
            th,
            strong {
                font-family: 'solaimanlipi', sans-serif;
                font-size: 18px !important;
                font-weight: bold !important;
            }
        </style>
    @endif

</head>

<body>
    <div class="rounded-0 summery_copy">
        <div class="card-body rounded-0 p-2" id="printableArea" style="background-color: white;">
            @if (config('settings_custom_header') == 1)
                <img class="mb-0" src="{{ config('company.invoice_header') }}" alt="" width="100%">
                <p class="h3 text-center text-dark mt-2" style="font-family: {{ siteSettings()->language == 'bn' ? "'solaimanlipi', sans-serif; font-size: 20px;" : "'Courier New', Courier, monospace;" }}; font-weight: bold;">{{ $data['pageTitle'] }}</p>
            @else
                <div class="row px-0 py-3" style="padding-bottom: 2px !important;">
                    <div class="col-12">
                        <h4 style="font-weight: 600;" class="text-center">{{ config('company.invoice-greetings') }}</h4>
                    </div>
                    <div class="col-2 d-flex justify-content-center"></div>
                    <div class="col-8">
                        <h1 style="font-size: 35px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">{{ config('company.name') }}</h1>
                    </div>
                    <div class="col-2 d-flex justify-content-center"></div>
                    <div class="col-12">
                        <h4>{{ config('company.description') }}</h4>
                        <h4>{{ config('company.address_optional') }}</h4>
                        <h4>{{ __('messages.contact_no') }} - {{ config('company.phone') }}</h4>
                        <h4>{{ __('messages.email') }} - {{ config('company.email') }}</h4>
                        <h4>{{ __('messages.website') }} - {{ config('company.website') }}</h4>
                        <h4>{{ __('messages.invoice_no') }} : {{ $data['invoice']->id }}</h4>
                    </div>
                    <p class="h3 text-center text-danger" style="font-family: {{ siteSettings()->language == 'bn' ? "'solaimanlipi', sans-serif'" : "'Courier New', Courier, monospace'" }}; font-weight: bold;">{{ $data['pageTitle'] }}</p>
                    <div class="col-12 row justify-content-between mx-auto">
                        <div class="col-8 ps-0">
                            <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                                <div class="d-flex">
                                    <b>{{ __('messages.name') }} : <span style="font-weight: normal !important;">{{ $data['invoice']->client->client_name ?? '' }}</span> </b>
                                </div>
                            </h5>
                            <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                                <div class="d-flex">
                                    <b>{{ __('messages.address') }} : <span style="font-weight: normal !important;">{{ $data['invoice']->client->address ?? '' }}</span> </b>
                                </div>
                            </h5>
                        </div>
                        <div class="col-4 pe-0">
                            <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                                <div class="d-flex justify-content-end">
                                    <b>{{ __('messages.date') }} : <span style="font-weight: normal !important;">{{ bnDateFormat($data['invoice']->issued_date) }}</span> </b>
                                </div>
                            </h5>
                            <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                                <div class="d-flex justify-content-end">
                                    <b>{{ __('messages.contact_no') }} : <span style="font-weight: normal !important;">{{ $data['invoice']->client->phone ?? '' }} {{ $data['invoice']->client->phone_optional ?? '' }}</span> </b>
                                </div>
                            </h5>
                        </div>
                    </div>
                </div>
            @endif

            <div class="section1" id="printableAreaWithoutHeader">

                <div class="section2">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            @if (config('settings_custom_header') == 1)
                                <table class="table table-bordered text-left mt-3 customer-details">
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.company_name') }}</strong></td>
                                        <td>{{ $data['invoice']->client->company_name ?? '--' }}</td>
                                    </tr>
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.client') }} {{ __('messages.name') }}</strong></td>
                                        <td>{{ $data['invoice']->client->client_name ?? '--' }}</td>
                                    </tr>
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.phone_number') }}</strong></td>
                                        <td>{{ $data['invoice']->client->phone ?? '--' }}</td>
                                    </tr>
                                </table>
                                <table class="table table-bordered text-left mt-3 customer-details">
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.transport') }}</strong></td>
                                        <td>{{ $data['invoice']->client->transport ?? '--' }}</td>
                                    </tr>
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.invoice_no') }}</strong></td>
                                        <td>{{ $data['invoice']->id }}</td>
                                    </tr>
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.issued_date') }}</strong></td>
                                        <td>{{ bnDateFormat($data['invoice']->issued_date) }}</td>
                                    </tr>
                                    <tr class="border border-dark">
                                        <td width="30%"><strong>{{ __('messages.address') }}</strong></td>
                                        <td>{{ $data['invoice']->client->address ?? '--' }}</td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="section3">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered text-dark items-table">
                                <thead>
                                    <tr class="border border-dark">
                                        <th rowspan="2">
                                            <small>{{ __('messages.sl') }}</small>
                                        </th>
                                        <th colspan="4">
                                            <small>{{ __('messages.product') }} {{ __('messages.details') }}</small>
                                        </th>
                                        <th colspan="2">
                                            <small>{{ __('messages.bill_amount') }}</small>
                                        </th>
                                    </tr>
                                    <tr class="border border-dark">
                                        <th>
                                            <small>{{ __('messages.product') }}</small>
                                        </th>
                                        <th>
                                            <small>{{ __('messages.description') }}</small>
                                        </th>
                                        <th>
                                            <small>{{ __('messages.quantity') }}</small>
                                        </th>
                                        <th>
                                            <small>{{ __('messages.unit') }}</small>
                                        </th>
                                        <th>
                                            <small>{{ __('messages.rate') }}</small>
                                        </th>
                                        <th>
                                            <small>{{ __('messages.amount') }}</small>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['invoice_items'] as $item)
                                        <tr class="text-center border border-dark">
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $item->product->name ?? '' }}</td>
                                            <td>{{ $item->description ?? '' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->unit->name ?? '' }}</td>
                                            <td>{{ $item->selling_price ?? '' }}</td>
                                            <td class="text-end">{{ $item->total ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="border border-dark">
                                        <td colspan="5" rowspan="10">
                                            <span class="font-weight-bolder">{{ __('messages.in_words') }}: </span>{{ ucwords(number2word($data['invoice']->grand_total + $data['invoice']->previous_due)) }}
                                            <br>
                                            <br>
                                            <span class="font-weight-bolder">{{ __('messages.description') }}: </span><br>{!! $data['invoice']->description !!}
                                        </td>
                                        <td>{{ __('messages.total') }}</td>
                                        <td class="text-end">{{ number_format($data['invoice']->billAmount($data['invoice']->id), 2) }}</td>
                                    </tr>
                                    @if (!Route::is('user.invoice.challan') && $data['invoice']->status !== 5)
                                        @if ($data['invoice']->discount >= 1)
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.discount') }}</td>
                                                <td class="text-end">{{ number_format($data['invoice']->discount, 2) }}</td>
                                            </tr>
                                        @endif
                                        @if ($data['invoice']->labour_cost >= 1)
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.labour_cost') }}</td>
                                                <td class="text-end">{{ number_format($data['invoice']->labour_cost, 2) }}</td>
                                            </tr>
                                        @endif
                                        @if ($data['invoice']->transport_fare >= 1)
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.transport_fare') }}</td>
                                                <td class="text-end">{{ number_format($data['invoice']->transport_fare, 2) }}</td>
                                            </tr>
                                        @endif
                                        @if ($data['invoice']->vat >= 1)
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.vat') }}</td>
                                                <td class="text-end">{{ number_format($data['invoice']->vat, 2) }}</td>
                                            </tr>
                                        @endif
                                        @if ($data['invoice']->status !== 4)
                                            {{-- For general invoice --}}
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.previous_due') }}</td>
                                                <td class="text-end">{{ $previousDue = number_format($data['invoice']->previous_due, 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.total_due') }}</td>
                                                <td class="text-end">{{ number_format($data['totalDue'], 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.invoice') }} {{ __('messages.due') }}</td>
                                                <td class="text-end">{{ number_format($data['invoiceDue'], 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.payment') }}</td>
                                                <td class="text-end">{{ number_format($data['payment'], 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.net_due') }}</td>
                                                <td class="text-end">{{ number_format($data['netDue'], 2) }}</td>
                                            </tr>
                                        @else
                                            {{-- For return invoice --}}
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.previous_due') }}</td>
                                                <td class="text-end">{{ $previousDue = number_format($data['invoice']->due_before_return, 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.total_due') }}</td>
                                                <td class="text-end">{{ number_format($data['totalDue'], 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.invoice') }} {{ __('messages.return') }}</td>
                                                <td class="text-end">{{ number_format($data['invoiceDue'], 2) }}</td>
                                            </tr>
                                            <tr class="border border-dark">
                                                <td>{{ __('messages.net_due') }}</td>
                                                <td class="text-end">{{ number_format($data['netDue'], 2) }}</td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if (!Route::is('user.invoice.challan'))
                    @if ($data['invoice']->account->title == 'cheque' || $data['invoice']->account->title == 'Cheque' || $data['invoice']->account->title == 'চেক')
                        <div class="">
                            <p class="my-0">{{ __('messages.bank') }}: {{ $data['invoice']->bank->name ?? '' }}</p>
                            <p class="my-0">{{ __('messages.cheque_number') }}: {{ $data['invoice']->cheque_number }}</p>
                            <p class="my-0">{{ __('messages.cheque_issued_date') }}: {{ bnDateFormat($data['invoice']->cheque_issued_date) }}</p>
                        </div>
                    @endif
                    {!! nl2br(e($data['invoice']->warranty)) !!}
                @endif

                <div class="section4 mt-5">
                    <table class="table table-borderless">
                        <tbody>
                            <tr class="border-0">
                                <td class="border-0">
                                    <div class="font-weight-bolder signature p-2">{{ __('messages.buyer') }} {{ __('messages.signature') }} : </div>
                                </td>
                                <td class="border-0">
                                    <div class="font-weight-bolder seller-signature p-2">{{ __('messages.seller') }} {{ __('messages.signature') }} : </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
