@php
    $queryString = $_SERVER['QUERY_STRING'];
    $startDate = $_GET['starting_date'] ?? '';
    $endDate = $_GET['ending_date'] ?? '';
@endphp
@extends('layouts.user.app')
@section('content')
    @include('layouts.table-css')
    <div class="main-content-body">
        @if ($queryString == 'customer-search' || $queryString == 'group-search')
            <div class="container">
                <form action="" method="GET">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" name="starting_date" class="fc-datepicker form-control" value="{{ date(date('m') - 1 . '/d/Y') }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.starting_date') }}">
                                    <input type="text" name="ending_date" class="fc-datepicker form-control" value="{{ date('d/m/Y') }}" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.ending_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($queryString == 'customer-search')
                                <input type="hidden" name="customer-search">
                                <div class="form-group d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                                        <select name="client_id" id="client_id" class="form-control select2" required></select>
                                    </div>
                                    <button class="btn btn-success w-25">{{ __('messages.search') }}</button>
                                </div>
                            @endif
                            @if ($queryString == 'group-search')
                                <input type="hidden" name="group-search">
                                <div class="form-group d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Group">
                                        <select name="group_id" id="group_id" class="form-control select2" required></select>
                                    </div>
                                    <button class="btn btn-success w-25">{{ __('messages.search') }}</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="row row-sm">
                <div class="card">
                    <div class="card-header border-bottom d-lg-flex d-block justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }} {{ request()->starting_date ? '| From ' . request()->starting_date . ' to' : '' }} {{ request()->ending_date ? request()->ending_date : '' }}</p>
                        <div>
                            <a href="{{ route('user.report.sales.sales') }}" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.all') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales') }}?daily-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.daily') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales.customer.wise') }}?customer-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.customer') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales') }}?group-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.client') }} {{ __('messages.group') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ route('user.report.sales.product.wise') }}" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ route('user.report.sales.sales') }}?product-group-search" class="btn btn-secondary mb-1">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.group') }} {{ __('messages.wise') }}
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-1"><i class="fas fa-undo d-inline"></i> {{ __('messages.go_back') }}</a>
                        </div>
                    </div>
                    <div class="card-body bg-white table-responsive">
                        <table id="file-export-datatable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.sl') }}</th>
                                    <th class="date-cell">{{ __('messages.issued_date') }}</th>
                                    <th>{{ __('messages.id_no') }}</th>
                                    <th>{{ __('messages.client') }}</th>
                                    <th>{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.unit') }}</th>
                                    <th>{{ __('messages.quantity') }}</th>
                                    <th>{{ __('messages.price') }}</th>
                                    <th>{{ __('messages.total') }}</th>
                                    <th>{{ __('messages.discount') }}</th>
                                    <th>{{ __('messages.transport_fare') }}</th>
                                    <th>{{ __('messages.return_quantity') }}</th>
                                    <th>{{ __('messages.grand_total') }}</th>
                                    <th>{{ __('messages.receive') . ' ' . __('messages.amount') }}</th>
                                    <th>{{ __('messages.due') . ' ' . __('messages.amount') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('user.client.client-add-modal')
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!} --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select {{ $queryString == 'group-search' ? 'Group' : 'Customer' }}',
                searchInputPlaceholder: 'Search'
            });
            fetchClients();
            fetchClientsGroups();
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
                    'reset'
                ],
                ajax: {
                    url: "{{ url()->current() }}",
                    data: function(d) {
                        d.client_id = "{{ $_GET['client_id'] ?? '' }}";
                        d.group_id = "{{ $_GET['group_id'] ?? '' }}";
                        d.starting_date = "{{ $_GET['starting_date'] ?? '' }}";
                        d.ending_date = "{{ $_GET['ending_date'] ?? '' }}";
                        d.queryString = "{{ $queryString }}";
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
                        data: 'issued_date',
                        name: 'issued_date'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'client_id',
                        name: 'client_id'
                    },
                    {
                        data: 'products',
                        name: 'products'
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
                        data: 'product_price',
                        name: 'product_price'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'transport_fare',
                        name: 'transport_fare'
                    },
                    {
                        data: 'return_quantity',
                        name: 'return_quantity'
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total'
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
            });
        });
    </script>
@endpush
