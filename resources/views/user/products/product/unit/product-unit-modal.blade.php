<div class="modal fade" id="unitProductModal">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.product') }} {{ __('messages.unit') }} {{ __('messages.create') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.unit') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="product-unit-form">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="unit_name" id="unit_name" placeholder="{{ __('messages.unit') }} {{ __('messages.name') }}">
                            <label for="unit_name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.unit') }} {{ __('messages.name') }}</label>
                        </div>
                        <span class="text-danger small" id="unit_name_Error"></span>
                    </div>
                </div>

                <input type="hidden" id="row_id">
                {{-- form field end --}}
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addProductUnit" onclick="addProductUnit();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateProductUnit" onclick="updateProductUnit();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="productUnitModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

        function clearProductUnitField() {
            $('#unit_name').val('');
            $('#unit_name_Error').text('');
            $('#unit_name').removeClass('border-danger');


        }

        $('#product-unit-form').find('input, textarea, select').each(function() {
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
        // add client using ajax
        function addProductUnit() {
            var unit_name = $('#unit_name').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: unit_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.product-unit.store') }}",
                success: function(unit) {
                    clearProductUnitField();

                    $("#unitProductModal").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product Unit added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    fetchProductUnits();
                    // select last inserted data
                    setTimeout(() => {
                        getProductUnitInfo('/get-product-unit', unit.id);
                    }, 500);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#unit_name_Error').text($errors.name);
                        $('#unit_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            });
        }
        // add product using ajax


        // edit product using ajax
        function editUnit(id) {
            var data_id = id;

            var url = '{{ route('user.product-unit.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#unit_name').val(data.name);
                    $('#row_id').val(data.id);
                    $('#voucher_no').text(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#addText').addClass('d-none');
                    $('#addProductUnit').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateProductUnit').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#unitProductModal").modal("show");
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
        function updateProductUnit(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var unit_name = $('#unit_name').val();

            var url = '{{ route('user.product-unit.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: unit_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearProductUnitField();

                    $("#productUnitModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Unit updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#unit_name_Error').text($errors.name);
                        $('#unit_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
