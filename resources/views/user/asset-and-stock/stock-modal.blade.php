<style>
    .select2-container {
        z-index: 222222 !important;
    }
</style>
<div class="collapse collapse-vertical {{ $queryString == 'create' ? 'show' : '' }}" id="stockCollapse">
    <div class="card">
        <div class="card-header">
            <h6 class="modal-title" id="addText">{{ __('messages.stock') }} {{ __('messages.create') }}</h6>
            <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.stock') }}</h6>
        </div>
        <div class="card-body">
            <div class="row" id="asset-form">
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="d-flex">
                        <span class="input-group-text"id="basic-addon1"><i class="fas fa-layer-group"></i></span>
                        <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.type') }}">
                            <select name="type"class="form-control select2" id="asset_type">
                                <option value=""> {{ __('messages.select') }} {{ __('messages.type') }}</option>
                                <option value="deposit"> {{ __('messages.deposit') }}</option>
                                <option value="Purchase"> {{ __('messages.purchase') }}</option>
                            </select>
                        </div>
                    </div>
                    <span class="text-danger small" id="type_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.date') }}">
                        <span class="input-group-text" title="Date"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                        <input class="form-control fc-datepicker" name="date" placeholder="MM/DD/YYYY" type="text" autocomplete="off" id="date">
                    </div>
                    <span class="text-danger small" id="date_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="d-flex">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-tie" title="{{ __('messages.supplier') }}"></i></span>
                        <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                            <select name="supplier_id" class="form-control select2" id="supplier_id">

                            </select>
                        </div>
                    </div>
                    <span class="text-danger small" id="supplier_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="d-flex">
                        <span class="input-group-text" id="basic-addon1"><i class="fab fa-product-hunt" title="{{ __('messages.supplier') }}"></i></span>
                        <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.product') }}">
                            <select name="product_id" class="form-control select2" id="product_id">

                            </select>
                        </div>
                        <a data-bs-target="#accountModal" data-bs-toggle="modal" class="add-to-cart btn btn-success d-flex text-aligns-center" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger small" id="product_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.quantity') }}">
                        <span class="input-group-text" title="quantity" id="basic-addon1"><i class="fas fa-bars" title="{{ __('messages.quantity') }}"></i></span>
                        <input type="text" class="form-control" name="quantity" placeholder="{{ __('messages.quantity') }}" id="quantity">
                    </div>
                    <span class="text-danger small" id="quantity_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.price') }}">
                        <span class="input-group-text" title="rate" id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.rate') }}"></i></span>
                        <input type="text" class="form-control" name="rate" placeholder="{{ __('messages.price') }}" id="rate">
                    </div>
                    <span class="text-danger small" id="rate_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.amount') }}">
                        <span class="input-group-text" title="amount" id="basic-addon1"><i class="fas fa-balance-scale"></i></span>
                        <input type="text" readonly class="form-control" name="amount" placeholder="{{ __('messages.total') }} {{ __('messages.amount') }}" id="total_amount">
                    </div>
                    <span class="text-danger small" id="total_amount_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.id_no') }}">
                        <span class="input-group-text" title="voucher" id="basic-addon1"><i class="fas fa-file-invoice" title="{{ __('messages.id_no') }}"></i></span>
                        <input type="text" class="form-control" name="voucher_no" placeholder="{{ __('messages.id_no') }}" id="voucher_no">
                    </div>
                    <span class="text-danger small" id="voucher_no_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.id_no') }}">
                        <span class="input-group-text" title="id_no" id="basic-addon1"><i class="fas fa-sort-numeric-up" title="id_no"></i></span>
                        <input type="text" class="form-control" name="id_no" placeholder="{{ __('messages.id_no') }}" id="id_no">
                    </div>
                    <span class="text-danger small" id="id_no_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6">
                    <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.description') }}">
                        <span class="input-group-text" title="Description"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                        <textarea name="description" class="form-control" id="description" cols="5" rows="1" placeholder="{{ __('messages.description') }}"></textarea>
                    </div>
                    <span class="text-danger small" id="description_Error"></span>
                </div>
            </div>
            <input type="hidden" name="" id="row_id">
            <div class="card-footer d-flex justify-content-between px-0">
                <button class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#stockCollapse" aria-expanded="false" aria-controls="stockCollapse" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
                <button class="btn btn-success" type="button" id="addAsset" onclick="addAsset();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateAsset" onclick="updateAsset();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        $(document).ready(function() {
            $('#quantity, #rate').on('input', function() {
                calculateSum();
            });

            function calculateSum() {
                var input1Value = parseFloat($('#quantity').val()) || 0;
                var input2Value = parseFloat($('#rate').val()) || 0;
                var sum = input1Value * input2Value;
                $('#total_amount').val(sum);
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        //supplier information
        function fetchSuppliers() {
            $.ajax({
                url: "{{ route('get.suppliers') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.supplier_name + '</option>';
                    });
                    $('#supplier_id').html(html);
                }
            });
        }

        //Product Information
        function fetchProducts() {
            $.ajax({
                url: "{{ route('get.products') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#product_id').html(html);

                }
            });
        }
        //Product Information

        $(document).ready(function() {
            fetchSuppliers();
            fetchProducts();
        });

        function clearAssetField() {

            $('#asset_type').val('');
            $('#asset_type_Error').text('');
            $('#asset_type').removeClass('border-danger');

            $('#date').val('');
            $('#date_Error').text('');
            $('#date').removeClass('border-danger');

            $('#supplier_id').val('');
            $('#supplier_id_Error').text('');
            $('#supplier_id').removeClass('border-danger');

            $('#product_id').val('');
            $('#product_id_Error').text('');
            $('#product_id').removeClass('border-danger');

            $('#quantity').val('');
            $('#quantity_Error').text('');
            $('#quantity').removeClass('border-danger');

            $('#rate').val('');
            $('#rate_Error').text('');
            $('#rate').removeClass('border-danger');

            $('#total_amount').val('');
            $('#total_amount_Error').text('');
            $('#total_amount').removeClass('border-danger');

            $('#id_no').val('');
            $('#id_no_Error').text('');
            $('#id_no').removeClass('border-danger');

            $('#description').val('');
            $('#description_Error').text('');
            $('#description').removeClass('border-danger');


        }

        $('#asset-form').find('input, textarea, select').each(function() {
            var id = this.id;
            $("#" + id + "").on('keyup', function() {
                var length = $("#" + id + "").val().length;
                if (length < 1) {
                    $('#' + id + '').addClass('border-danger');
                    $('#' + id + '_Error').text('Fill the input');
                } else {
                    $('#' + id + '').removeClass('border-danger');
                    $('#' + id + '_Error').text('');
                }
            });
        });

        // getting all input field id
        // $('#receive-form').find('input, textarea, select').each(function() {
        //     var id = this.id;
        //     $('#' + id + '').val('');
        //     $('#' + id + '_Error').text('Fill the input first');
        //     $('#' + id + '').addClass('border-danger');
        // });

        // add client using ajax
        function addAsset() {
            var asset_type = $('#asset_type').val();
            var date = $('#date').val();
            var supplier_id = $('#supplier_id').val();
            var product_id = $('#product_id').val();
            var unit = $('#unit').val();
            var quantity = $('#quantity').val();
            var rate = $('#rate').val();
            var total_amount = $('#total_amount').val();
            var voucher_no = $('#voucher_no').val();
            var id_no = $('#id_no').val();
            var description = $('#description').val();
            var type = "stock";



            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    asset_type: asset_type,
                    date: date,
                    supplier_id: supplier_id,
                    product_id: product_id,
                    unit: unit,
                    quantity: quantity,
                    rate: rate,
                    total_amount: total_amount,
                    voucher_no: voucher_no,
                    id_no: id_no,
                    description: description,
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.asset-and-stock.store') }}",
                success: function(group) {
                    clearAssetField();

                    $("#AssetModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Asset And Stock added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.asset_type) {
                        $('#asset_type_Error').text($errors.asset_type);
                        $('#asset_type').addClass('border-danger');
                        toastr.error($errors.asset_type);
                    }

                    if ($errors.date) {
                        $('#date_Error').text($errors.date);
                        $('#date').addClass('border-danger');
                        toastr.error($errors.date);
                    }

                    if ($errors.supplier_id) {
                        $('#supplier_id_Error').text($errors.supplier_id);
                        $('#supplier_id').addClass('border-danger');
                        toastr.error($errors.supplier_id);
                    }

                    if ($errors.product_id) {
                        $('#product_id_Error').text($errors.product_id);
                        $('#product_id').addClass('border-danger');
                        toastr.error($errors.product_id);
                    }

                    if ($errors.unit) {
                        $('#unit_Error').text($errors.unit);
                        $('#unit').addClass('border-danger');
                        toastr.error($errors.unit);
                    }

                    if ($errors.quantity) {
                        $('#quantity_Error').text($errors.quantity);
                        $('#quantity').addClass('border-danger');
                        toastr.error($errors.quantity);
                    }

                    if ($errors.rate) {
                        $('#rate_Error').text($errors.rate);
                        $('#rate').addClass('border-danger');
                        toastr.error($errors.rate);
                    }

                    if ($errors.total_amount) {
                        $('#total_amount_Error').text($errors.total_amount);
                        $('#total_amount').addClass('border-danger');
                        toastr.error($errors.total_amount);
                    }

                    if ($errors.voucher_no) {
                        $('#voucher_no_Error').text($errors.voucher_no);
                        $('#voucher_no').addClass('border-danger');
                        toastr.error($errors.voucher_no);
                    }

                    if ($errors.id_no) {
                        $('#id_no_Error').text($errors.id_no);
                        $('#id_no').addClass('border-danger');
                        toastr.error($errors.id_no);
                    }

                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }




                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = "{{ route('user.asset-and-stock.edit', ':id') }}";
            url = url.replace(':id', data_id);
            clearAssetField();


            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#asset_type').val(data.asset_type).trigger('change');
                    $('#date').val(data.date);
                    $('#supplier_id').val(data.supplier_id).trigger('change');
                    $('#product_id').val(data.product_id).trigger('change');
                    $('#quantity').val(data.quantity);
                    $('#rate').val(data.rate);
                    $('#total_amount').val(data.total_amount);
                    $('#voucher_no').val(data.voucher_no);
                    $('#id_no').val(data.id_no);
                    $('#description').val(data.description);

                    $('#row_id').val(data.id);
                    // adding the data to fields

                    $('#addAsset').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateAsset').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#stockCollapse").click();
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Group Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateAsset(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var asset_type = $('#asset_type').val();
            var date = $('#date').val();
            var supplier_id = $('#supplier_id').val();
            var product_id = $('#product_id').val();
            var quantity = $('#quantity').val();
            var rate = $('#rate').val();
            var total_amount = $('#total_amount').val();
            var voucher_no = $('#voucher_no').val();
            var id_no = $('#id_no').val();
            var description = $('#description').val();
            var type = "stock";

            var url = "{{ route('user.asset-and-stock.update', ':id') }}";
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    asset_type: asset_type,
                    date: date,
                    supplier_id: supplier_id,
                    product_id: product_id,
                    quantity: quantity,
                    rate: rate,
                    total_amount: total_amount,
                    voucher_no: voucher_no,
                    id_no: id_no,
                    description: description,
                    type: type,


                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearAssetField();

                    $("#addStockModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Stock updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.asset_type) {
                        $('#asset_type_Error').text($errors.asset_type);
                        $('#asset_type').addClass('border-danger');
                        toastr.error($errors.asset_type);
                    }

                    if ($errors.date) {
                        $('#date_Error').text($errors.date);
                        $('#date').addClass('border-danger');
                        toastr.error($errors.date);
                    }

                    if ($errors.supplier_id) {
                        $('#supplier_id_Error').text($errors.supplier_id);
                        $('#supplier_id').addClass('border-danger');
                        toastr.error($errors.supplier_id);
                    }

                    if ($errors.product_id) {
                        $('#product_id_Error').text($errors.product_id);
                        $('#product_id').addClass('border-danger');
                        toastr.error($errors.product_id);
                    }


                    if ($errors.quantity) {
                        $('#quantity_Error').text($errors.quantity);
                        $('#quantity').addClass('border-danger');
                        toastr.error($errors.quantity);
                    }

                    if ($errors.rate) {
                        $('#rate_Error').text($errors.rate);
                        $('#rate').addClass('border-danger');
                        toastr.error($errors.rate);
                    }

                    if ($errors.total_amount) {
                        $('#total_amount_Error').text($errors.total_amount);
                        $('#total_amount').addClass('border-danger');
                        toastr.error($errors.total_amount);
                    }


                    if ($errors.voucher_no) {
                        $('#voucher_no_Error').text($errors.voucher_no);
                        $('#voucher_no').addClass('border-danger');
                        toastr.error($errors.voucher_no);
                    }

                    if ($errors.id_no) {
                        $('#id_no_Error').text($errors.id_no);
                        $('#id_no').addClass('border-danger');
                        toastr.error($errors.id_no);
                    }

                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
