@php
    $queryString = $_SERVER['QUERY_STRING'];
@endphp
@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        @if ($queryString == 'asset-list')
            @include('user.asset-and-stock.asset-modal')
        @else
            @include('user.asset-and-stock.stock-modal')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row row-sm">
                    <div class="card">
                        <div class="card-body bg-white table-responsive">
                            <div class="text-end">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                                    <a data-bs-toggle="collapse" data-bs-target="{{ $queryString == 'stock-list' ? '#stockCollapse' : '#assetCollapse' }}" aria-expanded="false" aria-controls="{{ $queryString == 'stock-list' ? 'stockCollapse' : 'assetCollapse' }}" href="javascript:;" class="btn btn-success"><i class="fas fa-plus"></i> {{ $queryString == 'stock-list' ? 'Stock Create' : 'Asset Create' }}</a>
                                </div>
                            </div>
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}

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
                    var url = '{{ route('user.asset-and-stock.destroy', ':id') }}';
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

        $("#addAssetOrStockBtn").on('click', function() {
            $('#addText').removeClass('d-none');
            $('#addAsset').removeClass('d-none');
            $('#updateText').addClass('d-none');
            $('#updateAsset').addClass('d-none');

            $('#asset-form').find('input, textarea, select').each(function() {
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
