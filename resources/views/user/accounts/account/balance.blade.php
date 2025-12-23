@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.account.create') }}" class="btn btn-success">{{ __('messages.add_new') }}</a>
                    </div>
                </div>
                <div class="card-body bg-white table-responsive">
                    <table id="file-export-datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>{{ __('messages.id_no') }}</th>
                                <th>{{ __('messages.title') }}</th>
                                <th>{{ __('messages.account') }}</th>
                                <th>{{ __('messages.balance') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#file-export-datatable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: "{{ siteSettings()->page_length }}",
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
                dom: 'lBfrtip',
                buttons: [
                    'excel',
                    'csv',
                    'pdf',
                    {
                        extend: 'print',
                        text: 'Print',
                        customize: function(win) {
                            $(win.document.body).css('font-size', '10pt');

                            $(win.document.body)
                                .find('tfoot')
                                .addClass('tfoot-print');
                        },
                    },
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
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'initial_balance',
                        name: 'initial_balance'
                    },
                ],
                initComplete: function(settings, json) {
                    var dataTable = this.api();

                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var totalBalance = 0;

                        // Loop through the rows in the current page
                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            // Remove commas and parse the number
                            var initialBalance = parseFloat(rowData.initial_balance.replace(/,/g, ''));

                            if (!isNaN(initialBalance)) {
                                totalBalance += initialBalance;
                            }
                        });
                        // Format the total with commas
                        var formattedTotal = totalBalance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        // Update the footer totals
                        $('#file-export-datatable tfoot th:eq(2)').text(formattedTotal);
                    }

                    // Add the footer row initially
                    if (!$('#file-export-datatable tfoot').length) {
                        $('#file-export-datatable').append('<tfoot class="tfoot-print"><tr><th colspan="2">Total</th><th></th><th></th></tr></tfoot>');
                    }


                    // Calculate and update footer totals initially
                    updateFooterTotals();
                    // Bind the updateFooterTotals function to the draw.dt event
                    dataTable.on('draw', updateFooterTotals);
                }

            });
        });
    </script>
@endpush
