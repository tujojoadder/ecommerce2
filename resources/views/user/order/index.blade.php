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
                            <div id="dateSearch" class="col-md-6 mt-2">
                                <div class="input-group">
                                    <input type="text" name="date" id="starting_date" class="fc-datepicker starting_date form-control" placeholder="DD/MM/YYYY">
                                    <input type="text" name="date1" id="ending_date" class="fc-datepicker ending_date form-control" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div id="dateSearch" class="col-md-6 mt-2">
                                <div class="input-group">
                                    <input type="text" name="date" class="invoice_id form-control" placeholder="{{ __('messages.order') }} {{ __('messages.id_no') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <button class="btn w-100 btn-success d-flex justify-content-center clearFilter btn-lg">Clear Filter</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="type" value="{{ $queryString ?? '' }}">
                    <div class="row justify-content-center">
                        <div class="col-md-12 my-2 table-responsive" id="printableArea">
                            <div id="client_Infobox"></div>
                            <table class="table table-sm table-bordered yajra-datatable" id="yajra-datatable">
                                <thead class="text-center">
                                    <th>{{ __('messages.sl') }}</th>
                                    <th>{{ __('messages.order') }} {{ __('messages.date') }} & {{ __('messages.time') }}</th>
                                    <th>{{ __('messages.order') }} {{ __('messages.id_no') }}</th>
                                    <th>{{ __('messages.client') }}</th>
                                    <th>{{ __('messages.subtotal') }}</th>
                                    <th>{{ __('messages.shipping_charge') }}</th>
                                    <th>{{ __('messages.discount') }}</th>
                                    <th>{{ __('messages.grand_total') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Total:</th>
                                        <th></th> <!-- Sub Total -->
                                        <th></th> <!-- Shipping -->
                                        <th></th> <!-- Discount -->
                                        <th></th> <!-- Grand Total -->
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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

        function changeStatus(order_id, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change this order status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/user/order/change/status/" + order_id + "/" + status,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (res) {
                            if (res.status === "success") {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                                $('#yajra-datatable').DataTable().ajax.reload(null, false); // reload table
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    res.message,
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Error!',
                                'Something went wrong!',
                                'error'
                            );
                        }
                    });
                }
            })
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
                        d.draft = $('#draft').val();
                        d.starting_date = $('#starting_date').val();
                        d.ending_date = $('#ending_date').val();
                        d.invoice_id = $('.invoice_id').val();
                        d.type = $("#type").val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },
                columns: [
                    { data: 'dt_id', name: 'dt_id', searchable: false, orderable: false },
                    { data: 'created_at', name: 'created_at', orderable: false },
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'client_id', name: 'client_id', orderable: false },
                    { data: 'sub_total', name: 'sub_total', orderable: false },
                    { data: 'total_shipping_charge', name: 'total_shipping_charge', orderable: false },
                    { data: 'total_discount', name: 'total_discount', orderable: false },
                    { data: 'grand_total', name: 'grand_total', orderable: false },
                    { data: 'status', name: 'status', orderable: false },
                    { data: 'action', name: 'action', orderable: false },
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Helper to parse float safely
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Columns to sum (based on your column index)
                    var subTotal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var shipping = api.column(5, { page: 'current' }).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var discount = api.column(6, { page: 'current' }).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var grandTotal = api.column(7, { page: 'current' }).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer cells
                    $(api.column(4).footer()).html(subTotal.toFixed(2));
                    $(api.column(5).footer()).html(shipping.toFixed(2));
                    $(api.column(6).footer()).html(discount.toFixed(2));
                    $(api.column(7).footer()).html(grandTotal.toFixed(2));
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
