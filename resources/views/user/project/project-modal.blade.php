<div class="modal fade" id="projectAddModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_project') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.project') }} | {{ __('messages.id_no') }}: <span id="id_number"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="client-group-form">
                    <div class="form-group col-xl-12 col-lg-12 col-md-12">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                            <span class="input-group-text"><i class="fas fa-user-tie" title="{{ __('messages.client') }}"></i></span>
                            <div class="input-group">
                                <select name="client_id" id="client_id" class="form-control select2 client_id"></select>
                            </div>
                            <a id="clientAddProjectModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="client_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-12 col-lg-12 col-md-12">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-bars"></i></span>
                            <input type="text" class="form-control" name="project_name" id="project_name" placeholder="{{ __('messages.project') }} {{ __('messages.name') }}">
                        </div>
                        <span class="text-danger small" id="project_name_Error"></span>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addProject" onclick="addProject();">{{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateProject" onclick="updateProject();">{{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="projectAddModalClose" type="button">{{ __('messages.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClients();
            // for client add modal
            $("#clientAddProjectModalBtn").click(function() {
                $("#clientAddModal").modal("show");
            });

            // for project add modal
            $("#projectAddModalBtn").click(function() {
                $("#projectAddModal").modal("show");
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearProjectField() {
            $('#client_id').val('');
            $('#client_id_Error').text('');
            $('#client_id').removeClass('border-danger');

            $('#project_name').val('');
            $('#project_name_Error').text('');
            $('#project_name').removeClass('border-danger');
        }

        // add client using ajax
        function addProject() {
            var client_id = $('#client_id').val();
            var project_name = $('#project_name').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    client_id: client_id,
                    project_name: project_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.project.store') }}",
                success: function(group) {
                    clearProjectField();
                    $("#projectAddModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Project added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                    // fetch updatd list when data is added from another modal
                    fetchProjects();
                    // select last inserted data
                    setTimeout(() => {
                        var id = $("#project_id option:last").val();
                        $("#project_id").val(id).trigger('change');
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.client_id) {
                        $('#client_id_Error').text($errors.client_id);
                        $('#client_id').addClass('border-danger');
                        toastr.error($errors.client_id);
                    }
                    if ($errors.project_name) {
                        $('#project_name_Error').text($errors.project_name);
                        $('#project_name').addClass('border-danger');
                        toastr.error($errors.project_name);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function editProject(id) {
            var data_id = id;
            var url = '{{ route('user.project.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#client_id').val(data.client_id).trigger('change');
                    $('#project_name').val(data.project_name);
                    $('#row_id').val(data.id);
                    // adding the data to fields
                    // // hide show btn
                    $('#id_number').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addProject').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateProject').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#projectAddModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Project Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateProject() {
            var data_id = $('#row_id').val();
            var client_id = $('#client_id').val();
            var project_name = $('#project_name').val();

            var url = '{{ route('user.project.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    client_id: client_id,
                    project_name: project_name,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearProjectField();

                    $("#projectAddModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Project updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.client_id) {
                        $('#client_id_Error').text($errors.client_id);
                        $('#client_id').addClass('border-danger');
                        toastr.error($errors.client_id);
                    }
                    if ($errors.project_name) {
                        $('#project_name_Error').text($errors.project_name);
                        $('#project_name').addClass('border-danger');
                        toastr.error($errors.project_name);
                    }
                }
            })
        }
        // update data using ajax
    </script>
@endpush
