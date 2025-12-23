<div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.update') }} {{ __('messages.status') }}</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="client-group-form">
                    <div class="col-md-12 mb-2">
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto  mt-2">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-hands-helping"></i></span>
                                <input type="text" class="form-control" name="key" id="key" placeholder="KEY">
                            </div>
                            <span class="text-danger small" id="key_Error"></span>
                        </div><br>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto mt-2">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-hands-helping"></i></span>
                                <input type="text" class="form-control" name="package_id" id="package_id" placeholder="Packge Id">
                            </div>
                            <span class="text-danger small" id="package_id_Error"></span>
                        </div><br>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto  mt-2">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-hands-helping"></i></span>
                                <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Invoice Id">
                            </div>
                            <span class="text-danger small" id="invoice_id_Error"></span>
                        </div><br>
                        <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto  mt-2">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-hands-helping"></i></span>
                                <input type="text" class="form-control" name="admin_id" id="admin_id" placeholder="Admin Id">
                            </div>
                            <span class="text-danger small" id="admin_id_Error"></span>
                        </div>
                    </div>

                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addUpdate" onclick="addStatus();">{{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="ModalClose" type="button">{{ __('messages.cancel') }}</button>
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

        function clearField() {
            $('#key').val('');
            $('#key_Error').text('');
            $('#key').removeClass('border-danger');

            $('#package_id').val('');
            $('#package_id_Error').text('');
            $('#package_id').removeClass('border-danger');

            $('#invoice_id').val('');
            $('#invoice_id_Error').text('');
            $('#invoice_id').removeClass('border-danger');

            $('#admin_id').val('');
            $('#admin_id_Error').text('');
            $('#admin_id').removeClass('border-danger');
        }

        // add client using ajax
        function addStatus() {
            var key = $('#key').val();
            var package_id = $('#package_id').val();
            var invoice_id = $('#invoice_id').val();
            var admin_id = $('#admin_id').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    key: key,
                    package_id: package_id,
                    invoice_id: invoice_id,
                    admin_id: admin_id,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.software.management.store') }}",
                success: function(data) {
                    clearField();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $('#ModalClose').click();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.key) {
                        $('#key_Error').text($errors.key);
                        $('#key').addClass('border-danger');
                        toastr.error($errors.key);
                    }
                    if ($errors.package_id) {
                        $('#package_id_Error').text($errors.package_id);
                        $('#package_id').addClass('border-danger');
                        toastr.error($errors.package_id);
                    }
                    if ($errors.invoice_id) {
                        $('#invoice_id_Error').text($errors.invoice_id);
                        $('#invoice_id').addClass('border-danger');
                        toastr.error($errors.invoice_id);
                    }
                    if ($errors.admin_id) {
                        $('#admin_id_Error').text($errors.admin_id);
                        $('#admin_id').addClass('border-danger');
                        toastr.error($errors.admin_id);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('admin.software.management.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#key').val(data.key);
                    $('#package_id').val(data.package_id);
                    $('#invoice_id').val(data.invoice_id);
                    $('#admin_id').val(data.admin_id);
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // modal show when edit button is clicked
                    $("#updateModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Language Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateStatus(id) {
            var data_id = $('#row_id').val();
            var key = $('#key').val();
            var package_id = $('#package_id').val();
            var invoice_id = $('#invoice_id').val();
            var admin_id = $('#admin_id').val();
            var url = '{{ route('admin.software.management.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    key: key,
                    package_id: package_id,
                    invoice_id: invoice_id,
                    admin_id: admin_id,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(data) {
                    clearField();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $('#ModalClose').click();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.key) {
                        $('#key_Error').text($errors.key);
                        $('#key').addClass('border-danger');
                        toastr.error($errors.key);
                    }
                    if ($errors.package_id) {
                        $('#package_id_Error').text($errors.package_id);
                        $('#package_id').addClass('border-danger');
                        toastr.error($errors.package_id);
                    }
                    if ($errors.invoice_id) {
                        $('#invoice_id_Error').text($errors.invoice_id);
                        $('#invoice_id').addClass('border-danger');
                        toastr.error($errors.invoice_id);
                    }
                    if ($errors.admin_id) {
                        $('#admin_id_Error').text($errors.admin_id);
                        $('#admin_id').addClass('border-danger');
                        toastr.error($errors.admin_id);
                    }
                }
            });
        }
        // update data using ajax
    </script>
@endpush
