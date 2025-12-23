@php
    $queryString = $_SERVER['QUERY_STRING'] ?? '';
@endphp
<div class="modal fade" id="assetProductModal" tabindex="-1" aria-labelledby="assetProductModal" aria-hidden="true">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.product') }} {{ __('messages.asset') }} {{ __('messages.create') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.product') }} {{ __('messages.asset') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div id="form-product-brand">
                    <div class="row" id="product-asset-form">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                            <div class="input-group">
                                <span class="input-group-text" title=""><i class="fas fa-bars" title=""></i></span>
                                <input type="hidden" class="form-control" name="asset_type" id="asset_type" value="{{ $queryString }}">
                                <input type="text" class="form-control" name="asset_name" id="asset_name" placeholder="{{ __('messages.brand') }} {{ __('messages.name') }}" data-bs-toggle="tooltip-primary" title="{{ __('messages.brand') }} {{ __('messages.name') }}">
                                <button class="btn btn-success" type="button" id="addProductGroup" onclick="addProductAsset();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                                <button class="btn btn-info d-none" type="button" id="updateProductGroup" onclick="updateProductAsset();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                            </div>
                            <span class="text-danger small" id="asset_name_Error"></span>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="row_id">
                {{-- form field end --}}
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="productAssetModalClose" type="button">{{ __('messages.cancel') }}</button>
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

        function clearProductAssetField() {
            $('#asset_name').val('');
            $('#asset_name_Error').text('');
            $('#asset_name').removeClass('border-danger');


        }

        $('#product-asset-form').find('input, textarea, select').each(function() {
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
        function addProductAsset() {
            var asset = $('#asset_name').val();
            var type = $('#asset_type').val();
            console.log(asset);
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    asset: asset,
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.product-asset.store') }}",
                success: function(group) {
                    clearProductAssetField();

                    $("#productAssetModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                    if (type == 'color') {
                        // fetch updatd list when data is added from another modal
                        fetchProductsColors();
                        // select last inserted data
                        setTimeout(() => {
                            var id = $("#color_id option:last").val();
                            $("#color_id").val(id).trigger('change');
                        }, 1000);
                    }
                    if (type == 'size') {
                        // fetch updatd list when data is added from another modal
                        fetchProductsSizes();
                        // select last inserted data
                        setTimeout(() => {
                            var id = $("#size_id option:last").val();
                            $("#size_id").val(id).trigger('change');
                        }, 1000);
                    }
                    if (type == 'brand') {
                        // fetch updatd list when data is added from another modal
                        fetchProductsBrands();
                        // select last inserted data
                        setTimeout(() => {
                            var id = $("#brand_id option:last").val();
                            $("#brand_id").val(id).trigger('change');
                        }, 1000);
                    }
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.asset) {
                        $('#asset_name_Error').text($errors.asset);
                        $('#asset_name').addClass('border-danger');
                        toastr.error($errors.asset);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.product-asset.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#asset_name').val(data.asset);
                    $('#row_id').val(data.id);

                    // adding the data to fields
                    // // hide show btn

                    $('#addText').addClass('d-none');
                    $('#addProductGroup').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateProductGroup').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#assetProductModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Brand Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateProductAsset(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var asset = $('#asset_name').val();
            var type = 'brand';


            var url = '{{ route('user.product-asset.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    asset: asset,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearProductAssetField();

                    $("#productAssetModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Asset updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.asset) {
                        $('#asset_name_Error').text($errors.asset);
                        $('#asset_name').addClass('border-danger');
                        toastr.error($errors.asset);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
