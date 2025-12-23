    <div class="modal fade" id="staffDepartmentModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  " role="document" id="department-form">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" id="addText">{{ __('messages.add_new_department') }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-xl-12 col-lg-12 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="department_name" name="department_name" placeholder="{{ __('messages.department') }} {{ __('messages.name') }}" aria-label="Username" aria-describedby="basic-addon1">
                                <label class="animated-label" for="department_name"><i class="fas fa-layer-group"></i> {{ __('messages.department_name') }}</label>
                            </div>
                            <span class="text-danger small" id="department_name_Error"></span>
                        </div>
                        <input type="hidden" id="row_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" id="addDepartment" type="button" onclick="addDepartment()">{{ __('messages.add') }}</button>
                    <button class="btn ripple btn-primary d-none" id="updateDepartment" type="button" onclick="updateDepartment()">{{ __('messages.update') }}</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="departmentModalClose">{{ __('messages.close') }}</button>
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

            function clearDepartmentField() {
                $('#department_name').val('');
                $('#department_name_Error').text('');
                $('#department_name').removeClass('border-danger');


            }


            $('#department-form').find('input, textarea, select').each(function() {
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
            function addDepartment() {
                var name = $('#department_name').val();



                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        name: name,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('user.department.store') }}",
                    success: function(group) {
                        clearDepartmentField();

                        $("#departmentModalClose").click();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Department added successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#file-export-datatable').DataTable().ajax.reload();
                        fetchDepartment();
                        // select last inserted data
                        setTimeout(() => {
                            var id = $("#department_id option:last").val();
                            $("#department_id").val(id).trigger('change');
                        }, 1000);
                    },
                    error: function(error) {
                        var $errors = error.responseJSON.errors;

                        if ($errors.name) {
                            $('#department_name_Error').text($errors.name);
                            $('#department_name').addClass('border-danger');
                            toastr.error($errors.name);
                        }
                    }
                });
            }

            // add product using ajax


            // edit product using ajax
            function edit(id) {
                var data_id = id;
                var url = "{{ route('user.department.edit', ':id') }}";
                url = url.replace(':id', data_id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,

                    success: function(data) {
                        // adding the data to fields
                        $('#department_name').val(data.name);
                        $('#row_id').val(data.id);
                        // adding the data to fields

                        // // hide show btn
                        $('#addDepartment').addClass('d-none');
                        $('#addText').addClass('d-none');
                        $('#updateText').removeClass('d-none');
                        $('#updateDepartment').removeClass('d-none');
                        // hide show btn

                        // modal show when edit button is clicked
                        $("#staffDepartmentModal").modal("show");
                        // modal show when edit button is clicked
                        setTimeout(() => {
                            $('#department_name').focus();
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
            function updateDepartment(id) {
                //var receive_id = $('#row_id').val();

                var data_id = $('#row_id').val();
                var name = $('#department_name').val();
                console.log(data_id);


                var url = "{{ route('user.department.update', ':id') }}";
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
                        clearDepartmentField();

                        $("#departmentModalClose").click();
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
                            $('#department_name_Error').text($errors.name);
                            $('#department_name').addClass('border-danger');
                            toastr.error($errors.name);
                        }
                    }
                })
            }
            // update data using ajax
        </script>
    @endpush
