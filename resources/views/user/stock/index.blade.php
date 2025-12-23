@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body bg-white table-responsive">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <a href="{{ route('user.product.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</a>
                    </div>
                </div>
                @include('layouts.user.print-header')
                <div class="row mb-3 mt-4 justify-content-center">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="search_text">&nbsp;</label>
                                <div class="form-group">
                                    <input type="text" id="search_text" class="form-control" style="width: 100% !important;" placeholder="{{ __('messages.search') . ' ' . __('messages.all') }}">
                                    <label class="animated-label active-label" for="client_id">{{ __('messages.search') . ' ' . __('messages.all') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-1" id="product">
                                <label for="product_id">{{ __('messages.search_by') }} {{ __('messages.product') }}</label>
                                <select id="product_id" class="product_id form-control" style="width: 100% !important;">
                                </select>
                            </div>
                            <div class="col-md-3 mb-1" id="clients">
                                <label for="client_id">{{ __('messages.search_by_client') }} {{ __('messages.group') }}</label>
                                <select id="group_id" class="select2 form-control" style="width: 100% !important;">
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
                <div class="row justify-content-center">
                    <div class="col-md-12 my-2 table-responsive" id="printableArea">
                        <table class="table table-sm table-bordered yajra-datatable">
                            <thead class="text-center">
                                <th>{{ __('messages.id_no') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.group') }}</th>
                                <th>{{ __('messages.opening_stock') }}</th>
                                <th>{{ __('messages.prev_stock') }}</th>
                                <th>{{ __('messages.buy') . ' ' . __('messages.quantity') }}</th>
                                <th>{{ __('messages.sale') . ' ' . __('messages.quantity') }}</th>
                                <th>{{ __('messages.return') . ' ' . __('messages.quantity') }}</th>
                                <th>{{ __('messages.stock') }}</th>
                                <th>{{ __('messages.carton') }}</th>
                                <th>{{ __('messages.total') . ' ' . __('messages.buying') . ' ' . __('messages.price') }}</th>
                                {{-- <th>{{ __('messages.total') . ' ' . __('messages.selling') . ' ' . __('messages.price') }}</th> --}}
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
            fetchProductGroups();
            fetchProducts();
        });

        $("#clearFilter").on('click', function() {
            $("#search_text").val('');
            $("#product_id").val('');
            $("#group_id").val('');
            $("#starting_date").val('');
            $("#ending_date").val('');

            fetchProductGroups();
            fetchProducts();
            $('.yajra-datatable').DataTable().ajax.reload();
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

            $("#group_id, #product_id, #starting_date, #ending_date").on("change", function() {
                dataTable.ajax.reload();
            });
            $("#search_text").on("input", function() {
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
                buttons: [{
                        extend: 'excel',
                        text: 'Excel',
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
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(win) {
                            var html = $('.header');
                            $(win.document.body).find('h1').css('display', 'none');
                            $(win.document.body).prepend(html);
                        }
                    },
                    'reset',
                    // 'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.search_text = $("#search_text").val();
                        d.product_id = $("#product_id").val();
                        d.group_id = $("#group_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Error: " + textStatus, errorThrown);
                    },
                },
                columns: [{
                        data: 'dt_id',
                        name: 'dt_id',
                        searchable: false,
                        orderable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: false,
                    },
                    {
                        data: 'product_details',
                        name: 'product_details',
                        orderable: false,
                    },
                    {
                        data: 'group_id',
                        name: 'group_id',
                        orderable: false,
                    },
                    {
                        data: 'opening_stock',
                        name: 'opening_stock',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'prev_stock',
                        name: 'prev_stock',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'buy',
                        name: 'buy',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'sale',
                        name: 'sale',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'return',
                        name: 'return',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'stock',
                        name: 'stock',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'carton',
                        name: 'carton',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'total_buying_price',
                        name: 'total_buying_price',
                        orderable: false,
                        searchable: false,
                    },
                    // {
                    //     data: 'total_selling_price',
                    //     name: 'total_selling_price',
                    //     orderable: false,
                    //     searchable: false,
                    // },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var totalBuyingPrice = 0;
                        var totalSellingPrice = 0;
                        var totalStock = 0;

                        // Loop through the rows in the current page
                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            var buyingPrice = parseFloat(rowData.total_buying_price);
                            var sellingPrice = parseFloat(rowData.total_selling_price);
                            var stock = parseFloat(rowData.stock);
                            if (!isNaN(buyingPrice)) {
                                totalBuyingPrice += buyingPrice;
                            }
                            if (!isNaN(sellingPrice)) {
                                totalSellingPrice += sellingPrice;
                            }
                            if (!isNaN(stock)) {
                                totalStock += stock;
                            }
                        });
                        // Update the footer totals
                        $('.yajra-datatable tfoot td:eq(1)').text(totalStock.toFixed(2));
                        $('.yajra-datatable tfoot td:eq(3)').text(totalBuyingPrice.toFixed(2));
                        // $('.yajra-datatable tfoot th:eq(2)').text(totalSellingPrice.toFixed(2));
                    }

                    // Add the footer row initially
                    $('.yajra-datatable').append('<tfoot class="text-center"><tr><td colspan="9" class="font-weight-bold">Total</td><td></td><td></td><td></td></tr></tfoot>');

                    // Calculate and update footer totals initially
                    updateFooterTotals();

                    // Bind the updateFooterTotals function to the draw.dt event
                    dataTable.on('draw.dt', function() {
                        updateFooterTotals();
                    });
                }

            });
        });
    </script>
@endpush
