@extends('layouts.user.app')
@section('content')
    @include('layouts.table-css')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-lg-flex d-block justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div>
                        <a href="{{ route('user.report.expense.all') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                        </a>
                        <a href="{{ route('user.report.expense.category.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.category') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ route('user.report.expense.subcategory.wise') }}" class="btn btn-secondary mb-1">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.subcategory') }} {{ __('messages.wise') }}
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        <a href="{{ route('user.supplier.create') }}" class="btn btn-success"><i class="fas fa-plus d-inline"></i> {{ __('messages.add_new') }}</a>
                    </div>
                </div>
                @include('layouts.user.print-header')
                <div class="card-body bg-white table-responsive">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="row mb-3">
                                <div class="col-md-8 mb-1">
                                    <select name="client_id" id="client_id" class="client_id form-control select2">
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <button class="btn btn-lg btn-block btn-success" id="clearFilter">{{ __('messages.clear') }} {{ __('messages.filter') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="file-export-datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.id_no') }}</th>
                                <th class="date-cell">{{ __('messages.date') }}</th>
                                <th>{{ __('messages.voucher_no') }}</th>
                                <th>{{ __('messages.category') }}</th>
                                <th>{{ __('messages.account') }}</th>
                                <th>{{ __('messages.cheque_no') }}</th>
                                <th>{{ __('messages.description') }}</th>
                                <th>{{ __('messages.type') }}</th>
                                <th>{{ __('messages.amount') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!} --}}

    <script>
        $('.client_id').on('change', function() {
            $('#file-export-datatable').DataTable().ajax.reload();
        });

        $("#clearFilter").on('click', function() {
            $(".client_id").val('');
            $(".type_search_box").val('');
            $('#file-export-datatable').DataTable().ajax.reload();
            fetchClients();
        });

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Choose Customer',
                searchInputPlaceholder: 'Search'
            });
            fetchClients();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#file-export-datatable').DataTable({
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
                    'csv',
                    'pdf',
                    'print',
                    'reset',
                    'colvis'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = $("#client_id").val();
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error, e.g., display a message or take appropriate action
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
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'account_id',
                        name: 'account_id'
                    },
                    {
                        data: 'cheque_no',
                        name: 'cheque_no'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                ],
            });
        });
    </script>
@endpush
