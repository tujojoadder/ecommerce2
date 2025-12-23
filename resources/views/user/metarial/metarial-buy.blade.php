
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
                <div class="collapse mg-t-5" id="addReceiveCollapse">
                    <p class="display-6 text-center">{{ __('messages.metarial') }} {{ __('messages.purchase') }}</p>
                    <form action="{{ route('user.account.store') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <p class="card-title my-0">{{ $pageTitle }}</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="challan_no" id="basic-addon1"><i class="fas fa-file-invoice" title="{{ __('messages.challan_no') }}"></i></span>
                                            <input type="text" class="form-control" name="challan_no" placeholder="{{ __('messages.challan_no') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" title="{{ __('messages.date') }}"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                                            <input class="form-control fc-datepicker" name="date" placeholder="MM/DD/YYYY" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="{{ __('messages.supplier') }}" id="basic-addon1"><i class="fas fa-user-tie" title="{{ __('messages.supplier') }}"></i></span>
                                            <div class="input-group">
                                                <select name="Supplier_id" class="form-control select2">
                                                    <option label="Choose Account">{{ __('messages.select') }} {{ __('messages.supplier') }}</option>
                                                    <option value="islam">Islami Bank</option>
                                                    <option value="islam">Mostafizur Rahman</option>
                                                    <option value="islam">Mostafizur Rahman</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <span class="input-group-text" title="{{ __('messages.metarial')  }} {{ __('messages.name') }}" id="basic-addon1"><i class="fas fa-user-tie" title="metarial_name"></i></span>
                                            <div class="input-group">
                                                <select name="metarial_id" class="form-control select2">
                                                    <option label="Choose Account">Metarial Name</option>
                                                    <option value="islam">Mostafizur Rahman</option>
                                                    <option value="islam">Mostafizur Rahman</option>
                                                </select>
                                            </div>
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

                <div class="row row-sm">
                    <div class="card">
                        <div class="card-body bg-white table-responsive">
                            <div class="text-end">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-center h3 font-weight-light">{{ $pageTitle }}</p>
                                    <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-success mb-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button">{{ __('messages.receive') }}</a>
                                </div>
                            </div>
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
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
    {!! $dataTable->scripts() !!}

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
