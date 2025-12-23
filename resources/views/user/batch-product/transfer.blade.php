
@extends('layouts.user.app', ['pageTitle' => $pageTitle])
<style>
    #file-export-datatable_wrapper .dt-buttons {
        position: relative !important;
    }
</style>
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body">
                <div class=" mg-t-5" id="">
                    <p class="display-6 text-center">{{ __('messages.transfer') }}</p>
                    <form action="{{ route('user.account.store') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <p class="card-title my-0">{{ $pageTitle }}</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-university" title="{{ __('messages.metarial') }}"></i></span>
                                            <div class="input-group">
                                                <select name="RawMetarial" class="form-control select2">
                                                    <option value="1">Febric 1</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-university" title="{{ __('messages.product') }}"></i></span>
                                            <div class="input-group">
                                                <select name="ProductName" class="form-control select2">
                                                    <option value="1">Batch Product Transfer</option>
                                                    <option value="1">01</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-university" title="{{ __('messages.product') }}"></i></span>
                                            <div class="input-group">
                                                <select name="ProductName" class="form-control select2">
                                                    <option value="1">Batch Product Name</option>
                                                    <option value="1">01</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-bars" title="{{ __('messages.transfer') }} {{ __('messages.cotton') }}"></i></span>
                                            <input type="text" class="form-control" name="TransferCotton" placeholder="{{ __('messages.transfer') }} {{ __('messages.cotton') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-bars" title="{{ __('messages.quantity') }}"></i></span>
                                            <input type="text" class="form-control" name="TransferQuantity" placeholder="{{ __('messages.transfer') }} {{ __('messages.quantity') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-bars" title="Price"></i></span>
                                            <input type="text" class="form-control" name="FinishJob" placeholder="{{ __('messages.finish') }} {{ __('messages.job') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-bars" title="FinishJob"></i></span>
                                            <input type="text" class="form-control" name="Price" placeholder="{{ __('messages.price') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"id="basic-addon1"><i class="fas fa-bars" title="{{ __('messages.note') }}"></i></span>
                                            <input type="text" class="form-control" name="Note" placeholder="{{ __('messages.note') }}">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3 d-flex justify-content-center">
                                        <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-dark me-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button">{{ __('messages.close') }}</a>
                                        <button type="submit" class="add-to-cart btn btn-primary">{{ __('messages.add') }}</button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('user.accounts.receive.client-add-modal')
    @include('user.accounts.account.account-modal')
    @include('user.accounts.receive.income-category-modal') --}}
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {{-- {!! $dataTable->scripts() !!} --}}

    <script>
        function destroy(id) {
            console.log(id);
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
                    var url = '{{ route('user.staff.destroy', ':id') }}';
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
                                title: 'Payment deleted successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            })
        }
    </script>
@endpush
