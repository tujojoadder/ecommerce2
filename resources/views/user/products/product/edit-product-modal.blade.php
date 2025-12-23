<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModal" aria-hidden="true">
    <div class="modal-dialog modal-lg  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addReceiveText">{{ __('messages.edit') }} {{ __('messages.product') }}</h6>
                <h6 class="modal-title d-none" id="updateReceiveText">{{ __('messages.update') }} {{ __('messages.product') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row" id="product-edit-form">
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Product Name">
                                    <span class="input-group-text"id="basic-addon1"><i class="fab fa-product-hunt" title="name"></i></span>
                                    <input type="text" class="form-control" id="product_name" name="name" placeholder="{{ __('messages.product') }} {{ __('messages.name') }}">
                                </div>
                                <span class="text-danger small" id="product_name_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.image') }}">
                                    <span class="input-group-text" title="Name"><i class="fas fa-image" title="{{ __('messages.image') }}"></i></span>
                                    <input type="file" accept="image/*" name="image" class="form-control image" id="image" placeholder="" id="{{ __('messages.image') }}">
                                </div>

                                <span class="text-danger small" id="image_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.description') }}">
                                    <span class="input-group-text" title="Description"><i class="fas fa-info-circle"></i></span>
                                    <textarea name="description" class="form-control" cols="5" rows="1" id="description" placeholder="{{ __('messages.description') }}"></textarea>
                                </div>
                                <span class="text-danger small" id="description_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.buying') }} {{ __('messages.price') }}">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-dollar-sign" title="{{ __('messages.buying') }} {{ __('messages.price') }}"></i></span>
                                    <input type="number" class="form-control" name="buying_price" id="buying_price" placeholder="{{ __('messages.buying') }} {{ __('messages.price') }}">
                                </div>
                                <span class="text-danger small" id="buying_price_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.selling_price') }}">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-dollar-sign" title="{{ __('messages.selling') }} {{ __('messages.price') }}"></i></span>
                                    <input type="number" class="form-control" name="selling_price" id="selling_price" placeholder="{{ __('messages.selling') }} {{ __('messages.price') }}">
                                </div>
                                <span class="text-danger small" id="selling_price_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="d-flex">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.unit') }}"></i></span>
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.unit') }}">
                                        <select name="unit_id" class="form-control select2" id="unit_id">
                                        </select>
                                    </div>
                                    <span class="text-danger small" id="unit_id_Error"></span>
                                    <a id="unitModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                <div class="d-flex">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-palette"></i></span>
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.color') }}">
                                        <select name="color_id" class="form-control select2" id="color_id">
                                        </select>
                                    </div>
                                    <span class="text-danger small" id="color_id_Error"></span>
                                    <a id="productColorModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                <div class="d-flex">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-ruler-combined"></i></span>
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.size') }}">
                                        <select name="size_id" class="form-control select2" id="size_id">
                                        </select>
                                    </div>
                                    <span class="text-danger small" id="size_id_Error"></span>
                                    <a id="productSizeModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                <div class="d-flex">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-copyright"></i></span>
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.brand') }}">
                                        <select name="brand_id" class="form-control select2" id="brand_id">
                                        </select>
                                    </div>
                                    <span class="text-danger small" id="brand_id_Error"></span>
                                    <a id="productBrandModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.opening_stock') }}">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-balance-scale" title="{{ __('messages.opening_stock') }}"></i></span>
                                    <input type="number" step="any" class="form-control" name="opening_stock" id="opening_stock" placeholder="{{ __('messages.opening_stock') }}">
                                </div>
                                <span class="text-danger small" id="opening_stock_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.carton') }}">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-box" title="{{ __('messages.carton') }}"></i></span>
                                    <input type="number" class="form-control" name="carton" id="carton" placeholder="{{ __('messages.carton') }}">
                                </div>
                                <span class="text-danger small" id="carton_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="d-flex">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-layer-group" title="{{ __('messages.group') }}"></i></span>
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.group') }}">
                                        <select name="group_id" id="group_id" class="form-control select2">
                                        </select>
                                    </div>
                                    <a id="groupModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="group_Error"></span>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.stock') }} {{ __('messages.warning') }} {{ __('messages.quantity') }}">
                                    <span class="input-group-text"id="basic-addon1"><i class="fas fa-store"></i></span>
                                    <input type="number" class="form-control" name="stockWarningQuantity" id="stock_warning" placeholder="{{ __('messages.stock') }} {{ __('messages.warning') }} {{ __('messages.quantity') }}">
                                </div>
                                <span class="text-danger small" id="stocking_warning_Error"></span>
                            </div>
                        </div>
                        {{-- form field end --}}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" id="addProduct" onclick="addProduct();"><i class="fas fa-plus"></i> Add New Product</button>
                        <button class="btn btn-info d-none" type="button" id="updateProduct" onclick="updateProduct();"><i class="fas fa-plus"></i> Update Product</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal" id="productModalClose" type="button"><i class="fas fa-ban"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
                    }
                });

                function clearProductField() {
                    $('#product_name').val('');
                    $('#product_name_Error').text('');
                    $('#product_name').removeClass('border-danger');

                    $('#image').val('');
                    $('#image_Error').text('');
                    $('#image').removeClass('border-danger');

                    $('#description').val('');
                    $('#description_Error').text('');
                    $('#description').removeClass('border-danger');

                    $('#buying_price').val('');
                    $('#buying_price_Error').text('');
                    $('#buying_price').removeClass('border-danger');

                    $('#selling_price').val('');
                    $('#selling_price_Error').text('');
                    $('#selling_price').removeClass('border-danger');

                    $('#unit').val('');
                    $('#unit_Error').text('');
                    $('#unit').removeClass('border-danger');

                    $('#opening_stock').val('');
                    $('#opening_stock_Error').text('');
                    $('#opening_stock').removeClass('border-danger');

                    $('#carton').val('');
                    $('#carton_Error').text('');
                    $('#carton').removeClass('border-danger');

                    $('#group').val('');
                    $('#group_Error').text('');
                    $('#group').removeClass('border-danger');

                    $('#stock_warning').val('');
                    $('#stock_warning_Error').text('');
                    $('#stock_warning').removeClass('border-danger');
                }

                $('#product-edit-form').find('input, textarea, select').each(function() {
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




                // edit product using ajax
                function edit(id) {
                    var data_id = id;
                    var url = '{{ route('user.product.edit', ':id') }}';
                    url = url.replace(':id', data_id);
                    console.log(data_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            // adding the data to fields
                            // $('#name').val(data.name).trigger('name');
                            // $('#image').val(data.image).trigger('image');
                            // $('#description').val(data.description);
                            // $('#buying_price').val(data.buying_price).trigger('change');
                            // $('#selling_price').val(data.selling_price);
                            // $('#unit').val(data.unit);
                            // $('#opening_stock').val(data.opening_stock).trigger('change');
                            // $('#carton').val(data.carton).trigger('change');
                            // $('#group').val(data.group).trigger('change');
                            // $('#stock_warnig').val(data.stock_warnig).trigger('change');

                            // $('#row_id').val(data.id);
                            // adding the data to fields

                            // // hide show btn
                            // $('#addReceiveText').addClass('d-none');
                            // $('#updateReceiveText').removeClass('d-none');
                            // $('#voucher_no').text(data.id);
                            // $('#addReceive').addClass('d-none');
                            // $('#updateReceive').removeClass('d-none');
                            // hide show btn

                            // modal show when edit button is clicked
                            $("#editProductModal").modal("show");
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
                function updateReceive(id) {
                    var receive_id = $('#row_id').val();

                    var client_id = $('#client_id').val();
                    var invoice_id = $('#invoice_id').val();
                    var date = $('#date').val();
                    var account_id = $('#account_id').val();
                    var description = $('#description').val();
                    var amount = $('#amount').val();
                    var project_id = $('#project_id').val();
                    var chart_account_id = $('#chart_account_id').val();
                    var chart_group_id = $('#chart_group_id').val();
                    var category_id = $('#category_id').val();
                    var payment_id = $('#payment_id').val();
                    var bank_id = $('#bank_id').val();
                    var cheque_no = $('#cheque_no').val();
                    var sms = $('#sms').is(":checked");
                    var email = $('#email').is(":checked");

                    var url = '{{ route('user.receive.update', ':id') }}';
                    url = url.replace(':id', receive_id);
                    $.ajax({
                        type: "PUT",
                        dataType: "json",
                        data: {
                            client_id: client_id,
                            invoice_id: invoice_id,
                            date: date,
                            account_id: account_id,
                            description: description,
                            amount: amount,
                            project_id: project_id,
                            chart_account_id: chart_account_id,
                            chart_group_id: chart_group_id,
                            category_id: category_id,
                            payment_id: payment_id,
                            bank_id: bank_id,
                            cheque_no: cheque_no,
                            sms: sms,
                            email: email,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: url,
                        success: function(group) {
                            clearReceiveField();

                            $("#receiveModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Receive updated successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;
                            if ($errors.client_id) {
                                $('#client_id_Error').text($errors.client_id);
                                $('#client_id').addClass('border-danger');
                                toastr.error($errors.client_id);
                            }

                            if ($errors.invoice_id) {
                                $('#invoice_id_Error').text($errors.invoice_id);
                                $('#invoice_id').addClass('border-danger');
                                toastr.error($errors.invoice_id);
                            }

                            if ($errors.date) {
                                $('#date_Error').text($errors.date);
                                $('#date').addClass('border-danger');
                                toastr.error($errors.date);
                            }

                            if ($errors.account_id) {
                                $('#account_id_Error').text($errors.account_id);
                                $('#account_id').addClass('border-danger');
                                toastr.error($errors.account_id);
                            }

                            if ($errors.description) {
                                $('#description_Error').text($errors.description);
                                $('#description').addClass('border-danger');
                                toastr.error($errors.description);
                            }

                            if ($errors.amount) {
                                $('#amount_Error').text($errors.amount);
                                $('#amount').addClass('border-danger');
                                toastr.error($errors.amount);
                            }

                            if ($errors.project_id) {
                                $('#project_id_Error').text($errors.project_id);
                                $('#project_id').addClass('border-danger');
                                toastr.error($errors.project_id);
                            }

                            if ($errors.chart_account_id) {
                                $('#chart_account_id_Error').text($errors.chart_account_id);
                                $('#chart_account_id').addClass('border-danger');
                                toastr.error($errors.chart_account_id);
                            }

                            if ($errors.chart_group_id) {
                                $('#chart_group_id_Error').text($errors.chart_group_id);
                                $('#chart_group_id').addClass('border-danger');
                                toastr.error($errors.chart_group_id);
                            }

                            if ($errors.category_id) {
                                $('#category_id_Error').text($errors.category_id);
                                $('#category_id').addClass('border-danger');
                                toastr.error($errors.category_id);
                            }

                            if ($errors.payment_id) {
                                $('#payment_id_Error').text($errors.payment_id);
                                $('#payment_id').addClass('border-danger');
                                toastr.error($errors.payment_id);
                            }

                            if ($errors.bank_id) {
                                $('#bank_id_Error').text($errors.bank_id);
                                $('#bank_id').addClass('border-danger');
                                toastr.error($errors.bank_id);
                            }

                            if ($errors.cheque_no) {
                                $('#cheque_no_Error').text($errors.cheque_no);
                                $('#cheque_no').addClass('border-danger');
                                toastr.error($errors.cheque_no);
                            }

                            if ($errors.status) {
                                $('#status_Error').text($errors.status);
                                $('#status').addClass('border-danger');
                                toastr.error($errors.status);
                            }

                            if ($errors.sms) {
                                $('#sms_Error').text($errors.sms);
                                $('#sms').addClass('border-danger');
                                toastr.error($errors.sms);
                            }

                            if ($errors.email) {
                                $('#email_Error').text($errors.email);
                                $('#email').addClass('border-danger');
                                toastr.error($errors.email);
                            }
                        }
                    })
                }
                // update data using ajax
            </script>
        @endpush
