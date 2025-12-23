@extends('layouts.admin.app', ['pageTitle' => 'Dashboard'])

@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <h3>{{ $pageTitle }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="yajra-datatable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Backup Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backupLogs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ bnDateFormat($log->created_at) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

            dataTable = $('#yajra-datatable').DataTable({});
        });
    </script>
@endpush
