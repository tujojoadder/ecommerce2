@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                        <div>
                            <a href="javascript::void(0)" data-bs-toggle="modal" id="clientGroupBtn" data-bs-target="#bannerModal" class="btn btn-success">
                                <i class="fas fa-plus d-inline"></i> {{ __('messages.add') }} {{ __('messages.banner') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
    @include('user.banner.banner-modal')
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}

    <script>
        // Initialize the modal when add button is clicked
        $("#bannerBtn").on('click', function() {
            $('#addText').removeClass('d-none');
            $('#updateText').addClass('d-none');
            $('#addBanner').removeClass('d-none');
            $('#updateBanner').addClass('d-none');
            clearBannerField();
        });
    </script>
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
                    var url = '{{ route('user.banner.destroy', ':id') }}';
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
                                title: 'Banner deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }

        $("#clientGroupBtn").on('click', function() {
            $('#addText').removeClass('d-none');
            $('#updateText').addClass('d-none');
            $('#addClientGroup').removeClass('d-none');
            $('#updateClientGroup').addClass('d-none');

            $('#client-group-form').find('input, textarea, select').each(function() {
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
