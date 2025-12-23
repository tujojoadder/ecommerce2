    <div class="modal fade" id="warehouseModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  " role="document" id="department-form">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="addText">{{ __('messages.warehouse') }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" placeholder="{{ __('messages.name') }}">
                                <label class="animated-label" for="warehouse_name"><i class="fas fa-layer-group"></i> {{ __('messages.name') }}</label>
                            </div>
                            <span class="text-danger small" id="warehouse_name_Error"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="warehouse_address" name="warehouse_address" placeholder="{{ __('messages.address') }}">
                                <label class="animated-label" for="warehouse_address"><i class="fas fa-layer-group"></i> {{ __('messages.address') }}</label>
                            </div>
                            <span class="text-danger small" id="warehouse_address_Error"></span>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" id="warehouse_phone" name="warehouse_phone" placeholder="{{ __('messages.phone') }}">
                                <label class="animated-label" for="warehouse_phone"><i class="fas fa-layer-group"></i> {{ __('messages.phone') }}</label>
                            </div>
                            <span class="text-danger small" id="warehouse_phone_Error"></span>
                        </div>
                        <input type="hidden" id="row_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" id="addWarehouse" type="button" onclick="addWarehouse()"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                    <button class="btn ripple btn-primary d-none" id="updateWarehouse" type="button" onclick="updateWarehouse()"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="warehouseModalClose"><i class="fas fa-ban"></i> {{ __('messages.close') }}</button>
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

            function clearWarehouseField() {
                $('#warehouse_name').val('');
                $('#warehouse_name_Error').text('');
                $('#warehouse_name').removeClass('border-danger');

                $('#warehouse_address').val('');
                $('#warehouse_address_Error').text('');
                $('#warehouse_address').removeClass('border-danger');

                $('#warehouse_phone').val('');
                $('#warehouse_phone_Error').text('');
                $('#warehouse_phone').removeClass('border-danger');
            }

            // add client using ajax
            function addWarehouse() {
                var name = $('#warehouse_name').val();
                var address = $('#warehouse_address').val();
                var phone = $('#warehouse_phone').val();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        name: name,
                        address: address,
                        phone: phone,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('user.warehouse.store') }}",
                    success: function(group) {
                        clearWarehouseField();

                        $("#warehouseModalClose").click();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Warehouse added successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#file-export-datatable').DataTable().ajax.reload();
                        fetchWarehouses();
                        // select last inserted data
                        setTimeout(() => {
                            var id = $("#warehouse_id option:last").val();
                            $("#warehouse_id").val(id).trigger('change');
                        }, 1000);
                    },
                    error: function(error) {
                        var $errors = error.responseJSON.errors;

                        if ($errors.name) {
                            $('#warehouse_name_Error').text($errors.name);
                            $('#warehouse_name').addClass('border-danger');
                            toastr.error($errors.name);
                        }

                        if ($errors.address) {
                            $('#warehouse_address_Error').text($errors.address);
                            $('#warehouse_address').addClass('border-danger');
                            toastr.error($errors.address);
                        }

                        if ($errors.phone) {
                            $('#warehouse_phone_Error').text($errors.phone);
                            $('#warehouse_phone').addClass('border-danger');
                            toastr.error($errors.phone);
                        }
                    }
                });
            }

            // add product using ajax


            // edit product using ajax
            function edit(id) {
                var data_id = id;
                var url = "{{ route('user.warehouse.edit', ':id') }}";
                url = url.replace(':id', data_id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,

                    success: function(data) {
                        // adding the data to fields
                        $('#warehouse_name').val(data.name);
                        $('#warehouse_address').val(data.address);
                        $('#warehouse_phone').val(data.phone);
                        $('#row_id').val(data.id);
                        // adding the data to fields

                        // // hide show btn
                        $('#addWarehouse').addClass('d-none');
                        $('#addText').addClass('d-none');
                        $('#updateText').removeClass('d-none');
                        $('#updateWarehouse').removeClass('d-none');
                        // hide show btn

                        // modal show when edit button is clicked
                        $("#warehouseModal").modal("show");
                        // modal show when edit button is clicked
                        setTimeout(() => {
                            $('.animated-label').addClass('active-label');
                        }, 500);
                    },
                    error: function(error) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: 'Warehouse Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            }
            // edit client using ajax

            // update data using ajax
            function updateWarehouse(id) {
                //var receive_id = $('#row_id').val();

                var data_id = $('#row_id').val();
                var name = $('#warehouse_name').val();
                var address = $('#warehouse_address').val();
                var phone = $('#warehouse_phone').val();

                var url = "{{ route('user.warehouse.update', ':id') }}";
                url = url.replace(':id', data_id);
                $.ajax({
                    type: "PUT",
                    dataType: "json",
                    data: {
                        name: name,
                        address: address,
                        phone: phone,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url,
                    success: function(group) {
                        clearWarehouseField();

                        $("#warehouseModalClose").click();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Department updated successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#file-export-datatable').DataTable().ajax.reload();
                        // $("#ChartOfAccountGroupModal").click();

                    },
                    error: function(error) {
                        var $errors = error.responseJSON.errors;

                        if ($errors.name) {
                            $('#warehouse_name_Error').text($errors.name);
                            $('#warehouse_name').addClass('border-danger');
                            toastr.error($errors.name);
                        }
                    }
                })
            }
            // update data using ajax
        </script>
    @endpush
