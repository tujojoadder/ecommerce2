@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            @include('layouts.user.print-header')
            <div class="card-body bg-white table-responsive">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }}</p>
                        <a href="{{ route('user.purchase.create') }}" class="btn btn-success"> <i class="fas fa-plus"></i> {{ __('messages.purchase') }}</a>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        @include('user.purchase.search-form')
                    </div>
                </div>
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {{-- <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> --}}
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchSuppliers();
            fetchProducts();
            @if (request()->supplier_id)
                setTimeout(() => {
                    $(".supplier_id").val("{{ request()->supplier_id }}").trigger('change');
                }, 500);
            @endif
            $("#clearFilter").on('click', function() {
                $(".supplier_id").val('');
                $("#starting_date").val('');
                $("#ending_date").val('');
                $(".product_name").val('');
                $(".invoice_no").val('');
                $(".product_id").val('');

                fetchSuppliers();
                fetchProducts();
                dataTable.ajax.reload();
            });

            $(".supplier_id, #product_id, #starting_date, #ending_date, .product_name, .invoice_no").on("change input", function() {
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

                        d.select_supplier_id = $(".supplier_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
                        d.product_name = $(".product_name").val();
                        d.product_id = $(".product_id").val();
                        d.invoice_no = $(".invoice_no").val();
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
                        data: 'supplier_id',
                        name: 'supplier_id'
                    },
                    {
                        data: 'product_id',
                        name: 'product_id'
                    },
                    {
                        data: 'group',
                        name: 'group'
                    },
                    {
                        data: 'buying_price',
                        name: 'buying_price'
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'total_buying_price',
                        name: 'total_buying_price'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var totalbuying_price = 0;
                        var totalselling_price = 0;
                        var totalquantity = 0;
                        var grand_total_buying_price = 0;

                        // Check if data is present before processing
                        if (json.data && json.data.length > 0) {
                            // Loop through the rows in the current page
                            $('#file-export-datatable tbody tr').each(function() {
                                var row = dataTable.row($(this)).data(); // Get the data for the row
                                if (typeof row.buying_price !== 'undefined') {
                                    var buying_price = parseFloat(row.buying_price);

                                    if (!isNaN(buying_price)) {
                                        totalbuying_price += buying_price;
                                    }
                                }
                                if (typeof row.selling_price !== 'undefined') {
                                    var selling_price = parseFloat(row.selling_price);

                                    if (!isNaN(selling_price)) {
                                        totalselling_price += selling_price;
                                    }
                                }
                                if (typeof row.quantity !== 'undefined') {
                                    var quantity = parseFloat(row.quantity);

                                    if (!isNaN(quantity)) {
                                        totalquantity += quantity;
                                    }
                                }
                                if (typeof row.total_buying_price !== 'undefined') {
                                    var total_buying_price = parseFloat(row.total_buying_price);

                                    if (!isNaN(total_buying_price)) {
                                        grand_total_buying_price += total_buying_price;
                                    }
                                }
                            });
                        }

                        // Remove existing footer (if any)
                        $('#file-export-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center footer"><tr><td colspan="5">Total</td><td>' + totalbuying_price + '</td><td>' + totalselling_price + '</td><td>' + totalquantity + '</td><td>' + grand_total_buying_price + '</td><td colspan="3"></td></tr></tfoot>';
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
            var printButton = $('<a href="javascript:;" id="printButton" class="btn btn-primary"><i class="fas fa-print" style="font-size: 15px"></i> {{ __('messages.print') }}</a>');
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
