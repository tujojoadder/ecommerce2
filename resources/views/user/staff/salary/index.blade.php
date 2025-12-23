@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $month = $_GET['month'] ?? 0;
        $year = $_GET['year'] ?? 0;
    @endphp
    <div class="main-content-body">
        <form action="{{ route('user.staff.salary.index') }}" method="GET">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-end justify-content-between">
                        <div class="input-group me-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.month') }}">
                            <label class="text-white" for="month">{{ __('messages.month') }}</label>
                            <select name="month" id="month" class="form-control select2 month" required>
                                <option {{ ($month == 1 ? 'selected' : date('m') == 1) ? 'selected' : '' }} value="1">January</option>
                                <option {{ ($month == 2 ? 'selected' : date('m') == 2) ? 'selected' : '' }} value="2">February</option>
                                <option {{ ($month == 3 ? 'selected' : date('m') == 3) ? 'selected' : '' }} value="3">March</option>
                                <option {{ ($month == 4 ? 'selected' : date('m') == 4) ? 'selected' : '' }} value="4">April</option>
                                <option {{ ($month == 5 ? 'selected' : date('m') == 5) ? 'selected' : '' }} value="5">May</option>
                                <option {{ ($month == 6 ? 'selected' : date('m') == 6) ? 'selected' : '' }} value="6">June</option>
                                <option {{ ($month == 7 ? 'selected' : date('m') == 7) ? 'selected' : '' }} value="7">July</option>
                                <option {{ ($month == 8 ? 'selected' : date('m') == 8) ? 'selected' : '' }} value="8">August</option>
                                <option {{ ($month == 9 ? 'selected' : date('m') == 9) ? 'selected' : '' }} value="9">September</option>
                                <option {{ ($month == 10 ? 'selected' : date('m') == 10) ? 'selected' : '' }} value="10">October</option>
                                <option {{ ($month == 11 ? 'selected' : date('m') == 11) ? 'selected' : '' }} value="11">November</option>
                                <option {{ ($month == 12 ? 'selected' : date('m') == 12) ? 'selected' : '' }} value="12">December</option>
                            </select>
                        </div>
                        <div class="input-group me-1" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.year') }}">
                            <label class="text-white" for="year">{{ __('messages.year') }}</label>
                            <select name="year" id="year" class="form-control select2 year" required>
                                @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                    <option {{ ($year ? ($year == $i ? 'selected' : '') : date('Y') == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="input-group">
                            <button class="btn w-100 btn-success">{{ __('messages.search') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mt-3 pt-3">
            <div class="card-header">
                <p class="card-title h3">{{ $pageTitle }}</p>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12 my-2 table-responsive" id="printableArea">
                        <table class="table table-sm table-bordered yajra-datatable">
                            <thead class="text-center">
                                <th>{{ __('messages.id_no') }}</th>
                                <th>{{ __('messages.image') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.sallary') }}</th>
                                <th>{{ __('messages.payment') }}</th>
                                <th>{{ __('messages.will_get') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.signature') }}</th>
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
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
                    'excel',
                    'csv',
                    'pdf',
                    'print',
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.month = "{{ $month }}";
                        d.year = "{{ $year }}";
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
                        data: 'image',
                        name: 'image',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'salary',
                        name: 'salary',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        orderable: false,
                    },
                    {
                        data: 'due',
                        name: 'due',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                    },
                    {
                        data: 'signature',
                        name: 'signature',
                        orderable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var debitTotal = 0;
                        var creditTotal = 0;
                        var balanceTotal = 0;

                        // Loop through the rows in the current page
                        dataTable.rows({
                            page: 'current'
                        }).data().each(function(rowData) {
                            var creditValue = parseFloat(rowData.salary);
                            var debitValue = parseFloat(rowData.payment);
                            if (!isNaN(creditValue)) {
                                creditTotal += creditValue;
                            }
                            if (!isNaN(debitValue)) {
                                debitTotal += debitValue;
                            }
                        });

                        balanceTotal += creditTotal - debitTotal;
                        // Update the footer totals
                        $('.yajra-datatable tfoot th:eq(1)').text(creditTotal.toFixed(2)); //purchase bill
                        $('.yajra-datatable tfoot th:eq(2)').text(debitTotal.toFixed(2)); // payment or debit
                        $('.yajra-datatable tfoot th:eq(3)').text(balanceTotal.toFixed(2));
                        // $('.yajra-datatable tfoot th:eq(3)').text(creditTotal.toFixed(2)); // balance
                    }

                    // Add the footer row initially
                    $('.yajra-datatable').append('<tfoot class="text-center"><tr><th colspan="3">Total</th><th></th><th></th><th></th><th></th><th></th></tr></tfoot>');

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
