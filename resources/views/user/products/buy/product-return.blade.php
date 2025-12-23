@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <div class="main-content-body">
        <div class="card">
            <div class="card-body">
                <div class="row row-sm">
                    <div class="card">
                        <div class="card-body bg-white table-responsive">
                            <div class="text-end">
                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="card">
                                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                            <p class="card-title my-0">{{ $pageTitle }}</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="d-flex">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.supplier') }}"></i></span>
                                                        <div class="input-group">
                                                            <select name="Supplier" class="form-control select2">
                                                                <option value="1">{{ __('messages.supplier') }}</option>
                                                                <option value="1">01</option>
                                                            </select>
                                                        </div>
                                                        <a data-bs-target="#accountModal" data-bs-toggle="modal" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="d-flex">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.invoice') }}"></i></span>
                                                        <div class="input-group">
                                                            <select name="Invoice" class="form-control select2">
                                                                <option value="1">Invoice ID</option>
                                                                <option value="1">01</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fab fa-product-hunt" title="{{ __('messages.product') }}"></i></span>
                                                        <input type="text" class="form-control" name="name" placeholder="{{ __('messages.product') }} {{ __('messages.name') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text" title="{{ __('messages.image') }}"><i class="fas fa-image" title="{{ __('messages.image') }}"></i></span>
                                                        <input type="file" accept="image/*" name="image" class="form-control image" placeholder="" id="image">
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text" title="{{ __('messages.description') }}"><i class="fas fa-info-circle"></i></span>
                                                        <textarea name="description" class="form-control" id="" cols="5" rows="1" placeholder="{{ __('messages.description') }}"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-dollar-sign" title="BuyingPrice"></i></span>
                                                        <input type="text" class="form-control" name="BuyingPrice" placeholder="{{ __('messages.buying') }} {{ __('messages.price') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-dollar-sign" title="SellingPrice"></i></span>
                                                        <input type="text" class="form-control" name="SellingPrice" placeholder="{{ __('messages.selling') }} {{ __('messages.price') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="d-flex">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.unit') }}"></i></span>
                                                        <div class="input-group">
                                                            <select name="Unit" class="form-control select2">
                                                                <option value="1">Unit</option>
                                                                <option value="1">01</option>
                                                            </select>
                                                        </div>
                                                        <a data-bs-target="#accountModal" data-bs-toggle="modal" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-box" title="{{ __('messages.carton') }}"></i></span>
                                                        <input type="text" class="form-control" name="carton" placeholder="{{ __('messages.carton') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="d-flex">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-layer-group" title="{{ __('messages.group') }}"></i></span>
                                                        <div class="input-group">
                                                            <select name="Group" class="form-control select2">
                                                                <option value="1">Group</option>
                                                                <option value="1">01</option>
                                                            </select>
                                                        </div>
                                                        <a data-bs-target="#accountModal" data-bs-toggle="modal" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-user-shield" title="StockWarningQuantity"></i></span>
                                                        <input type="text" class="form-control" name="StockWarningQuantity" placeholder="{{ __('messages.stock') }} {{ __('messages.warning') }} {{ __('messages.quantity') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3 d-flex justify-content-center">
                                                <a aria-controls="addReceiveCollapse" aria-expanded="false" class="btn ripple btn-dark me-2" data-bs-toggle="collapse" href="#addReceiveCollapse" role="button">{{ __('messages.close') }}</a>
                                                <button type="submit" class="add-to-cart btn btn-primary">{{ __('messages.add') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                        var url = '{{ route('user.product.destroy', ':id') }}';
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
                $('#addReceiveText').removeClass('d-none');
                $('#updateReceiveText').addClass('d-none');
                $('#addProduct').removeClass('d-none');
                $('#updateProduct').addClass('d-none');

                $('#product-form').find('input, textarea, select').each(function() {
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
            $("#productEditBtn").on('click', function() {
                $('#addReceiveText').addClass('d-none');
                $('#updateReceiveText').addClass('d-none');
                $('#updateProduct').removeClass('d-none');
                $('#addProduct').addClass('d-none');
                $('#updateReceive').removeClass('d-none');

                $('#product-form').find('input, textarea, select').each(function() {
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
