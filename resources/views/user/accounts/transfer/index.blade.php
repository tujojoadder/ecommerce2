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
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="javascript:;" onclick="printElement('DataTables_Table_0');" class="btn btn-info mr-1">
                        <i class="fas fa-print" style="font-size: 15px"></i> Print
                    </a>
                    <a href="{{ route('user.transfer.create') }}" class="btn btn-success mr-1"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('user.transfer.index') }}" class="btn btn-dark me-2">{{ __('messages.go_back') }}</a>
                    <div class="d-flex">
                        <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/qEvvnplupHA?si=VjTrkln3SkGBONkM">
                            <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.user.print-header')
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <div class="col-md-3 mb-1" id="accounts">
                            <label for="account_id">{{ __('messages.search_by') }} {{ __('messages.account') }}</label>
                            <select name="account_id" id="account_id" class="select2 form-control" style="width: 100% !important;">
                            </select>
                        </div>
                        <div class="col-md-3 mb-1" id="accounts">
                            <label for="type">{{ __('messages.search_by') }} {{ __('messages.type') }}</label>
                            <select name="type" id="type" class="select2 form-control" style="width: 100% !important;">
                                <option></option>
                                <option value="deposit">{{ __('messages.deposit') }}</option>
                                <option value="cost">{{ __('messages.cost') }}</option>
                            </select>
                        </div>
                        <div id="dateSearch" class="col-md-3">
                            <label for="">{{ __('messages.search_by') }} {{ __('messages.date') }}</label>
                            <div class="input-group">
                                <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                            </div>
                        </div>
                        <div class="col-md-2 mb-lg-2 mb-5">
                            <label for="button">&nbsp;</label>
                            <button class="btn btn-block btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 my-2 table-responsive" id="printableArea">
                    <table class="table table-sm table-bordered yajra-datatable">
                        <thead class="text-center">
                            <th>{{ __('messages.sl') }}</th>
                            <th class="date-cell">{{ __('messages.date') }}</th>
                            <th>{{ __('messages.sender_or_receiver') }}</th>
                            <th>{{ __('messages.type') }}</th>
                            <th>{{ __('messages.account') }}</th>
                            <th>{{ __('messages.description') }}</th>
                            <th>{{ __('messages.credit') }}</th>
                            <th>{{ __('messages.debit') }}</th>
                            <th>{{ __('messages.balance') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </thead>
                        <tbody class="text-center">
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
        function printElement(elementId) {
            var printContent = document.getElementById(elementId).outerHTML;
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'); // Include Bootstrap CSS
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            setTimeout(function() {
                printWindow.close();
            }, 100); // Close after 1 second (adjust the delay as needed)
        }

        $("#clearFilter").on('click', function() {
            $("#account_id").val('');
            $("#type").val('').trigger('change');
            $("#starting_date").val('');
            $("#ending_date").val('');

            $('.yajra-datatable').DataTable().ajax.reload();
            fetchAccounts();
        });

        $(document).ready(function() {
            fetchAccounts();
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

            $("#client_id, #type, #account_id, #starting_date, #ending_date").on("change", function() {
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
                        d.account_id = $("#account_id").val();
                        d.type = $("#type").val();
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
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: false,
                    },
                    {
                        data: 'sender_or_receiver',
                        name: 'sender_or_receiver',
                        orderable: false,
                    },
                    {
                        data: 'type',
                        name: 'type',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'account_id',
                        name: 'account_id',
                        orderable: false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                    },
                    {
                        data: 'credit',
                        name: 'credit',
                        orderable: false,
                    },
                    {
                        data: 'debit',
                        name: 'debit',
                        orderable: false,
                    },
                    {
                        data: 'balance',
                        name: 'balance',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var debitTotal = 0;
                        var creditTotal = 0;

                        // Check if data is present before processing
                        if (json.data && json.data.length > 0) {
                            // Loop through the rows in the current page
                            $('.yajra-datatable tbody tr').each(function() {
                                var row = dataTable.row($(this)).data(); // Get the data for the row

                                // Check if row data exists before accessing properties
                                if (row && typeof row.debit !== 'undefined' && typeof row.credit !== 'undefined') {
                                    var debitValue = parseFloat(row.debit);
                                    var creditValue = parseFloat(row.credit);

                                    if (!isNaN(debitValue)) {
                                        debitTotal += debitValue;
                                    }
                                    if (!isNaN(creditValue)) {
                                        creditTotal += creditValue;
                                    }
                                }
                            });
                        }

                        var balanceTotal = creditTotal - debitTotal;

                        // Remove existing footer (if any)
                        $('.yajra-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="6">Total</td><td>' + creditTotal + '</td><td>' + debitTotal + '</td><td>' + balanceTotal + '</td><td></td></tr></tfoot>';
                        $('.yajra-datatable').append(tfootContent);
                    }

                    // Calculate and add tde footer totals initially
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

        function destroy(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var data_id = id;
                    var url = '{{ route('user.transfer.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('.yajra-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Transfer deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }
    </script>
@endpush
