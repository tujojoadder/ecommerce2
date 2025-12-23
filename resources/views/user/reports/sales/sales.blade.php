@php
    $queryString = $_SERVER['QUERY_STRING'];
    $startDate = $_GET['starting_date'] ?? '';
    $endDate = $_GET['ending_date'] ?? '';
@endphp
@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        @if ($queryString == 'customer-search' || $queryString == 'group-search' || $queryString == 'product-group-search')
            <div class="container-fluid">
                <div class="card-header d-lg-flex d-block justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }} {{ request()->starting_date ? '| From ' . request()->starting_date . ' to' : '' }} {{ request()->ending_date ? request()->ending_date : '' }}</p>
                    <div>
                        <a href="{{ route('user.report.sales.sales') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                        </a>
                        <a href="{{ route('user.report.sales.sales') }}?daily-search" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.daily') }}
                        </a>
                        <a href="{{ route('user.report.sales.sales.customer.wise') }}?customer-search" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.customer') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ route('user.report.sales.sales') }}?group-search" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.client') }} {{ __('messages.group') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ route('user.report.sales.product.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ route('user.report.sales.sales') }}?product-group-search" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.group') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                    </div>
                </div>
                <form action="" method="GET">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    @php
                                        $m = date('m') - 1 == 0 ? '0' . 1 : date('m') - 1;
                                        $d = '01';
                                    @endphp
                                    <input type="text" name="starting_date" id="starting_date" class="fc-datepicker form-control" value="{{ date('d/m/Y') }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.starting_date') }}">
                                    <input type="text" name="ending_date" id="ending_date" class="fc-datepicker form-control" value="{{ date('d/m/Y') }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.ending_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($queryString == 'customer-search')
                                <input type="hidden" name="customer-search">
                                <div class="form-group d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                                        <select name="client_id" id="client_id" class="form-control select2" required></select>
                                    </div>
                                    <button class="btn btn-success w-25">{{ __('messages.search') }}</button>
                                </div>
                            @endif
                            @if ($queryString == 'group-search')
                                <input type="hidden" name="group-search">
                                <div class="form-group d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Group">
                                        <select name="client_group_id" id="client_group_id" class="form-control select2" required></select>
                                    </div>
                                    <button class="btn btn-success w-25">{{ __('messages.search') }}</button>
                                </div>
                            @endif
                            @if ($queryString == 'product-group-search')
                                <input type="hidden" name="product_group_search">
                                <div class="form-group d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Product Group">
                                        <select name="product_group_id" id="product_group_id" class="form-control select2" required></select>
                                    </div>
                                    <button class="btn btn-success w-25">{{ __('messages.search') }}</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="row row-sm">
                <div class="card">
                    <div class="card-header border-bottom d-lg-flex d-block justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }} {{ request()->starting_date ? '| From ' . request()->starting_date . ' to' : '' }} {{ request()->ending_date ? request()->ending_date : '' }}</p>
                        <div>
                            <a href="{{ route('user.report.sales.sales') }}" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales') }}?daily-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.daily') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales.customer.wise') }}?customer-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.customer') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales') }}?group-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.client') }} {{ __('messages.group') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ route('user.report.sales.product.wise') }}" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales') }}?product-group-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.group') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        </div>
                    </div>
                    <div class="header text-center">
                        @include('layouts.user.print-header')
                        @if (request()->has('search'))
                            <h5>Form : {{ date('d M Y', strtotime(request()->starting_date)) }} To : {{ date('d M Y', strtotime(request()->ending_date)) }}</h5>
                        @endif
                    </div>
                    <div class="card-body bg-white table-responsive">
                        @if (!request()->group_id)
                            @include('user.reports.sales.search-form')
                        @endif
                        <table id="yajra-datatable" class="table table-bordered table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.sl') }}</th>
                                    <th class="date-cell">{{ __('messages.issued_date') }}</th>
                                    <th>{{ __('messages.voucher_no') }}</th>
                                    <th>{{ __('messages.client') }}</th>
                                    <th class="product-cell">{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.unit') }}</th>
                                    <th>{{ __('messages.qty') }}</th>
                                    <th>{{ __('messages.single_price') }}</th>
                                    <th>{{ __('messages.total') }}</th>
                                    <th>{{ __('messages.dis') }}</th>
                                    <th>{{ __('messages.tfare') }}</th>
                                    <th>{{ __('messages.vat') }}</th>
                                    {{-- <th>{{ __('messages.return') }} {{ __('messages.qty') }}</th> --}}
                                    <th>{{ __('messages.grand_total') }}</th>
                                    <th>{{ __('messages.receive') }}</th>
                                    <th>{{ __('messages.due') }}</th>
                                    <th>{{ __('messages.profit') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('user.client.client-add-modal')
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClientGroups();
            fetchProductGroups();
            fetchClients();
            fetchStaffs();
            fetchInvoices();
            $("#clearFilter").on('click', function() {
                $("#client_group_id").val('');
                $("#client_id").val('');
                $("#invoice_id").val('');
                $("#starting_date").val('');
                $("#ending_date").val('');
                $(".product_name").val('');

                fetchClientGroups();
                fetchProductGroups();
                fetchClients();
                fetchStaffs();
                fetchInvoices();
                dataTable.ajax.reload();
            });

            $("#client_id, .client_id, #invoice_id, #starting_date, #ending_date, .product_name, #client_group_id").on("change input", function() {
                dataTable.ajax.reload();
            });

            var dataTable = $('#yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = "{{ $_GET['client_id'] ?? '' }}";
                        d.group_id = "{{ $_GET['group_id'] ?? '' }}";
                        d.client_group_id = "{{ $_GET['client_group_id'] ?? '' }}";
                        d.product_group_id = "{{ $_GET['product_group_id'] ?? '' }}";
                        d.d_starting_date = "{{ $_GET['starting_date'] ?? '' }}";
                        d.d_ending_date = "{{ $_GET['ending_date'] ?? '' }}";
                        d.queryString = "{{ $queryString }}";

                        d.select_client_id = $("#client_id").val();
                        d.invoice_id = $("#invoice_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
                        d.product_name = $(".product_name").val();
                        d.invoice_no = $(".invoice_no").val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },
                columns: [{
                        data: 'dt_id',
                        name: 'dt_id'
                    },
                    {
                        data: 'issued_date',
                        name: 'issued_date'
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    {
                        data: 'client_id',
                        name: 'client_id'
                    },
                    {
                        data: 'products',
                        name: 'products'
                    },
                    {
                        data: 'unit_id',
                        name: 'unit_id'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'product_sale_price',
                        name: 'product_sale_price'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'transport_fare',
                        name: 'transport_fare'
                    },
                    {
                        data: 'vat',
                        name: 'vat'
                    },
                    // {
                    //     data: 'return_quantity',
                    //     name: 'return_quantity'
                    // },
                    {
                        data: 'grand_total',
                        name: 'grand_total'
                    },
                    {
                        data: 'receive_amount',
                        name: 'receive_amount'
                    },
                    {
                        data: 'due_amount',
                        name: 'due_amount'
                    },
                    {
                        data: 'profit',
                        name: 'profit'
                    },
                ],
                initComplete: function(settings, json) {
                    function updateFooterTotals() {
                        var totalBillAmount = 0;
                        var totalDiscountAmount = 0;
                        var totalTransportFareAmount = 0;
                        var totalVat = 0;
                        var grandTotal = 0;
                        var totalReceiveAmount = 0;
                        var totalProfit = 0;

                        dataTable.rows().data().each(function(rowData) {
                            totalBillAmount += parseFloat(rowData.total);
                            totalDiscountAmount += parseFloat(rowData.discount);
                            totalTransportFareAmount += parseFloat(rowData.transport_fare);
                            totalVat += parseFloat(rowData.vat);
                            grandTotal += parseFloat(rowData.grand_total);
                            totalReceiveAmount += parseFloat(rowData.receive_amount);
                            totalProfit += parseFloat(rowData.profit);
                        });
                        totalDueAmount = grandTotal - totalReceiveAmount;

                        $('#yajra-datatable .line-total td:eq(1)').text(totalBillAmount.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(2)').text(totalDiscountAmount.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(3)').text(totalTransportFareAmount.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(4)').text(totalVat.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(5)').text(grandTotal.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(6)').text(totalReceiveAmount.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(7)').text(totalDueAmount.toFixed(2));
                        $('#yajra-datatable .line-total td:eq(8)').text(totalProfit.toFixed(2));
                    }
                    // $('#yajra-datatable').append('<tfoot class="text-center font-weight-bold"><tr><td colspan="8">Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tfoot>');
                    $('#yajra-datatable').append('<tfoot class="text-center font-weight-bold line-total"><tr><td colspan="8">Page Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tfoot>');

                    updateFooterTotals();

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
