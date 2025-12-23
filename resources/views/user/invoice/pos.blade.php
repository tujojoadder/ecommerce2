@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <style>
        @media print {
            * {
                font-family: "Helvetica, Open Sans" !important;

            }

            #printableArea {
                width: 80mm;
            }

            #row-header {
                background-color: #0bb30b;
                color: white;
            }
        }


        #row-header {
            background-color: #0bb30b !important;
            color: white;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <a href="javascript:;" id="printBtn" onclick="printDiv('printableArea')" class="btn btn-info rounded-0 me-1">
                    <i class="fas fa-print"></i> {{ __('messages.printable') }}
                </a>
                {{-- <a href="" class="btn btn-outline-secondary rounded-0 me-1">
                    <i class="far fa-file-pdf"></i> {{ __('messages.pdf') }}
                </a> --}}
                <a href="{{ route('user.invoice.create') }}" class="btn btn-success rounded-0 me-1"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
            </div>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <div class="" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-invoice" role="tabpanel" aria-labelledby="pills-invoice-tab">
                    <div class="row justify-content-start">
                        <div class="col-md-6">
                            <div class="">
                                <div class="card-body rounded-0 px-0" id="printableArea" style="width: 80mm !important;">
                                    <table class="table table-bordered mb-1" style="width: 100% !important;">
                                        <tbody class="bg-white">
                                            <tr>
                                                <td colspan="3" class="text-center companyName">{{ config('company.name') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">{{ config('company.address') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">{{ __('messages.mobile') }}: - {{ config('company.phone') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('messages.client') }}.{{ __('messages.id_no') }}:- {{ $invoice->client_id }}</td>
                                                <td>{{ __('messages.invoice') }}.{{ __('messages.id_no') }}:- {{ $invoice->id }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ __('messages.date') }}:- {{ bnDateFormat($invoice->issued_date) }} at {{ date('h:i:s A', strtotime($invoice->created_at)) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ __('messages.created_by') }}:- {{ $invoice->created_by }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="p-0">
                                                    <table class="table p-0 m-0" id="items-table">
                                                        <tbody class="text-center">
                                                            <tr class="text-center font-weight-bolder" id="row-header">
                                                                <td style="border-left: 0px !important">{{ __('messages.name') }}</td>
                                                                <td style="border-left: 0px !important">{{ __('messages.price') }}</td>
                                                                <td style="border-left: 0px !important">{{ __('messages.quantity') }}</td>
                                                                <td style="border-left: 0px !important">{{ __('messages.total') }}</td>
                                                            </tr>
                                                            @foreach ($invoice->invoiceItems as $item)
                                                                <tr>
                                                                    <td style="border-left: 0px !important">{{ $item->product->name ?? '---' }}</td>
                                                                    <td style="border-left: 0px !important">{{ numberFormat($item->selling_price, 2) }}</td>
                                                                    <td style="border-left: 0px !important">{{ $item->quantity }}</td>
                                                                    <td style="border-left: 0px !important">{{ numberFormat($item->selling_price * $item->quantity, 2) }}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td style="border-left: 0px !important">{{ __('messages.discount') }}</td>
                                                                <td style="border-left: 0px !important">{{ '--' }}</td>
                                                                <td style="border-left: 0px !important">{{ '--' }}</td>
                                                                <td style="border-left: 0px !important">{{ numberFormat($invoice->total_discount, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-left: 0px !important">{{ __('messages.vat') }}</td>
                                                                <td style="border-left: 0px !important">{{ '--' }}</td>
                                                                <td style="border-left: 0px !important">{{ '--' }}</td>
                                                                <td style="border-left: 0px !important">{{ numberFormat($invoice->total_vat, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-left: 0px !important">{{ __('messages.transport_fare') }} & {{ __('messages.labour_cost') }}</td>
                                                                <td style="border-left: 0px !important">{{ '--' }}</td>
                                                                <td style="border-left: 0px !important">{{ '--' }}</td>
                                                                <td style="border-left: 0px !important">{{ number_format($invoice->transport_fare + $invoice->labour_cost, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-left: 0px !important">{{ __('messages.invoice') }} {{ __('messages.total') }}</td>
                                                                <td style="border-left: 0px !important">{{ numberFormat($invoice->invoiceItems->sum('selling_price'), 2) }}</td>
                                                                <td style="border-left: 0px !important">{{ numberFormat($invoice->invoiceItems->sum('quantity'), 2) }}</td>
                                                                <td style="border-left: 0px !important">{{ numberFormat($invoice->grand_total, 2) }}</td>
                                                            </tr>
                                                            <tr class="bottom-part">
                                                                <td style="border-left: 0px !important" class="text-end" colspan="2">{{ __('messages.sub_total') }} =</td>
                                                                <td style="border-left: 0px !important" colspan="2">{{ numberFormat($invoice->grand_total, 2) }}</td>
                                                            </tr>
                                                            <tr class="bottom-part">
                                                                <td style="border-left: 0px !important" class="text-end" colspan="2">{{ __('messages.payment') }} =</td>
                                                                <td style="border-left: 0px !important" colspan="2">{{ numberFormat($payment, 2) }}</td>
                                                            </tr>
                                                            <tr class="bottom-part">
                                                                <td style="border-left: 0px !important" class="text-end" colspan="2">{{ __('messages.invoice') . ' ' . __('messages.due') }} =</td>
                                                                <td style="border-left: 0px !important" colspan="2">{{ numberFormat($due, 2) }}</td>
                                                            </tr>
                                                            <tr class="bottom-part">
                                                                <td style="border-left: 0px !important" class="text-end" colspan="2">{{ __('messages.previous_due') }} =</td>
                                                                <td style="border-left: 0px !important" colspan="2">{{ numberFormat($previousDue = $clientDue - $due, 2) }}</td>
                                                            </tr>
                                                            {{-- <tr class="bottom-part">
                                                                <td style="border-left: 0px !important" class="text-end" colspan="2">{{ __('messages.total') . ' ' . __('messages.due') }} =</td>
                                                                <td style="border-left: 0px !important" colspan="2">{{ numberFormat($totalDue, 2) }}</td>
                                                            </tr> --}}
                                                            <tr class="bottom-part">
                                                                <td style="border-left: 0px !important" class="text-end" colspan="2">{{ __('messages.net_due') }} =</td>
                                                                <td style="border-left: 0px !important" colspan="2">{{ numberFormat($due + $previousDue, 2) }}</td>
                                                            </tr>
                                                            <tr class="footer-bottom-part">
                                                                <td style="border-left: 0px !important; border-bottom: 0px !important" class="text-center" colspan="4">
                                                                    <small style="font-size: 5px !important;">Software Developed By <br> www.softhostit.com</small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    @if (request()->query('print') == 1)
        <script>
            $(document).ready(function() {
                setTimeout(() => {
                    printDiv('printableArea');
                }, 500);
            });
        </script>
    @endif
    <script>
        function printDiv(divName) {
            var printWindow = window.open('', '');
            printWindow.document.write('<html><head>');
            // Include Bootstrap CSS in the print window
            printWindow.document.write('<title>Print</title>');
            // Include your custom styles
            printWindow.document.write('<style>');
            printWindow.document.write(`
                body {
                    font-family: "Courier New", monospace !important;

                    margin-right: 5px !important;
                    margin-left: 5px !important;
                }

                @page {
                    margin-right: 2px !important;
                    margin-left: 0px !important;
                    padding-right: 0px !important;
                    padding-left: 0px !important;
                }

                * {
                    color: black !important;
                    font-family: "Courier New", monospace !important;
                    font-weight: bolder !important;
                    text-transform: uppercase !important;
                    font-size: 10px !important; /* Adjust font size as needed */
                }

                .table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                    border-spacing: 0 !important;
                }

                .table-bordered {
                    border: 1px solid black !important;
                }

                .table th, .table td {
                    border: 1px solid black !important;
                    background-color: #ffffff !important; /* White background */
                    color: #000000 !important; /* Black text */
                    font-weight: bolder !important;
                }

                .table th, .table td {
                    border-left: 0px !important;
                }

                .companyName{
                    text-align: center !important;
                }

                .table th:last-child, .table td:last-child {
                    border-right: 0px !important;
                }

                .table tr:first-child td {
                    border-top: 0px !important;
                }

                .table .bottom-part {
                    text-align: right !important;
                }

                .table .footerbottom-part td, .table .footerbottom-part td small {
                    text-align: center !important;
                    font-size: 5px !important;
                }

                @media print {
                    .table .bottom-part {
                        text-align: right !important;
                    }
                }
            `);


            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(document.getElementById(divName).innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
                location.href = "{{ route('user.invoice.index') }}";
            };
        }
    </script>

@endpush
