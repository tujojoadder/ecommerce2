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
                    <p class="display-6 text-center">{{ __('New Company Information') }}</p>
                    <form action="{{ route('user.account.store') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <p class="card-title my-0">{{ $pageTitle }}</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name">
                                            <label for="companyName" class="animated-label"><i class="fas fa-building" title="Company Name"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="companyType" id="companyType" placeholder="Company Type">
                                            <label for="companyType" class="animated-label"><i class="fas fa-newspaper" title="Company Type"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="file" accept="image/*" name="image1" id="image1" class="form-control image" placeholder="" id="image">
                                            <label for="image1" class="animated-label"><i class="fas fa-camera" title="Image"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="file" accept="image/*" name="image2" id="image2" class="form-control image" placeholder="" id="image">
                                            <label for="image2" class="animated-label"><i class="fas fa-image" title="Image"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="file" accept="image/*" name="image3" id="image3" class="form-control image" placeholder="" id="image">
                                            <label for="image3" class="animated-label"><i class="fas fa-image" title="Image"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <div class="input-group">
                                                <select name="customer" class="form-control select2">
                                                    <option value="bangladesh"> Bangladesh</option>
                                                    <option value="no_result_found">No results Found</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Address Line 1">
                                            <label for="address" class="animated-label"><i class="fas fa-map-marker" title="Address"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Address Line 2">
                                            <label for="address" class="animated-label"><i class="fas fa-map-marker" title="Address"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
                                            <label for="email" class="animated-label"><i class="fas fa-envelope-open" title="Email"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone">
                                            <label for="phone" class="animated-label"><i class="fas fa-mobile-alt" title="Phone"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="city" id="city" placeholder="City">
                                            <label for="city" class="animated-label"><i class="fas fa-city" title="City"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="state" id="state" placeholder="State">
                                            <label for="state" class="animated-label"><i class="fas fa-building" title="State"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="PostCode" id="PostCode" placeholder="Post Code">
                                            <label for="PostCode" class="animated-label"><i class="fas fa-university" title="PostCode"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="StockWarning" id="StockWarning" placeholder="Stock Warning">
                                            <label for="StockWarning" class="animated-label"><i class="fas fa-cart-plus" title="StockWarning"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="CurrencySymbol" id="CurrencySymbol" placeholder="Currency Symbol">
                                            <label for="CurrencySymbol" class="animated-label"><i class="fas fa-coins" title="CurrencySymbol"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="SMSApiCode" id="SMSApiCode" placeholder="SMS Api Code smsapibd.com">
                                            <label for="SMSApiCode" class="animated-label"><i class="fas fa-building" title="SMSApiCode"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="SMSApiSenderId" id="SMSApiSenderId" placeholder="SMS Sender ID smsapibd.com">
                                            <label for="SMSApiSenderId" class="animated-label"><i class="fas fa-building" title="SMSApiSenderId"></i> {{ __('messages.') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <div class="input-group">
                                                <select name="account_id" class="form-control select2">
                                                    <option label="Choose Account">smsapibd.com</option>
                                                    <option value="islam">BD SMS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="d-flex">
                                            <div class="input-group">
                                                <select name="account_id" class="form-control select2">
                                                    <option label="on">On</option>
                                                    <option value="off">Off</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3 d-flex justify-content-center">
                                        <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-dark me-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button">Close</a>
                                        <button type="submit" class="add-to-cart btn btn-primary">Add New Company Information</button>
                                    </div>

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
                                    <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-success mb-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button">Receive</a>
                                </div>
                            </div>
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.accounts.receive.client-add-modal')
    @include('user.accounts.account.account-modal')
    @include('user.accounts.receive.income-category-modal')
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
