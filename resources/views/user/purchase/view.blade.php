@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <link rel="stylesheet" href="{{ asset('dashboard/css/invoice.css') }}">
    <div class="card p-2">
        <div class="card-body">
            <div class="d-flex">
                <a href="javascript:;" onclick="printDiv('printableArea')" class="btn btn-info rounded-0 me-1">
                    <i class="fas fa-print"></i> {{ __('messages.print') }}
                </a>
                <a href="{{ route('user.purchase.create') }}" class="btn btn-success rounded-0 me-1"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
            </div>
        </div>
        <div class="card rounded-0 summery_copy">
            <div class="card-body rounded-0 p-2" id="printableArea" style="background-color: #e7e5f559;">
                <div class="section1">
                    <div class="row px-0 py-3" style="padding-bottom: 2px !important;">
                        <div class="col-4">
                            <h3 style="font-weight:bolder;font-size:20px;">{{ config('company.name') }}</h3>
                            <h5 style="font-weight:bolder;font-size:14px;">{{ __('messages.address') }} : {{ config('company.address') }}</h5>
                            <h5 style="font-weight:bolder;font-size:14px;line-height:20px">{{ __('messages.phone') }} : {{ config('company.phone') }}, {{ __('messages.email') }} : {{ config('company.email') }}</h5>
                        </div>
                        <div class="col-4 text-center">
                            <h2 style="background-color: #94d4db; padding: 10px 13px; border-radius: 5px; box-shadow: 1px 1px 2px 2px rgb(77, 74, 74); width: 185px; text-align: center; margin: auto; font-size: 20px; letter-spacing: 0.54px; font-family: revert; font-weight: 800;">
                                {{ __('messages.purchase') }} {{ __('messages.copy') }}
                            </h2>
                        </div>
                        <div class="col-4 justify-content-center">
                            <div class="w-100">
                                <table class="table text-center w-50" style="border:2px solid #9bdce3; float: right;">
                                    <tr style="background-color:#94d4db">
                                        <td style="background-color:#9bdce3 !important"><strong>{{ __('messages.purchase') }} {{ __('messages.id_no') }}</strong></td>
                                        <td style="font-weight:600; background-color: white; color: black;">{{ $purchase->invoice_id }}</td>
                                    </tr>
                                    <tr style="background-color:#94d4db">
                                    </tr>
                                    <tr style="background-color:#94d4db">
                                        <td style="background-color:#9bdce3 !important"><strong>{{ __('messages.issued_date') }}</strong></td>
                                        <td style="font-weight:600; background-color: white; color: black;">{{ bnDateFormat($purchase->issued_date) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="section2">
                        <div class="row">
                            <div class="col-12" style="">
                                <table class="table table-bordered text-center order-item-table">
                                    <thead class="order-table-header">
                                        <tr>
                                            <th><strong>{{ __('messages.customer') }} {{ __('messages.details') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: left; padding: 4px 8px;">
                                                <strong>{{ __('messages.name') }} : </strong> {{ $purchase->supplier->supplier_name ?? 'N/A' }} <br>
                                                <strong>{{ __('messages.mobile') }} : </strong> {{ $purchase->supplier->phone ?? 'N/A' }} <br>
                                                <strong>{{ __('messages.address') }} : </strong> {{ ($purchase->supplier->address ?? '') . ', ' . ($purchase->supplier->upazilla_thana ?? '') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="section3">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-center order-item-table">
                                    <thead class="order-table-header">
                                        <tr>
                                            <th colspan="5" style="font-size: 14px !important;"><strong>{{ __('messages.orders') }}</strong></th>
                                            {{-- <th colspan="2" style="font-size: 14px !important;"><strong>{{ __('messages.return') }}</strong></th> --}}
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th><strong>{{ __('messages.sl') }}</strong></th>
                                            <th style="text-align: left;"><strong>{{ __('messages.product') }} {{ __('messages.details') }}</strong></th>
                                            <th><strong>{{ __('messages.pice') }} <br>{{ __('messages.rate') }}</strong></th>
                                            <th><strong>{{ __('messages.total') }}<br>{{ __('messages.qty') }}</strong></th>
                                            <th><strong>{{ __('messages.amount') }}</strong></th>

                                            {{-- <th><strong>{{ __('messages.return') }}<br>{{ __('messages.qty') }}</strong></th>
                                            <th><strong>{{ __('messages.return') }}<br>{{ __('messages.amount') }}</strong></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($purchase->purchaseItems as $key => $item)
                                            <tr style="">
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align: left;">{{ $item->product->name ?? 'N/A' }}</td>
                                                <td>{{ $item->buying_price ?? '0.00' }}</td>
                                                <td>{{ $item->quantity ?? '0' }}</td>
                                                <td>
                                                    {{ number_format($item->buying_price * $item->quantity ?? '0', 2) }}
                                                </td>
                                                {{-- <td>{{ $item->return_quantity ?? '0' }}</td>
                                                <td>
                                                    {{ number_format($item->selling_price * $item->return_quantity, 2) }}
                                                </td> --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10">No More..</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="text-align: right;"><strong>{{ __('messages.total') }}</strong></th>
                                            <th><strong>{{ number_format($purchase->purchaseItems->sum('buying_price'), 2) }}</strong></th>
                                            <th><strong>{{ $purchase->purchaseItems->sum('quantity') }}</strong></th>
                                            <th><strong>{{ number_format($purchase->billAmount($purchase->id), 2) }}</strong></th>
                                            {{-- <th><strong>{{ $purchase->purchaseItems->sum('return_quantity') }}</strong></th> --}}
                                            {{-- <th><strong>{{ number_format($purchase->returnAmount($purchase->id), 2) }}</strong></th> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="section4">
                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>{{ __('messages.total') }}</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($purchase->billAmount($purchase->id), 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('messages.vat') }} ( + )</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($purchase->vat, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('messages.discount') }} ( - )</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($purchase->discount, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('messages.transport_fare') }} ( + )</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($purchase->transport_fare, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('messages.labour_cost') }} ( + )</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($purchase->labour_cost, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('messages.purchase') }} {{ __('messages.bill') }}</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($purchase->purchase_bill, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('messages.supplier') }} {{ __('messages.due') }} ( - )</td>
                                        <td style="width: 40%;text-align:right;">{{ $supplierDue }}</td>
                                    </tr>

                                    <tr id="td_color" style="background-color: #94d4db !important;">
                                        <td>{{ __('messages.total') }} {{ __('messages.bill') }}</td>
                                        <td style="width: 40%;text-align:right;">{{ $totalBill }}</td>
                                    </tr>

                                    <tr id="td_color" style="background-color: #94d4db !important;">
                                        <td>{{ __('messages.payment') }} ( - )</td>
                                        <td style="width: 40%;text-align:right;">{{ number_format($payment, 2) }}</td>
                                    </tr>

                                    <tr id="td_color" style="background-color: #94d4db !important;">
                                        <td>{{ __('messages.total') }} {{ __('messages.due') }}</td>
                                        <td style="width: 40%;text-align:right;">{{ $totalDue }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between my-5">
                            <div class="font-weight-bolder p-2" style="width:30%; border: 1px dashed black">{{ __('messages.seller') }} {{ __('messages.signature') }} : </div>
                            <div class="font-weight-bolder p-2" style="width:30%; border: 1px dashed black">{{ __('messages.buyer') }} {{ __('messages.signature') }} : </div>
                        </div>
                    </div>
                    <div class="text-center site-link" style="">
                        <span class="d-block"><i>Powered by :</i> Soft Host It . E-mail: softhostit@gmail.com, www.softhostit.com, Hotline : +8809639 201 301, +8801996 702 370-77</span>
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
