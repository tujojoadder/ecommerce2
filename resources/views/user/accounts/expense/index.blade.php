@extends('layouts.user.app', ['pageTitle' => $pageTitle])
<style>
    #file-export-datatable_wrapper .dt-buttons {
        position: relative !important;
    }
</style>
@section('content')
    @php
        $queryString = $_SERVER['QUERY_STRING'];
        $supplier_id = $_GET['supplier_id'] ?? null;
        $staff_id = $_GET['staff_id'] ?? null;
    @endphp
    <div class="main-content-body">
        @include('user.accounts.expense.expense-collapse')
        @if ($queryString == 'create-staff-payment' || $queryString == 'create-expense' || $queryString == 'create-money-return' || $queryString == 'create-supplier-payment' || $queryString == 'create-staff-payment')
        @else
            <div class="card">
                <div class="card-body bg-white table-responsive">
                    @include('layouts.user.print-header')
                    <div class="text-end">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                            <div class="d-flex align-items-center">
                                @if ($queryString == 'supplier-payment' || $queryString == 'create-supplier-payment')
                                    <a class="btn ripple btn-success me-2" href="{{ route('user.expense.index') }}?create-supplier-payment" role="button"> <i class="fas fa-plus"></i> {{ __('messages.payment') }}</a>
                                @elseif ($queryString == 'money-return' || $queryString == 'create-money-return')
                                    <a class="btn ripple btn-success me-2" href="{{ route('user.expense.index') }}?create-money-return" role="button"> <i class="fas fa-plus"></i> {{ __('messages.money') }} {{ __('messages.return') }}</a>
                                @elseif ($queryString == 'staff-payment')
                                    <a class="btn ripple btn-success me-2" href="{{ route('user.expense.index') }}?create-staff-payment" role="button"> <i class="fas fa-plus"></i> {{ __('messages.payment') }}</a>
                                @elseif ($queryString == 'personal-expense')
                                    <a class="btn ripple btn-success me-2" href="{{ route('user.expense.index') }}?create-personal-expense" role="button"> <i class="fas fa-plus"></i> {{ __('messages.personal_expense') }}</a>
                                @elseif ($queryString == 'daily-expense')
                                    <a class="btn ripple btn-success me-2" href="{{ route('user.expense.index') }}?create-daily-expense" role="button"> <i class="fas fa-plus"></i> {{ __('messages.daily_expense') }}</a>
                                @else
                                    <a href="{{ route('user.expense.index') }}?create-expense" class="btn ripple btn-success me-2 text-white"><i class="fas fa-plus"></i> {{ __('messages.expense') }} {{ __('messages.create') }}</a>
                                @endif
                                <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/TJKc2DTtst8?si=GeqmIXdKxyVExgnL">
                                    <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                @if ($queryString == 'staff-payment')
                                    <div class="col-md-3 mb-1" id="staffs">
                                        <label for="select_staff_id">{{ __('messages.search_by') }} {{ __('messages.staff') }}</label>
                                        <select name="select_staff_id" id="staff_id" class="select_staff_id select2 form-control" style="width: 100% !important;">
                                        </select>
                                    </div>
                                @elseif ($queryString == 'supplier-payment')
                                    <div class="col-md-3 mb-1" id="supplier">
                                        <label for="supplier_id">{{ __('messages.search_by') }} {{ __('messages.supplier') }}</label>
                                        <select name="supplier_id" id="supplier_id" class="supplier_id select2 form-control" style="width: 100% !important;">
                                        </select>
                                    </div>
                                @else
                                    @if ($queryString != 'personal-expense')
                                        <div class="col-md-3 mb-1" id="clients">
                                            <label for="client_id">{{ __('messages.search_by') }} {{ __('messages.client') }}</label>
                                            <select name="client_id" id="client_id" class="select_client_id select2 form-control" style="width: 100% !important;">
                                            </select>
                                        </div>
                                    @endif
                                @endif
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
                            <table class="table table-sm table-bordered yajra-datatable" id="yajra-datatable">
                                <thead class="text-center">
                                    <th>{{ __('messages.sl') }}</th>
                                    <th class="date-cell">{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.receipt_for') }}</th>
                                    <th>{{ __('messages.id_no') }}</th>
                                    <th>{{ __('messages.category') }}</th>
                                    <th>{{ __('messages.account') }}</th>
                                    <th>{{ __('messages.check_no') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.transaction') . ' ' . __('messages.type') }}</th>
                                    <th>{{ __('messages.expense_type') }}</th>
                                    <th>{{ __('messages.bank') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th class="print-hide">{{ __('messages.printable') }}</th>
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

    {{-- @include('user.accounts.expense.expense-modal') --}}
    @include('user.client.client-add-modal')
    @include('user.accounts.account.account-modal')
    @include('user.accounts.expense.expense-category-modal')
    @include('user.accounts.expense.expense-subcategory-modal')
    @include('user.receipt.expense-voucher')
@endsection

@push('scripts')
    <script>
        // for expense modal
        $(document).ready(function() {
            $("#accountModalBtn").click(function() {
                $("#accountAddModal").modal("show");
            });
            $("#expenseCategoryBtn").click(function() {
                $('#updateExpenseCategory').addClass('d-none');
                $("#expenseCategoryModal").modal("show");
            });
            $("#ExpenseSubcategoryBtn").click(function() {
                $('#updateExpenseSubcategory').addClass('d-none');
                $("#ExpenseSubcategoryModal").modal("show");
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
                    var url = '{{ route('user.receive.destroy', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            $('#yajra-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Expense deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        $("#addExpenseBtnClose").on('click', function() {
            $('#addExpenseText').removeClass('d-none');
            $('#updateExpenseText').addClass('d-none');
            $('#addExpense').removeClass('d-none');
            $('#updateExpense').addClass('d-none');

            $('#expense-form').find('input, textarea, select').each(function() {
                var id = this.id;
                $('#' + id + '').val('');
                if (id == 'account_id') {
                    $('#account_id').val('').trigger('change');
                }
                if (id == 'date') {
                    $('#date').val("{{ date('m/d/Y') }}");
                }
                if (id == 'expense_category_id') {
                    $('#expense_category_id').val('').trigger('change');
                }
                if (id == 'subcategory_id') {
                    $('#subcategory_id').val('').trigger('change');
                }
                if (id == 'payment_id') {
                    $('#payment_id').val('').trigger('change');
                }
                if (id == 'bank_id') {
                    $('#bank_id').val('').trigger('change');
                }
            });
        });
    </script>
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchAccounts();
            fetchExpenseCategories();
            fetchExpenseSubcategories();
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
                $(".select_client_id").val('').trigger('change');
                $(".supplier_id").val('').trigger('change');
                $(".select_staff_id").val('').trigger('change');
                $("#starting_date").val('');
                $("#ending_date").val('');

                fetchClients();
                dataTable.ajax.reload();
            });

            $(".select_client_id, #starting_date, #ending_date, .select_staff_id").on("change", function() {
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
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.query_string = "{{ $_SERVER['QUERY_STRING'] }}";
                        d.supplier_id = "{{ $supplier_id }}";
                        d.staff_id = "{{ $staff_id }}";

                        d.select_supplier_id = $(".supplier_id").val();
                        d.select_staff_id = $(".select_staff_id").val();
                        d.client_id = $(".select_client_id").val();
                        d.starting_date = $("#starting_date").val();
                        d.ending_date = $("#ending_date").val();
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
                        data: 'created_at',
                        name: 'created_at',
                        orderable: false,
                    },
                    {
                        data: 'receipt_for',
                        name: 'receipt_for',
                        orderable: false,
                    },
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                    },
                    {
                        data: 'category_id',
                        name: 'category_id',
                        searchable: true,
                        orderable: false,
                    },
                    {
                        data: 'account_id',
                        name: 'account_id',
                        orderable: false,
                    },
                    {
                        data: 'cheque_no',
                        name: 'cheque_no',
                        orderable: false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type',
                        orderable: false,
                    },
                    {
                        data: 'expense_type',
                        name: 'expense_type',
                        orderable: false,
                    },
                    {
                        data: 'bank_id',
                        name: 'bank_id',
                        orderable: false,
                    },
                    {
                        data: 'amount',
                        name: 'amount',
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
                        var tfootContent = '<tfoot class="text-center font-weight-bold"><tr><td colspan="11">Total</td><td>' + balanceTotal + '</td><td colspan="2"></td></tr></tfoot>';
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
