<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModal" aria-hidden="true">
    <div class="modal-dialog modal-lg  " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="addUserText">Add New User</h6>
                <h6 class="modal-title d-none" id="updateUserText">Update User</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="card">

                    <div class="card-body">
                        <div class="row" id="Receive-category-form">
                            <div class="form-group col-xl-6 col-lg-6 col-md-6 m-auto">
                                <div class="input-group">
                                    <span class="input-group-text" title="GroupName" id="basic-addon1"><i class="fas fa-bars" title="Receive_category"></i></span>
                                    <input type="text" class="form-control" name="Receive_category" id="name" placeholder="User Name">
                                </div>
                                <span  class="text-danger small" id="name_Error"></span>
                                <div class="input-group">
                                    <span class="input-group-text" title="GroupName" id="basic-addon1"><i class="fas fa-bars" title="Receive_category"></i></span>
                                    <input type="password" class="form-control" name="Receive_category" id="name" placeholder="Password">
                                </div>
                                <span  class="text-danger small" id="password_Error"></span>
                            </div>
                        </div>

                    <input type="hidden" id="row_id">
                        {{-- form field end --}}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" id="addUser" onclick="addUser();">Add New Product</button>
                        <button class="btn btn-info" type="button" id="updateUser" onclick="updateUser();">Update Product</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal" id="AddUserModalClose" type="button">Cancel</button>
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

                function clearReceiveCategoryField() {
                    $('#name').val('');
                    $('#name_Error').text('');
                    $('#name').removeClass('border-danger');


                }

                $('#Receive-category-form').find('input, textarea, select').each(function() {
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
                function addReceiveCategory() {
                    var name = $('#name').val();


                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            name: name,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('user.configuration.receive-category.store') }}",
                        success: function(group) {
                            clearReceiveCategoryField();

                            $("#ReceiveCategoryModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Product added successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;

                            if ($errors.name) {
                                $('#Receive_category_Error').text($errors.name);
                                $('#name').addClass('border-danger');
                                toastr.error($errors.name);
                            }


                        }
                    });
                }

                // add product using ajax


                // edit product using ajax
                function edit(id) {
                    var data_id = id;

                    var url = '{{ route('user.configuration.receive-category.edit', ':id') }}';
                    url = url.replace(':id', data_id);

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,

                        success: function(data) {
                            // adding the data to fields
                            $('#name').val(data.name);
                            $('#row_id').val(data.id);
                            // adding the data to fields

                            // // hide show btn
                            $('#addReceiveCategory').addClass('d-none');
                            $('#addReceiveCategoryText').addClass('d-none');
                            $('#updateReceiveCategoryText').removeClass('d-none');
                             $('#updateReceiveCategory').removeClass('d-none');
                            // hide show btn

                            // modal show when edit button is clicked
                            $("#ReceiveCategoryModal").modal("show");
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
                function updateReceiveCategory(id) {
                    //var receive_id = $('#row_id').val();

                    var data_id = $('#row_id').val();
                    var name = $('#name').val();


                    var url = '{{ route('user.configuration.receive-category.update', ':id') }}';
                    url = url.replace(':id', data_id);
                    $.ajax({
                        type: "PUT",
                        dataType: "json",
                        data: {
                            name: name,

                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: url,
                        success: function(group) {
                            clearReceiveCategoryField();

                            $("#ReceiveCategoryModalClose").click();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Group updated successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#file-export-datatable').DataTable().ajax.reload();
                            $("#ReceiveCategoryModalClose").click();

                        },
                        error: function(error) {
                            var $errors = error.responseJSON.errors;
                            if ($errors.name) {
                                $('#Receive_category_Error').text($errors.name);
                                $('#name').addClass('border-danger');
                                toastr.error($errors.name);
                            }


                        }
                    })
                }
                // update data using ajax
            </script>
        @endpush
