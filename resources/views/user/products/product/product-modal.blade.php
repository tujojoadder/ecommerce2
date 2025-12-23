<style>
    /* .select2-container--default {
        z-index: 104000;
    } */
</style>
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModal" aria-hidden="true">
    <div class="modal-dialog modal-lg  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addReceiveText">Add New Product</h6>
                <h6 class="modal-title d-none" id="updateReceiveText">Update Product | Id No: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card-body">
                    <div class="row" id="product-form">
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="product_name" name="name" placeholder="{{ __('messages.product') }} {{ __('messages.name') }}">
                                <label for="product_name" class="animated-label active-label"><i class="fab fa-product-hunt" title="name"></i> Product Name</label>
                            </div>
                            <span class="text-danger small" id="product_name_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_image') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="file" accept="image/*" name="image" class="form-control image" id="image" placeholder="" id="{{ __('messages.image') }}">
                            </div>
                            <span class="text-danger small" id="image_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_description') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input name="description" type="text" class="form-control" id="description" placeholder="{{ __('messages.description') }}">
                                <label for="description" class="animated-label active-label"><i class="fas fa-info-circle"></i> {{ __('messages.description') }}</label>
                            </div>
                            <span class="text-danger small" id="description_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_buying_price') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="number" class="form-control" name="buying_price" id="buying_price" placeholder="{{ __('messages.buying') }} {{ __('messages.price') }}">
                                <label for="buying_price" class="animated-label active-label"><i class="fas fa-dollar-sign" title="{{ __('messages.buying') }} {{ __('messages.price') }}"></i> {{ __('messages.buying') }} {{ __('messages.price') }}</label>
                            </div>
                            <span class="text-danger small" id="buying_price_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_selling_price') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="number" class="form-control" name="selling_price" id="selling_price" placeholder="{{ __('messages.selling') }} {{ __('messages.price') }}">
                                <label for="selling_price" class="animated-label active-label"><i class="fas fa-dollar-sign" title="{{ __('messages.selling') }} {{ __('messages.price') }}"></i> {{ __('messages.selling') }} {{ __('messages.price') }}</label>
                            </div>
                            <span class="text-danger small" id="selling_price_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_wholesale_price') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="number" class="form-control" name="wholesale_price" id="wholesale_price" placeholder="{{ __('messages.wholesale_price') }}">
                                <label for="wholesale_price" class="animated-label active-label"><i class="fas fa-dollar-sign" title="{{ __('messages.wholesale_price') }}"></i> {{ __('messages.wholesale_price') }}</label>
                            </div>
                            <span class="text-danger small" id="wholesale_price_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_unit_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.unit') }}">
                                    <select name="unit_id" class="form-control select2" id="unit_id">
                                    </select>
                                </div>
                                <span class="text-danger small" id="unit_id_Error"></span>
                                <a id="unitModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-lg-4 col-md-4 {{ config('products_color_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.color') }}">
                                    <select name="color_id" class="form-control select2" id="color_id">
                                    </select>
                                </div>
                                <span class="text-danger small" id="color_id_Error"></span>
                                <a id="productColorModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-lg-4 col-md-4 {{ config('products_size_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.size') }}">
                                    <select name="size_id" class="form-control select2" id="size_id">
                                    </select>
                                </div>
                                <span class="text-danger small" id="size_id_Error"></span>
                                <a id="productSizeModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-lg-4 col-md-4 {{ config('products_brand_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.brand') }}">
                                    <select name="brand_id" class="form-control select2" id="brand_id">
                                    </select>
                                </div>
                                <span class="text-danger small" id="brand_id_Error"></span>
                                <a id="productBrandModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_opening_stock') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="number" step="any" class="form-control" name="opening_stock" id="opening_stock" placeholder="{{ __('messages.opening_stock') }}">
                                <label for="opening_stock" class="animated-label active-label"><i class="fas fa-balance-scale" title="{{ __('messages.opening_stock') }}"></i> {{ __('messages.opening_stock') }}</label>
                            </div>
                            <span class="text-danger small" id="opening_stock_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_custom_barcode_no') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="custom_barcode_no" name="custom_barcode_no">
                                <label class="animated-label active-label" for="custom_barcode_no"><i class="fas fa-barcode"></i> {{ __('messages.barcode_number') }}</label>
                                <span class="text-danger small" id="custom_barcode_no_Error"></span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_imei_no') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="imei_no" name="imei_no">
                                <label class="animated-label active-label" for="imei_no"><i class="fas fa-barcode"></i> {{ __('messages.imei_no') }}</label>
                                <span class="text-danger small" id="imei_no_Error"></span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_carton') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="number" class="form-control" name="carton" id="carton" placeholder="{{ __('messages.carton') }}">
                                <label for="carton" class="animated-label active-label"><i class="fas fa-box" title="{{ __('messages.carton') }}"></i> {{ __('messages.carton') }}</label>
                            </div>
                            <span class="text-danger small" id="carton_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_group_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.group') }}">
                                    <select name="group_id" id="group_id" class="form-control select2">
                                    </select>
                                </div>
                                <a id="groupModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="group_Error"></span>
                        </div>
                        @if (config('sidebar.warehouse') == 1)
                            <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_warehouse_id') == 1 ? '' : 'd-none' }} mb-4">
                                <div class="d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.warehouse') }}">
                                        <select name="warehouse_id" id="warehouse_id" class="warehouse_id form-control select2">
                                        </select>
                                    </div>
                                    <a id="warehouseModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                </div>
                                <span class="text-danger small" id="warehouse_id_Error"></span>
                            </div>
                        @endif
                        <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_stock_warning') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input type="number" class="form-control" name="stockWarningQuantity" id="stock_warning" placeholder="{{ __('messages.stock') }} {{ __('messages.warning') }} {{ __('messages.quantity') }}">
                                <label for="stock_warning" class="animated-label active-label"><i class="fas fa-store"></i> {{ __('messages.stock') }} {{ __('messages.warning') }} {{ __('messages.quantity') }}</label>
                            </div>
                            <span class="text-danger small" id="stocking_warning_Error"></span>
                        </div>
                    </div>
                    <input type="hidden" id="row_id">
                    {{-- form field end --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" id="addProduct" onclick="addProduct();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                    <button class="btn btn-info" type="button" id="updateProduct" onclick="updateProduct();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" id="productModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('user.client.group.client-group-modal')
@include('user.products.warehouse.warehouse-modal')
@include('user.products.product.asset.asset-modal')
@include('user.products.product.group.product-group-modal')
@include('user.products.product.unit.product-unit-modal')
@push('scripts')
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        // for asset modal
        $(document).ready(function() {
            $("#productColorModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('color');
            });
            $("#productSizeModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('size');
            });
            $("#productBrandModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('brand');
            });
            $("#unitModalBtn").click(function() {
                $("#unitProductModal").modal("show");
            });
            $("#groupModalBtn").click(function() {
                $("#groupProductModal").modal("show");
            });
            $("#warehouseModalBtn").click(function() {
                $("#warehouseModal").modal("show");
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        // fetch all units
        // function fetchUnits() {
        //     $.ajax({
        //         url: "{{ route('get.product.units') }}",
        //         dataType: 'json',
        //         success: function(data) {
        //             var html = '';
        //             $.each(data, function(index, value) {
        //                 html += '<option value="">Select</option>';
        //                 html += '<option value="' + value.id + '">' + value.name + '</option>';
        //             });
        //             $('#unit_id').html(html);
        //         }
        //     });
        // }

        $(document).ready(function() {
            fetchProductGroups();
            fetchProductsColors();
            fetchProductsSizes();
            fetchProductBrands();
            // fetchUnits();
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

            $('#wholesale_price').val('');
            $('#wholesale_price_Error').text('');
            $('#wholesale_price').removeClass('border-danger');

            $('#unit_id').val('');
            $('#unit_id_Error').text('');
            $('#unit_id').removeClass('border-danger');

            $('#color_id').val('');
            $('#color_id_Error').text('');
            $('#color_id').removeClass('border-danger');

            $('#size_id').val('');
            $('#size_id_Error').text('');
            $('#size_id').removeClass('border-danger');

            $('#brand_id').val('');
            $('#brand_id_Error').text('');
            $('#brand_id').removeClass('border-danger');

            $('#opening_stock').val('');
            $('#opening_stock_Error').text('');
            $('#opening_stock').removeClass('border-danger');

            $('#custom_barcode_no').val('');
            $('#custom_barcode_no_Error').text('');
            $('#custom_barcode_no').removeClass('border-danger');

            $('#imei_no').val('');
            $('#imei_no_Error').text('');
            $('#imei_no').removeClass('border-danger');

            $('#carton').val('');
            $('#carton_Error').text('');
            $('#carton').removeClass('border-danger');

            $('#group_id').val('');
            $('#group_id_Error').text('');
            $('#group_id').removeClass('border-danger');

            $('#stock_warning').val('');
            $('#stock_warning_Error').text('');
            $('#stock_warning').removeClass('border-danger');
        }

        $('#product-form').find('input, textarea, select').each(function() {
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
        function addProduct() {
            var product_name = $('#product_name').val();
            var image = $('#image').val();
            var description = $('#description').val();
            var buying_price = $('#buying_price').val();
            var selling_price = $('#selling_price').val();
            var wholesale_price = $('#wholesale_price').val();
            var unit_id = $('#unit_id').val();
            var color_id = $('#color_id').val();
            var size_id = $('#size_id').val();
            var brand_id = $('#brand_id').val();
            var opening_stock = $('#opening_stock').val();
            var custom_barcode_no = $('#custom_barcode_no').val();
            var imei_no = $('#imei_no').val();
            var carton = $('#carton').val();
            var group_id = $('#addProductModal #group_id').val();
            var stock_warning = $('#stock_warning').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: product_name,
                    image: image,
                    description: description,
                    buying_price: buying_price,
                    selling_price: selling_price,
                    wholesale_price: wholesale_price,
                    unit_id: unit_id,
                    color_id: color_id,
                    size_id: size_id,
                    brand_id: brand_id,
                    opening_stock: opening_stock,
                    custom_barcode_no: custom_barcode_no,
                    imei_no: imei_no,
                    carton: carton,
                    group_id: group_id,
                    stock_warning: stock_warning,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('user.product.store') }}",
                success: function(product) {
                    clearProductField();

                    $("#productModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    getProductInfo("/get-product", product.id);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#name_Error').text($errors.name);
                        $('#name').addClass('border-danger');
                        toastr.error($errors.name);
                    }

                    if ($errors.image) {
                        $('#image_Error').text($errors.image);
                        $('#image').addClass('border-danger');
                        toastr.error($errors.image);
                    }

                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }

                    if ($errors.buying_price) {
                        $('#buying_price_Error').text($errors.buying_price);
                        $('#buying_price').addClass('border-danger');
                        toastr.error($errors.buying_price);
                    }

                    if ($errors.selling_price) {
                        $('#selling_price_Error').text($errors.selling_price);
                        $('#selling_price').addClass('border-danger');
                        toastr.error($errors.selling_price);
                    }

                    if ($errors.unit_id) {
                        $('#unit_id_Error').text($errors.amount);
                        $('#unit_id').addClass('border-danger');
                        toastr.error($errors.unit_id);
                    }

                    if ($errors.opening_stock) {
                        $('#opening_stock_Error').text($errors.unit_id);
                        $('#opening_stock').addClass('border-danger');
                        toastr.error($errors.opening_stock);
                    }

                    if ($errors.custom_barcode_no) {
                        $('#custom_barcode_no_Error').text($errors.unit_id);
                        $('#custom_barcode_no').addClass('border-danger');
                        toastr.error($errors.custom_barcode_no);
                    }

                    if ($errors.imei_no) {
                        $('#imei_no_Error').text($errors.unit_id);
                        $('#imei_no').addClass('border-danger');
                        toastr.error($errors.imei_no);
                    }

                    if ($errors.carton) {
                        $('#carton_Error').text($errors.carton);
                        $('#carton').addClass('border-danger');
                        toastr.error($errors.carton);
                    }

                    if ($errors.group_id) {
                        $('#group_id_Error').text($errors.group_id);
                        $('#group_id').addClass('border-danger');
                        toastr.error($errors.group_id);
                    }

                    if ($errors.warehouse_id) {
                        $('#warehouse_id_Error').text($errors.warehouse_id);
                        $('#warehouse_id').addClass('border-danger');
                        toastr.error($errors.warehouse_id);
                    }

                    if ($errors.stock_warning) {
                        $('#stock_warning_Error').text($errors.stock_warning);
                        $('#stock_warning').addClass('border-danger');
                        toastr.error($errors.stock_warning);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.product.edit', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    // adding the data to fields
                    $('#addProductModal #product_name').val(data.name);
                    $('#addProductModal #row_id').val(data.id);
                    // $('#image').val(data.image).trigger('image');
                    $('#addProductModal #description').val(data.description);
                    $('#addProductModal #buying_price').val(data.buying_price);
                    $('#addProductModal #selling_price').val(data.selling_price);
                    $('#addProductModal #wholesale_price').val(data.wholesale_price);
                    // $('#addProductModal #unit_id').val(data.unit_id).trigger('change');
                    // $('#addProductModal #color_id').val(data.color_id).trigger('change');
                    // $('#addProductModal #size_id').val(data.size_id).trigger('change');
                    // $('#addProductModal #brand_id').val(data.brand_id).trigger('change');

                    setTimeout(() => {
                        getProductGroupInfo('/get-product-group', data.group_id)
                        getProductUnitInfo('/get-product-unit', data.unit_id)
                        getProductColorInfo('/get-product-color', data.color_id)
                        getProductSizeInfo('/get-product-size', data.size_id)
                        getProductBrandInfo('/get-product-brand', data.brand_id)
                    }, 500);

                    $('#addProductModal #opening_stock').val(data.opening_stock);
                    $('#addProductModal #custom_barcode_no').val(data.custom_barcode_no);
                    $('#addProductModal #imei_no').val(data.imei_no);
                    $('#addProductModal #carton').val(data.carton);
                    $('#addProductModal #group_id').val(data.group_id).trigger('change');
                    $('#addProductModal #warehouse_id').val(data.warehouse_id).trigger('change');
                    $('#addProductModal #stock_warning').val(data.stock_warning);
                    // adding the data to fields

                    // // hide show btn
                    $('#addProductModal #addReceiveText').addClass('d-none');
                    $('#addProductModal #updateReceiveText').removeClass('d-none');
                    $('#addProductModal #voucher_no').text(data.id);
                    $('#addProductModal #addProduct').addClass('d-none');
                    $('#addProductModal #updateReceive').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#addProductModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Group_id Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateProduct(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#addProductModal #row_id').val();
            var product_name = $('#addProductModal #product_name').val();
            var image = $('#addProductModal #image')[0].files[0] ?? '';
            var description = $('#addProductModal #description').val();
            var buying_price = $('#addProductModal #buying_price').val();
            var selling_price = $('#addProductModal #selling_price').val();
            var wholesale_price = $('#addProductModal #wholesale_price').val();
            var unit_id = $('#addProductModal #unit_id').val();
            var color_id = $('#addProductModal #color_id').val();
            var size_id = $('#addProductModal #size_id').val();
            var brand_id = $('#addProductModal #brand_id').val();
            var opening_stock = $('#addProductModal #opening_stock').val();
            var custom_barcode_no = $('#addProductModal #custom_barcode_no').val();
            var imei_no = $('#addProductModal #imei_no').val();
            var carton = $('#addProductModal #carton').val();
            var group_id = $('#addProductModal #group_id').val();
            var warehouse_id = $('#addProductModal #warehouse_id').val();
            var stock_warning = $('#addProductModal #stock_warning').val();

            var formData = new FormData();
            formData.append('name', product_name);
            formData.append('image', image);
            formData.append('description', description);
            formData.append('buying_price', buying_price);
            formData.append('selling_price', selling_price);
            formData.append('wholesale_price', wholesale_price);
            formData.append('unit_id', unit_id ?? '');
            formData.append('color_id', color_id ?? '');
            formData.append('size_id', size_id ?? '');
            formData.append('brand_id', brand_id ?? '');
            formData.append('opening_stock', opening_stock);
            formData.append('custom_barcode_no', custom_barcode_no);
            formData.append('imei_no', imei_no);
            formData.append('carton', carton);
            formData.append('group_id', group_id ?? '');
            formData.append('warehouse_id', warehouse_id ?? '');
            formData.append('stock_warning', stock_warning);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            var url = '{{ route('user.product.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "POST", // Use POST method for FormData
                processData: false,
                contentType: false,
                data: formData,
                url: url,
                success: function(data) {
                    clearProductField();
                    $("#productModalClose").click();
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
                    if ($errors.name) {
                        $('#product_name_Error').text($errors.name);
                        $('#product_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }

                    if ($errors.image) {
                        $('#image_Error').text($errors.image);
                        $('#image').addClass('border-danger');
                        toastr.error($errors.image);
                    }

                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }

                    if ($errors.buying_price) {
                        $('#buying_price_Error').text($errors.buying_price);
                        $('#buying_price').addClass('border-danger');
                        toastr.error($errors.buying_price);
                    }

                    if ($errors.selling_price) {
                        $('#selling_price_Error').text($errors.selling_price);
                        $('#selling_price').addClass('border-danger');
                        toastr.error($errors.selling_price);
                    }

                    if ($errors.wholesale_price) {
                        $('#wholesale_price_Error').text($errors.wholesale_price);
                        $('#wholesale_price').addClass('border-danger');
                        toastr.error($errors.wholesale_price);
                    }

                    if ($errors.unit_id) {
                        $('#unit_id_Error').text($errors.amount);
                        $('#unit_id').addClass('border-danger');
                        toastr.error($errors.unit_id);
                    }

                    if ($errors.opening_stock) {
                        $('#opening_stock_Error').text($errors.opening_stock);
                        $('#opening_stock').addClass('border-danger');
                        toastr.error($errors.opening_stock);
                    }

                    if ($errors.custom_barcode_no) {
                        $('#custom_barcode_no_Error').text($errors.custom_barcode_no);
                        $('#custom_barcode_no').addClass('border-danger');
                        toastr.error($errors.custom_barcode_no);
                    }

                    if ($errors.imei_no) {
                        $('#imei_no_Error').text($errors.imei_no);
                        $('#imei_no').addClass('border-danger');
                        toastr.error($errors.imei_no);
                    }

                    if ($errors.carton) {
                        $('#carton_Error').text($errors.carton);
                        $('#carton').addClass('border-danger');
                        toastr.error($errors.carton);
                    }

                    if ($errors.group_id) {
                        $('#group_id_Error').text($errors.group_id);
                        $('#group_id').addClass('border-danger');
                        toastr.error($errors.group_id);
                    }

                    if ($errors.warehouse_id) {
                        $('#warehouse_id_Error').text($errors.warehouse_id);
                        $('#warehouse_id').addClass('border-danger');
                        toastr.error($errors.warehouse_id);
                    }

                    if ($errors.stock_warning) {
                        $('#stock_warning_Error').text($errors.stock_warning);
                        $('#stock_warning').addClass('border-danger');
                        toastr.error($errors.stock_warning);
                    }

                }
            })
        }
        // update data using ajax
    </script>
@endpush
