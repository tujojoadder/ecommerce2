<div class="modal fade" id="staffDesignationModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog  " role="document">
        <div class="modal-content modal-content-demo" id="designation-form">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('messages.add_new_designation') }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="designation_name" name="designation_name" placeholder="{{ __('messages.designation') }} {{ __('messages.title') }}">
                            <label class="animated-label" for="designation_name"><i class="fas fa-layer-group"></i> {{ __('messages.designation') }} {{ __('messages.title') }}</label>
                        </div>
                    </div>
                    <span class="text-danger small" id="designation_name_Error"></span>
                </div>
                <input type="hidden" class="text-danger" id="row_id">
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" type="button" id="addDesignation" onclick="addDesignation()">{{ __('messages.add') }}</button>
                <button class="btn ripple btn-primary d-none" type="button" id="updateDesignation" onclick="updateDesignation()">{{ __('messages.update') }}</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button" id="designationModalClose">{{ __('messages.close') }}</button>
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

        function clearDesignationField() {
            $('#designation_name').val('');
            $('#designation_name_Error').text('');
            $('#designation_name').removeClass('border-danger');


        }


        $('#designation-form').find('input, textarea, select').each(function() {
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
        function addDesignation() {
            var name = $('#designation_name').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.designation.store') }}",
                success: function(group) {
                    clearDesignationField();

                    $("#designationModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Designation added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    fetchDesignation();
                    setTimeout(() => {
                        var id = $("#designation_id option:last").val();
                        $("#designation_id").val(id).trigger('change');
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#designation_name_Error').text($errors.name);
                        $('#designation_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = "{{ route('user.designation.edit', ':id') }}";
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#designation_name').val(data.name);
                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // // hide show btn
                    $('#addDesignation').addClass('d-none');
                    $('#addText').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateDesignation').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#staffDesignationModal").modal("show");
                    // modal show when edit button is clicked
                    setTimeout(() => {
                        $('#designation_name').focus();
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
        function updateDesignation(id) {
            //var receive_id = $('#row_id').val();

            var data_id = $('#row_id').val();
            var name = $('#designation_name').val();


            var url = "{{ route('user.designation.update', ':id') }}";
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
                    clearDesignationField();

                    $("#designationModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Designation updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    $("#ChartOfAccountGroupModal").click();

                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.name) {
                        $('#designation_name_Error').text($errors.name);
                        $('#designation_name').addClass('border-danger');
                        toastr.error($errors.name);
                    }
                }
            });
        }
        // update data using ajax
    </script>
@endpush
