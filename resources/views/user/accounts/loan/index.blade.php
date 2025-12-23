@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
        $client_id = $_GET['client_id'] ?? '';
    @endphp
    <div class="main-content-body">
        @if ($queryString == 'create-receive' || $client_id || $queryString == 'create-payment')
            @include('user.accounts.loan.loan-form')
        @else
            @include('user.accounts.loan.loan-form')
            <div class="card">
                <div class="card-body bg-white table-responsive">
                    @include('layouts.user.print-header')
                    <div class="text-end">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                            <div class="d-flex align-items-center">
                                @if (request()->has('loan-receive'))
                                    <a class="btn ripple btn-success me-2 text-white" href="{{ route('user.loan.index') }}?create-receive" type="button"><i class="fas fa-plus"></i> {{ __('messages.add_loan_receive') }}</a>
                                @else
                                    <a class="btn ripple btn-success me-2 text-white" href="{{ route('user.loan.index') }}?create-payment" type="button"><i class="fas fa-plus"></i> {{ __('messages.add_loan_payment') }}</a>
                                @endif
                                <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/gplWthmKLec?si=6bTaz7Lyz_JGIg6r">
                                    <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                <div class="col-md-3 mb-1" id="clients">
                                    <label for="client_id">{{ __('messages.search_by') }} {{ __('messages.client') }}</label>
                                    <select name="client_id" id="client_id" class="select_client_id select2 form-control" style="width: 100% !important;">
                                    </select>
                                </div>
                                <input type="hidden" id="type" class="form-control" value="{{ $queryString }}">
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
                                    <th>{{ __('messages.sl') }}</th>
                                    <th class="date-cell">{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.receipt_no') }}</th>
                                    <th>{{ __('messages.client') }}</th>
                                    <th>{{ __('messages.type') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    {{-- <th class="print-hide">{{ __('messages.money_receipt') }}</th> --}}
                                    <th class="print-hide">{{ __('messages.action') }}</th>
                                </thead>
                                <tbody class="text-center hide-last-two-column">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('user.project.project-modal')
    @include('user.accounts.account.account-modal')
    @include('user.client.client-add-modal')
    @if ($queryString == 'create-receive' || $client_id || $queryString == 'loan-receive')
        @include('user.accounts.receive.category.modal')
        @include('user.accounts.receive.subcategory.modal')
    @else
        @include('user.accounts.expense.expense-category-modal')
        @include('user.accounts.expense.expense-subcategory-modal')
    @endif
    @include('user.config.chart-of-account.chart-of-account-modal')
    @include('user.config.chart-of-account.chart-group-modal')
    @include('user.receipt.receive-modal')
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/get-client-info.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                var client_id = "{{ $client_id }}";
                getClientInfo('/get-client-info', client_id);
            }, 1000);
        });
    </script>
    <script>
        // for receive modal
        $(document).ready(function() {
            $("#receiveBtn").click(function() {
                $("#addReceiveModal").modal("show");
            });
            $("#accountModalBtn").click(function() {
                $("#accountAddModal").modal("show");
            });
            @if ($queryString == 'create-receive' || $client_id || $queryString == 'loan-receive')
                $("#receiveCategoryAddModalBtn").click(function() {
                    $("#receiveCategoryModal").modal("show");
                });
            @else
                $("#expenseCategoryAddModalBtn").click(function() {
                    $("#expenseCategoryModal").modal("show");
                });
            @endif
            $("#receiveSubCategoryAddModalBtn").click(function() {
                $("#receiveSubcategoryModal").modal("show");
            });
            $("#chartOfAccountBtn").click(function() {
                $('#updateChartOfAccount').addClass('d-none');
                $("#chartOfAccountModal").modal("show");
            });
            $("#chartOfAccountGroup").click(function() {
                $('#updateChartOfAccountGroup').addClass('d-none');
                $("#ChartOfAccountGroupModal").modal("show");
            });

            $("#type").keyup();
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
                    var url = '{{ route('user.receive.destroy', ':id') }}';
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

        $("#addReceiveBtn").on('click', function() {
            $('#addReceiveText').removeClass('d-none');
            $('#updateReceiveText').addClass('d-none');
            $('#addReceive').removeClass('d-none');
            $('#updateReceive').addClass('d-none');

        });
    </script>
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClients();
            fetchAccounts();
            fetchReceiveCategories();
            fetchExpenseCategories();
        });
    </script>
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}

    <script>
        $(function() {
            var dataTable;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#clearFilter").on('click', function() {
                $(".select_client_id").val('');
                $("#starting_date").val('');
                $("#ending_date").val('');
                $("#type").val('');

                fetchClients();
                dataTable.ajax.reload();
            });

            $(".select_client_id, #starting_date, #ending_date, #type").on("change input", function() {
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
                buttons: [
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $(".select_client_id").val();
                        d.type = $("#type").val();
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
                        orderable: false
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: false,
                    },
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                    },
                    {
                        data: 'client_id',
                        name: 'client_id',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                    },

                    {
                        data: 'amount',
                        name: 'amount',
                        orderable: false,
                    },
                    // {
                    //     data: 'printable',
                    //     name: 'printable',
                    //     orderable: false,
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                    },
                ],
                initComplete: function(settings, json) {
                    // Function to calculate and update footer totals
                    function updateFooterTotals() {
                        var amountTotal = 0;

                        // Check if data is present before processing
                        if (json.data && json.data.length > 0) {
                            // Loop through the rows in the current page
                            $('.yajra-datatable tbody tr').each(function() {
                                var row = dataTable.row($(this)).data(); // Get the data for the row

                                // Check if row data exists before accessing properties
                                if (typeof row.amount !== 'undefined') {
                                    var creditValue = parseFloat(row.amount);

                                    if (!isNaN(creditValue)) {
                                        amountTotal += creditValue;
                                    }
                                }
                            });
                        }

                        var balanceTotal = amountTotal;

                        // Remove existing footer (if any)
                        $('.yajra-datatable tfoot').remove();

                        // Add the footer row with the calculated totals
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="6">Total</td><td>' + balanceTotal + '</td><td colspan="2"></td></tr></tfoot>';
                        $('.yajra-datatable').append(tfootContent);
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
