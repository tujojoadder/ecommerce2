@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
    @endphp
    <div class="main-content-body">
        @if ($queryString == 'create' || $queryString == 'create-draft' || $queryString == 'sales-return')
            @include('user.invoice.edit')
        @else
            @include('user.invoice.edit')
            <div class="card">
                <div class="card-body bg-white table-responsive">
                    @include('layouts.user.print-header')
                    <div class="text-end">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                            <div class="">
                                @if ($queryString == 'draft')
                                    <a href="{{ route('user.invoice.create.draft') }}" class="btn btn-success">{{ __('messages.invoice') }} {{ __('messages.create') }}</a>
                                @else
                                    @if (Route::is('user.invoice.sales.return'))
                                        <a href="{{ route('user.invoice.create.return') }}" class="btn btn-success">{{ __('messages.add') }} {{ __('messages.return') }}</a>
                                    @else
                                        <a href="{{ route('user.invoice.create') }}" class="btn btn-success">{{ __('messages.invoice') }} {{ __('messages.create') }}</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if ($queryString == 'draft')
                            @if ($queryString == 'draft')
                                <input type="hidden" value="{{ $queryString }}" id="draft">
                            @endif
                        @endif
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 mb-1">
                                <div class="d-flex">
                                    <div class="w-100 input-group">
                                        <select name="client_id" id="client_id" class="client_id form-control select2">
                                        </select>
                                    </div>
                                    <a href="javascript:;" class="btn border add-btn disabled"><i class="fas fa"></i></a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="d-flex">
                                    <div class="w-100 input-group">
                                        <select name="account_id" id="account_id" class="account_id form-control select2">
                                        </select>
                                    </div>
                                    <a href="javascript:;" class="btn border add-btn disabled"><i class="fas fa"></i></a>
                                </div>
                            </div>
                            <div id="dateSearch" class="col-md-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="date" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                    <input type="text" name="date1" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div id="dateSearch" class="col-md-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="date" class="invoice_id form-control" placeholder="{{ __('messages.invoice_no') }}">
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <button class="btn w-100 btn-success d-flex justify-content-center clearFilter btn-lg">Clear Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12 my-2 table-responsive" id="printableArea">
                            <div id="client_Infobox"></div>
                            <table class="table table-sm table-bordered yajra-datatable" id="yajra-datatable">
                                <thead class="text-center">
                                    <th>{{ __('messages.sl') }}</th>
                                    <th>{{ __('messages.issued_date') }}</th>
                                    <th>{{ __('messages.client') }}</th>
                                    <th>{{ __('messages.invoice') }} {{ __('messages.id_no') }}</th>
                                    <th>{{ __('messages.bill') . ' ' . __('messages.amount') }}</th>
                                    @if (request()->routeIs('user.invoice.sales.return'))
                                        <th>{{ __('messages.return') . ' ' . __('messages.amount') }}</th>
                                    @else
                                        <th>{{ __('messages.receive') . ' ' . __('messages.amount') }}</th>
                                    @endif
                                    <th>{{ __('messages.due') . ' ' . __('messages.amount') }}</th>
                                    <th>{{ __('messages.printable') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        $(".clearFilter").on('click', function() {
            $(".client_id").val('').trigger('change');
            $("#account_id").val('').trigger('change');
            $(".type_search_box").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');
            $(".invoice_id").val('');
            $('.yajra-datatable').DataTable().ajax.reload();
            fetchClients();
            fetchAccounts();
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
                    var url = '{{ route('user.invoice.destroy', ':id') }}';
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
                                title: 'Receive deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        function destroyItem(id) {
            var data_id = id;
            var url = '{{ route('user.invoice.destroy.item', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $('.quantity').keyup();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Item Deleted successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        $("#invoiceBtn").on('click', function() {
            $('#addInvoiceText').removeClass('d-none');
            $('#updateInvoiceText').addClass('d-none');
            $('#addInvoice').removeClass('d-none');
            $('#updateInvoice').addClass('d-none');
            $("#order_table tbody").empty();
            clearInvoiceField();
            $('#invoice-form').find('input, textarea, select').each(function() {
                var id = this.id;
                $('#' + id + '').val('');
                if (id == 'date') {
                    $('#date').val("{{ date('d/m/Y') }}");
                }
                if (id == 'sms') {
                    $('#sms').prop('checked', false);
                }
                if (id == 'email') {
                    $('#email').prop('checked', false);
                }
            });
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

            $("#client_id, #account_id, #starting_date, #ending_date, .invoice_id").on("change input", function() {
                dataTable.ajax.reload();
            });
            @if ($_SERVER['QUERY_STRING'] == 'draft')
                setTimeout(() => {
                    var draft = $('#draft').keyup();
                }, 500);
            @endif
            dataTable = $('#yajra-datatable').DataTable({
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
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $(".client_id").val();
                        d.account_id = $(".account_id").val();
                        d.draft = $('#draft').val();

                        d.starting_date = $('#starting_date').val();
                        d.ending_date = $('#ending_date').val();
                        d.invoice_id = $('.invoice_id').val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error, e.g., display a message or take appropriate action
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },
                columns: [{
                        data: 'dt_id',
                        name: 'dt_id',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'issued_date',
                        name: 'issued_date',
                        orderable: false,
                    },
                    {
                        data: 'client_id',
                        name: 'client_id',
                        orderable: false,
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'bill_amount',
                        name: 'bill_amount',
                        orderable: false,
                    },
                    {
                        data: 'receive_amount',
                        name: 'receive_amount',
                        orderable: false,
                    },
                    {
                        data: 'due_amount',
                        name: 'due_amount',
                        orderable: false,
                    },
                    {
                        data: 'printable',
                        name: 'printable',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var billAmountTotal = 0;
                        var totalDiscount = 0;
                        var receiveAmountTotal = 0;
                        var dueAmountTotal = 0;

                        // Check if data is present before processing
                        if (json.data && json.data.length > 0) {
                            // Loop through the rows in the current page
                            $('#yajra-datatable tbody tr').each(function() {
                                var row = dataTable.row($(this)).data(); // Get the data for the row
                                if (typeof row.bill_amount !== 'undefined') {
                                    var billAmount = parseFloat(row.bill_amount);

                                    if (!isNaN(billAmount)) {
                                        billAmountTotal += billAmount;
                                    }
                                }
                                if (typeof row.discount !== 'undefined') {
                                    var discountAmount = parseFloat(row.discount);

                                    if (!isNaN(discountAmount)) {
                                        totalDiscount += discountAmount;
                                    }
                                }
                                if (typeof row.receive_amount !== 'undefined') {
                                    var receiveAmount = parseFloat(row.receive_amount);

                                    if (!isNaN(receiveAmount)) {
                                        receiveAmountTotal += receiveAmount;
                                    }
                                }
                                if (typeof row.due_amount !== 'undefined') {
                                    var dueAmount = parseFloat(row.due_amount);

                                    if (!isNaN(dueAmount)) {
                                        dueAmountTotal += dueAmount;
                                    }
                                }
                            });
                        }

                        // Remove existing footer (if any)
                        $('#yajra-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="4">Total</td><td>' + billAmountTotal.toFixed(2) + '</td><td>' + receiveAmountTotal.toFixed(2) + '</td><td>' + dueAmountTotal.toFixed(2) + '</td><td colspan="4"></td></tr></tfoot>';
                        $('#yajra-datatable').append(tfootContent);
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
