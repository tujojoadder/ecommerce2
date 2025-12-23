<div class="modal fade" id="groupProductModal">
    <div class="modal-dialog modal-md  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.product') }} {{ __('messages.group') }} {{ __('messages.create') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.product') }} {{ __('messages.group') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="product-group-form">
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto">
                        <div class="form-group">
                            <input type="text" class="form-control" name="group_name" id="group_name">
                            <label class="animated-label" for="group_name"><i class="fas fa-balance-scale"></i> {{ __('messages.group') }} {{ __('messages.name') }}</label>
                        </div>
                        <span class="text-danger small" id="group_name_Error"></span>
                    </div>
                </div>

                <input type="hidden" id="row_id">
                {{-- form field end --}}
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addProductGroup" onclick="addProductGroup();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateProductGroup" onclick="updateProductGroup();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="productGroupModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

        function clearProductGroupField() {
            $('#group_name').val('');
            $('#group_name_Error').text('');
            $('#group_name').removeClass('border-danger');


        }

        $('#product-group-form').find('input, textarea, select').each(function() {
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
        function addProductGroup() {
            var group_name = $('#group_name').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: group_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.product-group.store') }}",
                success: function(group) {
                    clearProductGroupField();

                    $("#productGroupModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    fetchProductGroups();
                    // select last inserted data
                    setTimeout(() => {
                        getProductGroupInfo('/get-product-group', group.id);
                    }, 500);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#group_name_Error').text($errors.name);
                        $('#group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.product-group.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#group_name').val(data.name);
                    $('#row_id').val(data.id);
                    $('#voucher_id').text(data.id);
                    // adding the data to fields
                    // // hide show btn
                    $('#voucher_no').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addProductGroup').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateProductGroup').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#groupProductModal").modal("show");
                    // modal show when edit button is clicked
                    setTimeout(() => {
                        $('#group_name').focus();
                    }, 500);
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
        function updateProductGroup(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var group_name = $('#group_name').val();


            var url = '{{ route('user.product-group.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: group_name,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearProductGroupField();

                    $("#productGroupModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#group_name_Error').text($errors.name);
                        $('#group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
