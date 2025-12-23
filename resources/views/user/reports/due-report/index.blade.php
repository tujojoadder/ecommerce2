@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@push('css')
    <style>
        @media print {

            label,
            .dataTables_info,
            .pagination {
                display: none;
            }
        }

        tbody p {
            margin: 0;
        }
    </style>
@endpush
@section('content')
    @php
        $client_id = $_GET['client_id'] ?? 0;
    @endphp
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <p class="card-title my-0"><i class="fas fa-list"></i> {{ $pageTitle }}</p>
            <div class="d-flex">
                <a href="{{ route('user.report.due-report.index') }}" class="btn btn-secondary text-white me-2">
                    <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                </a>
                <a href="{{ route('user.report.due-report.customer.wise') }}" class="btn btn-secondary text-white me-2">
                    <i class="fas fa-list d-inline"></i> {{ __('messages.customer') }} {{ __('messages.wise') }}
                </a>
                <a href="{{ route('user.report.due-report.group.wise') }}" class="btn btn-secondary text-white me-2">
                    <i class="fas fa-list d-inline"></i> {{ __('messages.group') }} {{ __('messages.wise') }}
                </a>
                <a href="{{ url()->previous() }}" class="btn btn-secondary text-white me-2">
                    <i class="fas fa-arrow-left d-inline"></i> {{ __('messages.go_back') }}
                </a>
                <a href="javascript:;" class="btn btn-secondary " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v d-inline"></i></a>
                <ul class="dropdown-menu shadow-lg">
                    <li><a class="dropdown-item" href="{{ route('user.client.index') }}"><i class="fas fa-list me-2 d-inline"></i> Client List</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.client-group.index') }}"><i class="fas fa-layer-group me-2 d-inline"></i> Client Group</a></li>
                    <li><a class="dropdown-item" href="javascript:;" onclick="comingSoon();"><i class="fab fa-youtube me-2 d-inline"></i> Tutorial</a></li>
                </ul>
            </div>
        </div>

        <div class="header text-center">
            @include('layouts.user.print-header')
            @if (request()->has('search'))
                <h5>Form : {{ date('d M Y', strtotime(request()->form_date)) }} To : {{ date('d M Y', strtotime(request()->to_date)) }}</h5>
            @endif
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        @if (Request::is('user/report/due-report/customerwise/report'))
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="client_id">{{ __('messages.search_by_client') }}</label>
                                <select name="client_id" id="client_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                        @endif
                        @if (Request::is('user/report/due-report/groupwise/report'))
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="client_id">{{ __('messages.search_by_client') }} {{ __('messages.group') }}</label>
                                <select name="client_group_id" id="client_group_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                        @endif
                        {{-- <div id="dateSearch" class="col-md-3">
                            <label for="">{{ __('messages.search_by_date') }}</label>
                            <div class="input-group">
                                <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                            </div>
                        </div> --}}
                        @if (Request::is('user/report/due-report/customerwise/report') || Request::is('user/report/due-report/groupwise/report'))
                            <div class="col-md-3 mb-lg-2 mb-5">
                                <label for="button">&nbsp;</label>
                                <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 my-2 table-responsive" id="printableArea">
                    <table class="table table-sm table-bordered yajra-datatable">
                        <thead>
                            <th class="text-center" style="width: 50px;">SL</th>
                            <th class="text-left"> {{ __('messages.client') }} {{ __('messages.info') }}</th>
                            <th class="text-center"> {{ __('messages.previous_due') }}</th>
                            <th class="text-center"> {{ __('messages.sales') }}</th>
                            <th class="text-center">{{ __('messages.total_bill') }}</th>
                            <th class="text-center">{{ __('messages.sales') }} {{ __('messages.return') }}</th>
                            <th class="text-center">{{ __('messages.collection') }}</th>
                            <th class="text-center">{{ __('messages.return') }}</th>
                            <th>{{ __('messages.due') }}</th>
                            {{-- <th>{{ __('messages.balance') }}</th> --}}
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $("#clearFilter").on('click', function() {
            $("#client_id").val('');
            $("#client_group_id").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');

            fetchClients();
            fetchClientGroups();
            $('.yajra-datatable').DataTable().ajax.reload();
        });

        $(document).ready(function() {
            fetchClients();
            fetchClientGroups();
        });
    </script>

    <script>
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#client_id, #client_group_id, #starting_date, #ending_date").on("change", function() {
                dataTable.ajax.reload();
            });

            dataTable = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                dom: 'lBfrtip',
                buttons: [
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $("#client_id").val();
                        d.client_group = $("#client_group_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error, e.g., display a message or take appropriate action
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'client',
                        name: 'client',
                        className: 'text-left',
                        orderable: true
                    },
                    {
                        data: 'previous_due',
                        name: 'previous_due',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'sales_amount',
                        name: 'sales_amount',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'total_bill',
                        name: 'total_bill',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'sales_return',
                        name: 'sales_return',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'collection',
                        name: 'collection',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'return',
                        name: 'return',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'due',
                        name: 'due',
                        className: 'text-center',
                        orderable: false
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var totalPreviousDue = 0;
                        var totalSalesAmountValue = 0;
                        var totalBillAmount = 0;
                        var totalCollectionAmount = 0;
                        var totalSalesReturnAmount = 0;
                        var totalReturnAmount = 0;
                        var totalDueAmount = 0;

                        // Loop through the rows in the current page
                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            var previousDueValue = parseFloat(rowData.previous_due);
                            var sales_amountValue = parseFloat(rowData.sales_amount);
                            var totalBillValue = parseFloat(rowData.total_bill);
                            var totalCollectionValue = parseFloat(rowData.collection);
                            var totalSalesReturnValue = parseFloat(rowData.sales_return);
                            var totalReturnValue = parseFloat(rowData.return);
                            var totalDueValue = parseFloat(rowData.due);
                            var totalAdvanceValue = parseFloat(rowData.advance);
                            if (!isNaN(previousDueValue)) {
                                totalPreviousDue += previousDueValue;
                            }
                            if (!isNaN(sales_amountValue)) {
                                totalSalesAmountValue += sales_amountValue;
                            }
                            if (!isNaN(totalBillValue)) {
                                totalBillAmount += totalBillValue;
                            }
                            if (!isNaN(totalBillValue)) {
                                totalCollectionAmount += totalCollectionValue;
                            }
                            if (!isNaN(totalReturnValue)) {
                                totalReturnAmount += totalReturnValue;
                            }
                            if (!isNaN(totalSalesReturnValue)) {
                                totalSalesReturnAmount += totalSalesReturnValue;
                            }
                            if (!isNaN(totalDueValue)) {
                                totalDueAmount += totalDueValue;
                            }
                        });

                        // Update the footer totals
                        $('.yajra-datatable tfoot td:eq(1)').text(totalPreviousDue.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(2)').text(totalSalesAmountValue.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(3)').text(totalBillAmount.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(4)').text(totalSalesReturnAmount.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(5)').text(totalCollectionAmount.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(6)').text(totalReturnAmount.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(7)').text(totalDueAmount.toFixed(2));
                    }

                    // Add the footer row initially
                    $('.yajra-datatable').append('<tfoot class="text-center font-weight-bold"><tr><td colspan="2">Total</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tfoot>');

                    // Calculate and update footer totals initially
                    updateFooterTotals();

                    // Bind the updateFooterTotals function to the draw.dt event
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
