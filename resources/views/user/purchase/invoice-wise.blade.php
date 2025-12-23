@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body bg-white table-responsive">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }}</p>
                        <div class="">
                            {{-- <a href="javascript:;" id="uploadBulkFiles" class="btn btn-secondary text-white me-2"><i class="fas fa-upload d-inline"></i> {{ __('messages.bulk_upload') }}</a>
                            <a href="{{ route('download.purchase.bulk') }}" class="btn btn-secondary text-white me-2"><i class="fas fa-download d-inline"></i> {{ __('messages.download_bulk_file') }}</a> --}}
                            <a href="{{ route('user.purchase.create') }}" class="btn btn-success"> <i class="fas fa-plus"></i> {{ request()->routeIs('user.purchase.return.invoice') ? __('messages.add_purchase_return') : __('messages.add_purchase') }}</a>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        @include('user.purchase.search-form')
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12 my-2 table-responsive" id="printableArea">
                        <table class="table table-sm table-bordered yajra-datatable">
                            <thead class="text-center">
                                <th>{{ __('messages.id_no') }}</th>
                                <th class="date-cell">{{ __('messages.date') }}</th>
                                <th>{{ __('messages.invoice') }}</th>
                                <th>{{ __('messages.supplier') }}</th>
                                <th>{{ __('messages.total') }}</th>
                                <th>{{ __('messages.action') }}</th>
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
                    var url = '{{ route('user.purchase.destroy', ':id') }}';
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
                                title: 'Purchased item deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        // edit client using ajax
        function edit(id) {
            var rowCount = $("#order_table tbody tr").length + 1; // initial row index number
            var data_id = id;
            var url = '{{ route('user.purchase.edit', ':id') }}';
            console.log(data_id);
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    // adding the data to fields

                    var invoice_id = $('#invoice_id').val(data.invoice_id);
                    var issued_date = $('#issued_date').val(data.issued_date);
                    var supplier_id = $('#supplier_id').val(data.supplier_id);
                    var warehouse_id = $('#warehouse_id').val(data.warehouse_id);
                    var discount = $('#discount').val(data.discount);
                    var discount_type = $('#discount_type').val(data.discount_type);
                    var transport_fare = $('#transport_fare').val(data.transport_fare);
                    var vat = $('#vat').val(data.vat);
                    var vat_type = $('#vat_type').val(data.vat_type);
                    var account_id = $('#account_id').val(data.account_id);
                    var category_id = $('#expense_category_id').val(data.category_id);
                    var receive_amount = $('#receive_amount').val(data.receive_amount);
                    var purchase_bill = $('#purchase_bill').val(data.purchase_bill);
                    var total_vat = $('#total_vat').val(data.total_vat);
                    var total_discount = $('#total_discount').val(data.total_discount);
                    var grand_total = $('#grand_total').val(data.grand_total);
                    var total_due = $('#total_due').val(data.total_due);

                    var items = data.purchased_items;
                    var html = '';
                    var unit = data.unit ?? 0;
                    $.each(items, function(index, value) {
                        html += "<tr>";
                        html += "<td width='3%'><input type='text' class='form-control fcsm bg-white text-center' name='row_id' value='" + rowCount + "' readonly></td>";
                        html += "<td><input type='text' class='form-control fcsm purchase-name' value='" + value.product.name + "' readonly><input type='hidden' value='" + value.product_id + "' name='product_id[]'></td>";
                        html += "<td><input type='number' step='any' class='form-control fcsm quantity' value='" + value.quantity + "' name='quantity[]'></td>";
                        html += "<td><input type='number' class='form-control fcsm purchase-buying_price' value='" + value.buying_price + "' name='buying_price[]'></td>";
                        html += "<td><input type='number' class='form-control fcsm cal_buying_total' value='" + value.total_buying_price + "' name='total_buying_price[]'></td>";
                        html += "<td><input type='number' class='form-control fcsm purchase-selling_price' value='" + value.selling_price + "' name='selling_price[]'></td>";
                        html += "<td class='d-none'><input type='hidden' step='any' class='form-control fcsm free' value='0' name='free[]'></td>";
                        html += "<td><input type='number' class='form-control fcsm cal_selling_total' readonly value='" + value.total_selling_price + "' name='total_selling_price[]'></td>";
                        html += "<td><input type='text' class='form-control fcsm text-center bg-white purchase-unit' value='" + unit.name + "' readonly><input type='hidden' value='" + value.unit_id + "' name='unit_id[]'></td>";
                        html += "<td><input type='text' class='form-control fcsm purchase-description' value='" + value.description + "' name='description[]'></td>";
                        html += "<td class='text-center'><a target='_blank' href='{{ route('user.product-barcode.index') }}?product_id=" + value.product_id + "&quantity=1' class='btn btn-sm btn-dark py-1'><i class='fas fa-qrcode' style='font-size: 15px !important;'></i></a><input type='hidden' class='form-control fcsm' value='" + data.id + "' name='barcode_id[]'></td>";
                        html += "<td class='text-center'><a href='javascript:;' class='btn btn-danger btn-sm p-1 delete-row'><i class='fas fa-trash'></i></a></td>";
                        html += "</tr>";
                    });
                    $('#order_table tbody').html(html);

                    $('#total_discount').val(data.total_discount)
                    $('#purchase_bill').val(data.purchase_bill)
                    $('#previous_due').val(data.previous_due)
                    $('#total_vat').val(data.total_vat)
                    $('#grand_total').val(data.grand_total)
                    $('#total_due').val(data.total_due)

                    $('#pucrhased_row_id').val(data.id);
                    // adding the data to fields

                    // hide show btn
                    $('#addInvoiceText').addClass('d-none');
                    $('#updateInvoiceText').removeClass('d-none');
                    $('#voucher_no').text(data.id);
                    $('#addInvoice').addClass('d-none');
                    $('#updateInvoice').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#addInvoiceModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Purchase Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

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

    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchSuppliers();
            $("#clearFilter").on('click', function() {
                $(".supplier_id").val('');
                $("#starting_date").val('');
                $("#ending_date").val('');
                $(".invoice_no").val('');

                fetchSuppliers();
                dataTable.ajax.reload();
            });

            $(".supplier_id, #starting_date, #ending_date, .invoice_no").on("change input", function() {
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
                    // 'copy',
                    'excel',
                    // 'csv',
                    // 'pdf',
                    // 'print',
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.account_id = $("#account_id").val();
                        d.type = $("#type").val();

                        d.select_supplier_id = $(".supplier_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
                        d.invoice_no = $(".invoice_no").val();
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
                        data: 'invoice_id',
                        name: 'invoice_id',
                        orderable: false,
                    },
                    {
                        data: 'supplier_id',
                        name: 'supplier_id',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
        });
    </script>
@endpush
