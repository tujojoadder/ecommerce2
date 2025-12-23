@extends('layouts.user.app')
@section('content')
    @include('layouts.table-css')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-lg-flex d-block justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div>
                        <a href="{{ route('user.report.expense.all') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                        </a>
                        <a href="{{ route('user.report.expense.category.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.category') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ route('user.report.expense.subcategory.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.subcategory') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.supplier.create') }}" class="btn btn-success"><i class="fas fa-plus d-inline"></i> {{ __('messages.add_new') }}</a>
                    </div>
                </div>
                @include('layouts.user.print-header')
                @include('user.reports.expense.search-form')
                <div class="card-body bg-white table-responsive">
                    <table id="file-export-datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.id_no') }}</th>
                                <th class="date-cell">{{ __('messages.date') }}</th>
                                <th>{{ __('messages.voucher_no') }}</th>
                                <th>{{ __('messages.category') }}</th>
                                <th>{{ __('messages.account') }}</th>
                                <th>{{ __('messages.cheque_no') }}</th>
                                <th>{{ __('messages.description') }}</th>
                                <th>{{ __('messages.type') }}</th>
                                <th>{{ __('messages.amount') }}</th>
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
        $(document).ready(function() {
            fetchClients();
            fetchSuppliers();
            fetchExpenseCategories();
        });

        $("#clearFilter").on('click', function() {
            $("#expense_category_id").val('');
            $("#client_id").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');

            fetchClients();
            fetchSuppliers();
            fetchExpenseCategories();
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

            $("#client_id, #expense_category_id, #supplier_id, #starting_date, #ending_date").on("change input", function() {
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
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $("#client_id").val();
                        d.supplier_id = $("#supplier_id").val();
                        d.category_id = $("#expense_category_id").val();
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
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'account_id',
                        name: 'account_id'
                    },
                    {
                        data: 'cheque_no',
                        name: 'cheque_no'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
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
                            });
                        }

                        var balanceTotal = amountTotal;

                        // Remove existing footer (if any)
                        $('#file-export-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="7">Total</td><td></td><td>' + balanceTotal + '</td></tr></tfoot>';
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
