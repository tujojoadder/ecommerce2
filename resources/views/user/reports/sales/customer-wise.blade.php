@php
    $queryString = $_SERVER['QUERY_STRING'];
    $startDate = $_GET['starting_date'] ?? '';
    $endDate = $_GET['ending_date'] ?? '';
@endphp
@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        @if ($queryString == 'customer-search' || $queryString == 'group-search')
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
                                    <input type="text" name="starting_date" id="starting_date" class="fc-datepicker form-control" value="{{ date($d . '/' . $m . '/Y') }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.starting_date') }}">
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
                                        <select name="group_id" id="group_id" class="form-control select2" required></select>
                                    </div>
                                    <button class="add-btn btn btn-success w-25">{{ __('messages.search') }}</button>
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
                    <div class="text-center">
                        @include('layouts.user.print-header')
                    </div>
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }} {{ request()->starting_date ? '| From (' . request()->starting_date . ') to (' : '' }}{{ request()->ending_date ? request()->ending_date . ')' : '' }}</p>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        </div>
                    </div>
                    <div class="card-body bg-white table-responsive">
                        <table id="file-export-datatable" class="table table-bordered table-striped table-hover text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.sl') }}</th>
                                    <th class="date-cell">{{ __('messages.issued_date') }}</th>
                                    <th>{{ __('messages.voucher_no') }}</th>
                                    <th class="product-cell">{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.unit') }}</th>
                                    <th>{{ __('messages.quantity') }}</th>
                                    <th>{{ __('messages.price') }}</th>
                                    <th>{{ __('messages.total') }}</th>
                                    <th>{{ __('messages.discount') }}</th>
                                    <th>{{ __('messages.transport_fare') }}</th>
                                    <th>{{ __('messages.return_quantity') }}</th>
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
            $('.select2').select2({
                placeholder: 'Select {{ $queryString == 'group-search' ? 'Group' : 'Customer' }}',
                searchInputPlaceholder: 'Search'
            });
            fetchClients();
            fetchClientsGroups();
        });
    </script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#file-export-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
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
                    // {
                    //     extend: 'print',
                    //     text: 'Print',
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     },
                    //     customize: function(win) {
                    //         var html = $('.header');
                    //         $(win.document.body).find('h1').css('display', 'none');
                    //         $(win.document.body).prepend(html);
                    //     }
                    // },
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = "{{ $_GET['client_id'] ?? '' }}";
                        d.group_id = "{{ $_GET['group_id'] ?? '' }}";
                        d.starting_date = "{{ $_GET['starting_date'] ?? '' }}";
                        d.ending_date = "{{ $_GET['ending_date'] ?? '' }}";
                        d.queryString = "{{ $queryString }}";
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
                        data: 'product_price',
                        name: 'product_price'
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
                        data: 'return_quantity',
                        name: 'return_quantity'
                    },
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
                        var grandTotal = 0;
                        var totalReceiveAmount = 0;
                        var totalProfit = 0;

                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            totalBillAmount += parseFloat(rowData.total) || 0;
                            totalDiscountAmount += parseFloat(rowData.discount) || 0;
                            totalTransportFareAmount += parseFloat(rowData.transport_fare) || 0;
                            grandTotal += parseFloat(rowData.grand_total) || 0;
                            totalReceiveAmount += parseFloat(rowData.receive_amount) || 0;
                            totalProfit += parseFloat(rowData.profit) || 0;
                        });
                        totalDueAmount = grandTotal - totalReceiveAmount;

                        $('#file-export-datatable tfoot td:eq(1)').text(totalBillAmount);
                        $('#file-export-datatable tfoot td:eq(2)').text(totalDiscountAmount);
                        $('#file-export-datatable tfoot td:eq(3)').text(totalTransportFareAmount);
                        $('#file-export-datatable tfoot td:eq(5)').text(grandTotal);
                        $('#file-export-datatable tfoot td:eq(6)').text(totalReceiveAmount);
                        $('#file-export-datatable tfoot td:eq(7)').text(totalDueAmount);
                        $('#file-export-datatable tfoot td:eq(8)').text(totalProfit.toFixed(2));
                    }
                    $('#file-export-datatable').append('<tfoot class="text-center font-weight-bold"><tr><td colspan="7">Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tfoot>');

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
