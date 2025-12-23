@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body bg-white table-responsive">
                @include('layouts.user.print-header')
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <a href="{{ route('user.purchase.create') }}" class="btn btn-success"> <i class="fas fa-plus"></i> {{ __('messages.purchase') }}</a>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="supplier_id">{{ __('messages.search_by') }} {{ __('messages.supplier') }}</label>
                                <select name="supplier_id" id="supplier_id" class="select2 form-control" style="width: 100% !important;">
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
                <div id="supplier_Infobox"></div>
                <div class="row justify-content-center">
                    <div class="col-md-12 my-2 table-responsive" id="printableArea">
                        <table class="table table-sm table-bordered yajra-datatable" id="file-export-datatable">
                            <thead class="text-center">
                                <th>{{ __('messages.sl') }}</th>
                                <th class="date-cell">{{ __('messages.date') }}</th>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.unit') }}</th>
                                <th>{{ __('messages.quantity') }}</th>
                                <th>{{ __('messages.price') }}</th>
                                <th>{{ __('messages.buy') }} {{ __('messages.price') }}</th>
                                <th>{{ __('messages.discount') }}</th>
                                <th>{{ __('messages.grand_total') }}</th>
                                <th>{{ __('messages.payment') }}</th>
                                <th>{{ __('messages.receive') }}</th>
                                <th>{{ __('messages.due') }}</th>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchSuppliers();
            @if (request()->supplier_id)
                setTimeout(() => {
                    $("#supplier_id").val("{{ request()->supplier_id }}").trigger('change');
                }, 500);
            @endif
            $("#clearFilter").on('click', function() {
                $("#supplier_id").val('');
                $("#starting_date").val('');
                $("#ending_date").val('');

                fetchSuppliers();
                dataTable.ajax.reload();
            });

            $("#supplier_id, #starting_date, #ending_date").on("change", function() {
                dataTable.ajax.reload();
            });

            var dataTable = $('#file-export-datatable').DataTable({
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
                    //         var html = $('.header');
                    //         var htmlSupplierInfo = $('#supplier_Infobox').html();
                    //         $(win.document.body).find('h1').css('display', 'none');
                    //         $(win.document.body).prepend(htmlSupplierInfo);
                    //         $(win.document.body).prepend(html);
                    //     }
                    // },
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.supplier_id = $("#supplier_id").val();
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
                    // {
                    //     data: 'supplier_id',
                    //     name: 'supplier_id'
                    // },
                    {
                        data: 'product',
                        name: 'product'
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
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'buying_price',
                        name: 'buying_price'
                    },
                    // {
                    //     data: 'selling_price',
                    //     name: 'selling_price'
                    // },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total'
                    },
                    {
                        data: 'payment_amount',
                        name: 'payment_amount'
                    },
                    {
                        data: 'receive_amount',
                        name: 'receive_amount'
                    },
                    {
                        data: 'due_amount',
                        name: 'due_amount'
                    },
                ],
                initComplete: function(settings, json) {
                    function updateFooterTotals() {
                        var totalDiscountAmount = 0;
                        var grandTotal = 0;
                        var totalPaymentAmount = 0;
                        var totalReceiveAmount = 0;
                        var totalDueAmount = 0;

                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            totalDiscountAmount += parseFloat(rowData.discount) || 0;
                            grandTotal += parseFloat(rowData.grand_total) || 0;
                            totalPaymentAmount += parseFloat(rowData.payment_amount) || 0;
                            totalReceiveAmount += parseFloat(rowData.receive_amount) || 0;
                            totalDueAmount += parseFloat(rowData.due_amount) || 0;
                        });
                        dueAmount = grandTotal - Math.abs(totalPaymentAmount) + Math.abs(totalReceiveAmount);

                        $('#file-export-datatable tfoot td:eq(1)').text(totalDiscountAmount.toFixed(2));
                        $('#file-export-datatable tfoot td:eq(2)').text(grandTotal.toFixed(2));
                        $('#file-export-datatable tfoot td:eq(3)').text(totalPaymentAmount.toFixed(2));
                        $('#file-export-datatable tfoot td:eq(4)').text(totalReceiveAmount.toFixed(2));
                        $('#file-export-datatable tfoot td:eq(5)').text(dueAmount.toFixed(2));
                    }
                    $('#file-export-datatable').append('<tfoot class="text-center font-weight-bold"><tr><td colspan="7">Total</td><td></td><td></td><td></td><td></td><td></td></tr></tfoot>');

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

    <script>
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
                    var url = '{{ route('user.product.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('#file-export-datatable').DataTable().ajax.reload();
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

        $("#productBtn").on('click', function() {
            $('#addReceiveText').removeClass('d-none');
            $('#updateReceiveText').addClass('d-none');
            $('#addProduct').removeClass('d-none');
            $('#updateProduct').addClass('d-none');

            $('#product-form').find('input, textarea, select').each(function() {
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

        $("#productEditBtn").on('click', function() {
            $('#addReceiveText').addClass('d-none');
            $('#updateReceiveText').addClass('d-none');
            $('#updateProduct').removeClass('d-none');
            $('#addProduct').addClass('d-none');
            $('#updateReceive').removeClass('d-none');

            $('#product-form').find('input, textarea, select').each(function() {
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
@endpush
