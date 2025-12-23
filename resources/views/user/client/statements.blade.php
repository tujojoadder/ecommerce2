@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@push('css')
    <style>
        @media print {

            label,
            .dataTables_info,
            .pagination {
                display: none;
            }

            .datatable tbody tr td td {
                border: 1px solid black !important;
            }

        }

        tbody p {
            margin: 0;
        }

        .datatable tbody tr td td {
            border: 1px solid black !important;
        }
    </style>
@endpush
@section('content')
    @php
        $client_id = $_GET['client_id'] ?? 0;
    @endphp
    <div class="card">
        <div class="card-body">
            @include('layouts.user.print-header')
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-1" id="clients">
                            <div class="input-group">
                                <label for="client_id">{{ __('messages.search_by') }} {{ __('messages.client') }}</label>
                                <select name="client_id" id="client_id" class="select2 form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <span class="text-danger small" id="client_id_Error"></span>
                        </div>
                        <div id="dateSearch" class="col-md-4">
                            <label for="">{{ __('messages.search_by_date') }}</label>
                            <div class="input-group">
                                <input type="text" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                <input type="text" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                            </div>
                        </div>
                        <div class="col-md-2 mb-lg-2 mb-5">
                            <label for="button">&nbsp;</label>
                            <button class="btn btn-lg btn-block btn-secondary" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 my-2 table-responsive" id="printableArea">
                    <div id="client_Infobox"></div>
                    <table class="table table-sm table-bordered yajra-datatable" id="yajra-datatable">
                        <thead class="text-center">
                            <th>{{ __('messages.sl') }}</th>
                            <th class="date-cell">{{ __('messages.date') }}</th>
                            <th class="product-cell">{{ __('messages.product') }}</th>
                            <th>{{ __('messages.qty') }}</th>
                            <th>{{ __('messages.unit') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.description') }}</th>
                            <th>{{ __('messages.labour_cost') }}</th>
                            <th>{{ __('messages.bill') }}</th>
                            <th>{{ __('messages.sales') }} {{ __('messages.return') }}</th>
                            <th>{{ __('messages.receive') }}</th>
                            <th>{{ __('messages.money') }} {{ __('messages.return') }}</th>
                            <th>{{ __('messages.balance') }}</th>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('user.client.view')
@endsection
@push('scripts')
    <script>
        // --------------------------------------------------------------------
        function view(id) {
            var client_id = id;
            var url = '{{ route('user.client.view', ':id') }}';
            url = url.replace(':id', client_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $("#clientView").modal('show');
                    setTimeout(() => {
                        $("#modalHeader").text("Client View | " + data.client_name);
                        $(".client_id_no").text(data.id_no);
                        $(".client_name").text(data.client_name);
                        $(".client_email").text(data.email);
                        $(".client_mobile").text(data.phone);
                        $(".client_dob").text(data.date_of_birth);
                        $(".client_address").text(data.address);
                        $(".client_group").text(data.group_name);
                        $(".client_zip_code").text(data.zip_code);
                    }, 0);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Client Group Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $("#clearFilter").on('click', function() {
            $("#starting_date").val('');
            $("#ending_date").val('');

            $('#yajra-datatable').DataTable().ajax.reload();
            fetchClients();
            fetchAccounts();
        });

        $(document).ready(function() {
            fetchClients();
            fetchAccounts();
        });

        $("#starting_date").on("change", function() {
            var starting_date = $('#starting_date').val();
            var ending_date = $('#ending_date').val();

            // Replace forward slashes with dashes
            starting_date = starting_date.replace(/\//g, '-');
            ending_date = ending_date.replace(/\//g, '-');
            var dates = "<h4 style='text-align: right !important;'>{{ __('messages.client') }} " + " Ledger From " + starting_date + " To " + ending_date + "</h4>";
            $("#clientLegderDate").html(dates)
        });

        @if ($client_id)
            setTimeout(() => {
                getClientInfo('/get-client-info', "{{ $client_id }}");
            }, 500);
        @endif
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

            $("#ending_date").on("change", function() {
                var starting_date = $('#starting_date').val();
                var ending_date = $('#ending_date').val();

                // Replace forward slashes with dashes
                starting_date = starting_date.replace(/\//g, '-');
                ending_date = ending_date.replace(/\//g, '-');
                var dates = "<h4 style='text-align: right !important;'>{{ __('messages.client') }} " + " Ledger From " + starting_date + " To " + ending_date + "</h4>";
                $("#clientLegderDate").html(dates)
            });

            dataTable = $('#yajra-datatable').DataTable({
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
                buttons: [
                    // {
                    //     extend: 'excel',
                    //     text: 'Excel',
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     }
                    // },
                    // {
                    //     extend: 'csv',
                    //     text: 'CSV',
                    //     exportOptions: {
                    //         columns: ':visible'
                    //     }
                    // },
                    // {
                    //     extend: 'pdf',
                    //     text: 'PDF',
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
                    //         var htmlHeader = $('.header');
                    //         // var htmlClientInfo = $('#client_Infobox').html();
                    //         $(win.document.body).find('h1').css('display', 'none');
                    //         // $(win.document.body).prepend(htmlClientInfo);
                    //         $(win.document.body).prepend(htmlHeader);
                    //     }
                    // },
                    'reset',

                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $("#client_id").val();
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
                        data: 'product',
                        name: 'product',
                        orderable: false,
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        orderable: false,
                    },
                    {
                        data: 'unit_id',
                        name: 'unit_id',
                        orderable: false,
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                    },
                    {
                        data: 'labour_cost',
                        name: 'labour_cost',
                        orderable: false,
                    },
                    {
                        data: 'purchase_bill',
                        name: 'purchase_bill',
                        orderable: false,
                    },
                    {
                        data: 'return',
                        name: 'return',
                        orderable: false,
                    },
                    {
                        data: 'receive_or_credit',
                        name: 'receive_or_credit',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'money_return',
                        name: 'money_return',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'balance',
                        name: 'balance',
                        orderable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var purchaseTotal = 0;
                        var receive = 0;
                        var salesReturnTotal = 0;
                        var balanceTotal = 0;
                        var moneyReturnTotal = 0;

                        // Loop through the rows in the current page
                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            var creditValue = parseFloat(rowData.purchase_bill);
                            var returnValue = parseFloat(rowData.return);
                            var debitValue = parseFloat(rowData.receive_or_credit);
                            var moneyReturnValue = parseFloat(rowData.money_return);
                            if (!isNaN(creditValue)) {
                                purchaseTotal += creditValue;
                            }
                            if (!isNaN(returnValue)) {
                                salesReturnTotal += returnValue;
                            }
                            if (!isNaN(debitValue)) {
                                receive += debitValue;
                            }
                            if (!isNaN(moneyReturnValue)) {
                                moneyReturnTotal += moneyReturnValue;
                            }
                        });

                        var receiveOrCredit = receive - salesReturnTotal;
                        var receiveTotal = receive.toFixed(2)

                        balanceTotal = (purchaseTotal - receive) + (moneyReturnTotal - salesReturnTotal);
                        // Update the footer totals
                        $('#yajra-datatable tfoot td:eq(1)').text(purchaseTotal.toFixed(2)); //purchase bill
                        $('#yajra-datatable tfoot td:eq(2)').text(salesReturnTotal.toFixed(2)); //purchase bill
                        $('#yajra-datatable tfoot td:eq(3)').text(receiveTotal); // payment or debit
                        $('#yajra-datatable tfoot td:eq(4)').text(moneyReturnTotal.toFixed(2)); // payment or debit
                        $('#yajra-datatable tfoot td:eq(5)').text(balanceTotal.toFixed(2));
                        // $('#yajra-datatable tfoot th:eq(3)').text(purchaseTotal.toFixed(2)); // balance
                    }

                    // Add the footer row initially
                    $('#yajra-datatable').append('<tfoot class="text-center font-weight-bold"><tr><td colspan="8">Total</td><td></td><td></td>><td></td><td></td><td></td></tr></tfoot>');

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
