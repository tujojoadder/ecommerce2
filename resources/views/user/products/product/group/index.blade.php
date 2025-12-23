@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="text-end">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center h3 mb-0 font-weight-light">{{ $pageTitle }}</p>
                        <a data-bs-toggle="modal" id="productBtn" data-bs-target="#groupProductModal" href="javascript:;" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('messages.group') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white table-responsive">
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
    @include('user.products.product.group.product-group-modal')
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
                    var url = '{{ route('user.product-group.destroy', ':id') }}';
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

        $("#productBtn").on('click', function() {
            $('#addproductGroupText').removeClass('d-none');
            $('#updateReceiveText').addClass('d-none');
            $('#addProductGroup').removeClass('d-none');
            $('#updateProductGroup').addClass('d-none');

            $('#product-group-form').find('input, textarea, select').each(function() {
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
