<div class="modal fade" id="supplierGroupModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new_supplier_group') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.supplier') }} {{ __('messages.group') }} | {{ __('messages.id_no') }}: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="supplier-group-form">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="supplier_group_name" id="supplier_group_name">
                            <label for="supplier_group_name" class="animated-label"><i class="fas fa-layer-group"></i> {{ __('messages.group_name') }}</label>
                        </div>
                        <span class="text-danger small" id="supplier_group_name_Error"></span>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addSupplierGroup" onclick="addSupplierGroup();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateSupplierGroup" onclick="updateSupplierGroup();"><i class="fas fa-plus"></i> {{ __('messages.update') }} {{ __('messages.group') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="supplierGroupModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
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

        function clearSupplierGroupField() {
            $('#supplier_group_name').val('');
            $('#supplier_group_name_Error').text('');
            $('#supplier_group_name').removeClass('border-danger');
        }

        // add client using ajax
        function addSupplierGroup() {
            var supplier_group_name = $('#supplier_group_name').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: supplier_group_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.supplier-group.store') }}",
                success: function(group) {
                    clearSupplierGroupField();

                    $("#supplierGroupModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Supplier Group added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                    // fetch updatd list when data is added from another modal
                    fetchSupplierGroups();
                    setTimeout(() => {
                        getSupplierGroupInfo('/get-supplier-group', group.id)
                    }, 500);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#supplier_group_name_Error').text($errors.name);
                        $('#supplier_group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.supplier-group.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#supplier_group_name').val(data.name);
                    $('#row_id').val(data.id);
                    $('#voucher_id').text(data.id);
                    // adding the data to fields
                    // // hide show btn
                    $('#id_no').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addSupplierGroup').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateSupplierGroup').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#supplierGroupModal").modal("show");
                    // modal show when edit button is clicked

                    setTimeout(() => {
                        $('#supplier_group_name').focus();
                        $('#supplier_group_name').keyup();
                    }, 500);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Supplier Group Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateSupplierGroup(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var supplier_group_name = $('#supplier_group_name').val();


            var url = '{{ route('user.supplier-group.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: supplier_group_name,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearSupplierGroupField();

                    $("#supplierGroupModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Supplier Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#supplier_group_name_Error').text($errors.name);
                        $('#supplier_group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
