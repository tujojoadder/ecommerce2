<div class="modal fade" id="clientGroupModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new') }}</h6>
                <h6 class="modal-title d-none" id="updateText">Update Client Group | ID No: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="client-group-form">
                    <div class="col-xl-12 col-lg-12 col-md-12 m-auto">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="client_group_name" id="client_group_name">
                            <label for="client_group_name" class="animated-label"><i class="fas fa-bars"></i> {{ __('messages.group_name') }}</label>
                            <span class="text-danger small" id="client_group_name_Error"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addClientGroup" onclick="addClientGroup();"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateClientGroup" onclick="updateClientGroup();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="clientGroupModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script src="{{ asset('dashboard/js/get-client-info.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearClientGroupField() {
            $('#client_group_name').val('');
            $('#client_group_name_Error').text('');
            $('#client_group_name').removeClass('border-danger');
        }

        // add client using ajax
        function addClientGroup() {
            var client_group_name = $('#client_group_name').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: client_group_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.client-group.store') }}",
                success: function(data) {
                    clearClientGroupField();
                    $("#clientGroupModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Client Group added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                    fetchClientGroups();
                    setTimeout(() => {
                        getClientGroupInfo('/get-client-group', data.id)
                        $("#client_group_id, .client_group_id").val(data.id).trigger('change');
                    }, 500);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#client_group_name_Error').text($errors.name);
                        $('#client_group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.client-group.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#client_group_name').val(data.name);
                    $('#row_id').val(data.id);
                    $('#voucher_id').text(data.id);
                    // adding the data to fields
                    // // hide show btn
                    $('#id_no').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addClientGroup').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateClientGroup').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#clientGroupModal").modal("show");
                    // modal show when edit button is clicked
                    setTimeout(() => {
                        $('#client_group_name').keyup();
                        $('#client_group_name').focus();
                    }, 500);
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Client Group Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateClientGroup(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var client_group_name = $('#client_group_name').val();


            var url = '{{ route('user.client-group.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    name: client_group_name,

                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearClientGroupField();

                    $("#clientGroupModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Client Group updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.name) {
                        $('#client_group_name_Error').text($errors.name);
                        $('#client_group_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }


                }
            })
        }
        // update data using ajax
    </script>
@endpush
