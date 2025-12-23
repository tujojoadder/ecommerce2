@extends('layouts.user.app', ['pageTitle' => 'Dashboard'])

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
                            <th>{{ __('messages.sl') }}</th>
                            <th>{{ __('messages.backup') }} {{ __('messages.date') }}</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backupLogs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d M Y - h:i A', strtotime($log->created_at)) }}</td>
                                <td>
                                    {{ $log->file }}
                                    @if ($loop->first)
                                        <span class="badge bg-success">Latest</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/backups/' . $log->file) }}" download class="btn btn-sm btn-success my-1"><i class="fas fa-download"></i> {{ __('messages.download') }}</a>
                                </td>
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
