@extends('layouts.admin.app', ['pageTitle' => $pageTitle])
<style>
    #file-export-datatable_wrapper .dt-buttons {
        position: relative !important;
    }

    .country-table .table th,
    .table td {
        padding: 0px 5px !important;
    }
</style>
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body">
                <div class="row row-sm">
                    <div class="card">
                        <div class="card-body bg-white table-responsive">
                            <div class="text-end">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                                    <div>
                                        <a data-bs-toggle="modal" data-bs-target="#languageModal" href="javascript:;" class="btn btn-success languageModal"><i class="fas fa-plus d-inline"></i> Add Language</a>
                                    </div>
                                </div>
                            </div>
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.language.language-modal')
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
                    var url = '{{ route('admin.lang.destroy', ':id') }}';
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
                                title: 'Language deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        $(".languageModal").on('click', function() {
            $('#addText').removeClass('d-none');
            $('#updateText').addClass('d-none');
            $('#addClientGroup').removeClass('d-none');
            $('#updateClientGroup').addClass('d-none');
        });
    </script>
@endpush
