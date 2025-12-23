@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">{{ __('messages.go_back') }}</a>
                    </div>
                </div>
                <div class="row justify-content-center my-5">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('messages.server_info') }}</h5>
                            <button id="loadDataBtn" class="btn btn-sm btn-primary my-1">{{ __('messages.update') }}</button>
                        </div>
                        <table class="table table-bordered table-hover table-striped" cellpadding="10" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PHP Version</td>
                                    <td id="php_version">0.00</td>
                                </tr>
                                <tr>
                                    <td>Laravel Version</td>
                                    <td id="laravel_version">0.00</td>
                                </tr>
                                <tr>
                                    <td>Total File Size</td>
                                    <td id="total_file_size">0.00</td>
                                </tr>
                                <tr>
                                    <td>Current Memory Usage</td>
                                    <td id="current_memory_usage">0.00</td>
                                </tr>
                                <tr>
                                    <td>Peak Memory Usage</td>
                                    <td id="peak_memory_usage">0.00</td>
                                </tr>
                                <tr>
                                    <td>Bandwidth Usage Today</td>
                                    <td id="bandwidth_today">0.00</td>
                                </tr>
                                <tr>
                                    <td>Bandwidth Usage This Month</td>
                                    <td id="bandwidth_month">0.00</td>
                                </tr>
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
        $(document).ready(function () {
            // Function to fetch and update the data
            function fetchData() {
                $.ajax({
                    url: "{{ url()->current() }}",
                    type: 'GET',
                    success: function (data) {
                        // Update specific table cells by ID
                        $('#php_version').text(data['PHP Version']);
                        $('#laravel_version').text(data['Laravel Version']);
                        $('#total_file_size').text(data['Total File Size']);
                        $('#current_memory_usage').text(data['Current Memory Usage']);
                        $('#peak_memory_usage').text(data['Peak Memory Usage']);
                        $('#bandwidth_today').text(data['Bandwidth Usage Today']);
                        $('#bandwidth_month').text(data['Bandwidth Usage This Month']);
                        toastr.success("Server information updated  Successfully!");
                    },
                    error: function () {
                        alert('Failed to load data.');
                    }
                });
            }

            // Fetch data initially when the page loads
            fetchData();

            // Update data when the button is clicked
            $('#loadDataBtn').click(function () {
                fetchData();
            });
        });
    </script>
@endpush
