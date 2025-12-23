@php
    $type = Route;
@endphp
<div class="modal fade" id="groupModal" tabindex="-1" aria-labelledby="groupModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">Add New Group</h6>
                <h6 class="modal-title d-none" id="updateText">Update Group | ID No: <span id="id_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="client-group-form">
                    <div class="form-group col-xl-12 col-lg-12 col-md-12 m-auto">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Group">
                            <span class="input-group-text"><i class="fas fa-bars"></i></span>
                            <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Group Name">
                            {{-- <input type="hidden" class="form-control" name="type" id="type" value="{{ $type }}"> --}}
                            <button class="btn btn-success" type="button" id="addGroup" onclick="addGroup();">Add New Group</button>
                            <button class="btn btn-info d-none" type="button" id="updateGroup" onclick="updateGroup();">Update Group</button>
                        </div>
                        <span class="text-danger small" id="group_name_Error"></span>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="groupModalClose" type="button">Cancel</button>
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

                function clearClientGroupField() {
                    $('#group_name').val('');
                    $('#group_name_Error').text('');
                    $('#group_name').removeClass('border-danger');
                }

                // add client using ajax
                function addGroup() {
                    var group_name = $('#group_name').val();


                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            name: group_name,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('user.client-group.store') }}",
                        success: function(group) {
                            clearClientGroupField();
                            $("#groupModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Group added successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();

                            // fetch updatd list when data is added from another modal
                            fetchClientsGroups();
                            // select last inserted data
                            setTimeout(() => {
                                var id = $("#group_id option:last").val();
                                $("#group_id").val(id).trigger('change');
                            }, 1000);
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

                    var url = '{{ route('user.client-group.edit', ':id') }}';
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
                            $('#id_no').text(data.id);
                            $('#addText').addClass('d-none');
                            $('#addGroup').addClass('d-none');
                            $('#updateText').removeClass('d-none');
                            $('#updateGroup').removeClass('d-none');
                            // hide show btn

                            // modal show when edit button is clicked
                            $("#groupModal").modal("show");
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
                function updateGroup(id) {
                    //var receive_id = $('#row_id').val();

                    var data_id = $('#row_id').val();
                    var group_name = $('#group_name').val();


                    var url = '{{ route('user.client-group.update', ':id') }}';
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
                            clearClientGroupField();

                            $("#groupModalClose").click();
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
