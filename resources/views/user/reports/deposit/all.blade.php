@extends('layouts.user.app')
@section('content')
    @include('layouts.table-css')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-lg-flex d-block justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div>
                        <a href="{{ route('user.report.deposit.all') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                        </a>
                        <a href="{{ route('user.report.deposit.category.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.category') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ route('user.report.deposit.customer.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.customer') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.supplier.create') }}" class="btn btn-success"><i class="fas fa-plus d-inline"></i> {{ __('messages.add_new') }}</a>
                    </div>
                </div>
                @include('layouts.user.print-header')
                <div class="row mx-2 mb-3 mt-4 justify-content-center">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="client_id">{{ __('messages.search_by_client') }}</label>
                                <select id="client_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="category_id">{{ __('messages.search_by') }} {{ __('messages.category') }}</label>
                                <select id="category_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <div id="dateSearch" class="col-md-3">
                                <label for="">{{ __('messages.search_by_date') }}</label>
                                <div class="input-group">
                                    <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                    <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div class="col-md-3 mb-lg-2 mb-5">
                                <label for="button">&nbsp;</label>
                                <button class="btn btn-block btn-lg btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-white table-responsive">
                    <table id="file-export-datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.sl') }}</th>
                                <th class="date-cell">{{ __('messages.date') }}</th>
                                <th>{{ __('messages.id_no') }}</th>
                                <th>{{ __('messages.client') }}</th>
                                <th>{{ __('messages.invoice') . ' ' . __('messages.id_no') }}</th>
                                <th>{{ __('messages.description') }}</th>
                                {{-- <th>{{ __('messages.category') }}</th> --}}
                                <th>{{ __('messages.initial_balance') }}</th>
                                <th>{{ __('messages.amount') }}</th>
                                <th>{{ __('messages.transaction_type') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>

    <script>
        fetchClients();
        fetchReceiveCategories();

        $("#clearFilter").on('click', function() {
            $("#category_id").val('');
            $("#client_id").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');

            fetchClients();
            fetchReceiveCategories();
            $('#file-export-datatable').DataTable().ajax.reload();
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

            $("#client_id, #category_id, #starting_date, #ending_date").on("change", function() {
                dataTable.ajax.reload();
            });

            dataTable = $('#file-export-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                dom: 'lBfrtip',
                buttons: [
                    // {
                    //     extend: 'excel',
                    //     text: 'Excel',
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     }
                    // },
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
                        d.client_id = $("#client_id").val();
                        d.category_id = $("#category_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
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
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'client_id',
                        name: 'client_id'
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    // {
                    //     data: 'category_id',
                    //     name: 'category_id'
                    // },
                    {
                        data: 'initial_balance',
                        name: 'initial_balance'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var initialTotal = 0;
                        var amountTotal = 0;

                        // Check if data is present before processing
                        if (json.data && json.data.length > 0) {
                            // Loop through the rows in the current page
                            $('#file-export-datatable tbody tr').each(function() {
                                var row = dataTable.row($(this)).data(); // Get the data for the row

                                // Check if row data exists before accessing properties
                                if (typeof row.amount !== 'undefined') {
                                    var creditValue = parseFloat(row.amount);

                                    if (!isNaN(creditValue)) {
                                        amountTotal += creditValue;
                                    }
                                }

                                // Check if row data exists before accessing properties
                                if (typeof row.initial_balance !== 'undefined') {
                                    var initialValue = parseFloat(row.initial_balance);

                                    if (!isNaN(initialValue)) {
                                        initialTotal += initialValue;
                                    }
                                }
                            });
                        }

                        var balanceTotal = amountTotal;

                        // Remove existing footer (if any)
                        $('#file-export-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="6">Total</td><td>' + initialTotal + '</td><td>' + balanceTotal + '</td><td>{{ __('messages.total') }}: ' + (balanceTotal + initialTotal) + '</td></tr></tfoot>';
                        $('#file-export-datatable').append(tfootContent);
                    }

                    // Calculate and add the footer totals initially
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
