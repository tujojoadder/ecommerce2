<div class="modal fade" id="clientAddModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">{{ __('messages.add_new_client') }}</h6>
                <h6 class="modal-title d-none" id="updateText">{{ __('messages.update') }} {{ __('messages.client') }} | {{ __('messages.id_no') }}: <span id="id_number"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="client-group-form">
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_id_no') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" name="id_no" id="id_no" placeholder="{{ __('messages.id_no') }}">
                            <label for="id_no" class="animated-label"><i class="fas fa-id-card"></i> {{ __('messages.id_no') }}</label>
                        </div>
                        <span class="text-danger small" id="id_no_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_client_name') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="client_name" id="client_name" placeholder="{{ __('messages.client') }} {{ __('messages.name') }}">
                            <label for="client_name" class="animated-label"><i class="fas fa-user-tie"></i> {{ __('messages.client') }} {{ __('messages.name') }}</label>
                        </div>
                        <span class="text-danger small" id="client_name_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_fathers_name') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="fathers_name" id="fathers_name" placeholder="{{ __('messages.fathers_name') }}">
                            <label for="fathers_name" class="animated-label"><i class="fas fa-user-tie"></i> {{ __('messages.fathers_name') }}</label>
                        </div>
                        <span class="text-danger small" id="fathers_name_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_mothers_name') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="mothers_name" id="mothers_name" placeholder="{{ __('messages.mothers_name') }}">
                            <label for="mothers_name" class="animated-label"><i class="fas fa-user-tie"></i> {{ __('messages.mothers_name') }}</label>
                        </div>
                        <span class="text-danger small" id="mothers_name_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_company_name') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="{{ __('messages.company') }} {{ __('messages.name') }}">
                            <label for="company_name" class="animated-label"><i class="fas fa-building"></i> {{ __('messages.company') }} {{ __('messages.name') }}</label>
                        </div>
                        <span class="text-danger small" id="company_name_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_address') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="address" placeholder="{{ __('messages.address') }}">
                            <label for="address" class="animated-label"><i class="fas fa-building"></i> {{ __('messages.address') }}</label>
                        </div>
                        <span class="text-danger small" id="address_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_phone') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" min="0" class="form-control" name="phone_number" id="phone_number" placeholder="{{ __('messages.phone') }}">
                            <label for="phone_number" class="animated-label"><i class="fas fa-user-tie"></i> {{ __('messages.phone') }}</label>
                        </div>
                        <span class="text-danger small" id="phone_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_phone_optional') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" min="0" class="form-control" name="phone_optional" id="phone_optional" placeholder="{{ __('messages.phone') }} ({{ __('messages.optional') }})">
                            <label for="phone_optional" class="animated-label"><i class="fas fa-mobile"></i> {{ __('messages.phone') }} ({{ __('messages.optional') }})</label>
                        </div>
                        <span class="text-danger small" id="phone_optional_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_previous_due') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" step="any" class="form-control" name="previous_due" id="previous_due" placeholder="{{ __('messages.previous_due') }}">
                            <label for="previous_due" class="animated-label"><i class="fas fa-money-check"></i> {{ __('messages.previous_due') }}</label>
                        </div>
                        <span class="text-danger small" id="previous_due_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_email') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('messages.email') }}">
                            <label for="email" class="animated-label"><i class="fas fa-envelope"></i> {{ __('messages.email') }}</label>
                        </div>
                        <span class="text-danger small" id="email_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_date_of_birth') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control fc-datepicker" name="date_of_birth" id="date_of_birth" placeholder="{{ __('messages.date_of_birth') }}" autocomplete="off">
                            <label for="date_of_birth" class="animated-label active-label"><i class="fas fa-calendar-day"></i> {{ __('messages.date_of_birth') }}</label>
                        </div>
                        <span class="text-danger small" id="date_of_birth_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_upazilla_thana') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="upazilla_thana" id="upazilla_thana" placeholder="{{ __('messages.upzilla') }}">
                            <label for="upazilla_thana" class="animated-label"><i class="fas fa-city"></i> {{ __('messages.upzilla') }}</label>
                        </div>
                        <span class="text-danger small" id="upazilla_thana_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_zip_code') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="{{ __('messages.zip_code') }}">
                            <label for="zip_code" class="animated-label"><i class="fas fa-map-marked-alt"></i> {{ __('messages.zip_code') }}</label>
                        </div>
                        <span class="text-danger small" id="zip_code_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('clients_group_id') == 1 ? '' : 'd-none' }}">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.group') }}">
                                <select name="group_id" id="group_id" class="form-control select2 client_group_id">
                                </select>
                            </div>
                            <a id="clientGroupModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="group_id_error"></span>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_image') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="file" accept="image/*" name="image" id="image" class="form-control image" placeholder="" id="image">
                        </div>
                        <span class="text-danger small" id="image_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('clients_status') == 1 ? '' : 'd-none' }}">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.status') }}">
                            <select name="status" id="status" class="form-control">
                                <option value="1">{{ __('messages.active') }}</option>
                                <option value="0">{{ __('messages.deactive') }}</option>
                            </select>
                        </div>
                        <span class="text-danger small" id="status_error"></span>
                    </div>
                    <input type="hidden" name="client_type" id="client_type" value="{{ Request::is('user/loan') ? 1 : 0 }}">
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addClient" onclick="addClient();"><i class="fas fa-plus"></i> {{ __('messages.client') }} {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateClient" onclick="updateClient();"><i class="fas fa-plus"></i> {{ __('messages.update') }} {{ __('messages.client') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="clientModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@include('user.client.group.client-group-modal')
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        $(document).ready(function() {
            // for client group modal
            $("#clientGroupModalBtn").click(function() {
                $("#clientGroupModal").modal("show");
            });
        });
        $(document).ready(function() {
            fetchClientGroups();
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearClientField() {
            $('#id_no').val('');
            $('#id_no_Error').text('');
            $('#id_no').removeClass('border-danger');

            $('#client_name').val('');
            $('#client_name_Error').text('');
            $('#client_name').removeClass('border-danger');

            $('#company_name').val('');
            $('#company_name_Error').text('');
            $('#company_name').removeClass('border-danger');

            $('#address').val('');
            $('#address_Error').text('');
            $('#address').removeClass('border-danger');

            $('#phone_number').val('');
            $('#phone_Error').text('');
            $('#phone_number').removeClass('border-danger');

            $('#phone_optional').val('');
            $('#phone_optional_Error').text('');
            $('#phone_optional').removeClass('border-danger');

            $('#previous_due').val('');
            $('#previous_due_Error').text('');
            $('#previous_due').removeClass('border-danger');

            $('#email').val('');
            $('#email_Error').text('');
            $('#email').removeClass('border-danger');

            $('#date_of_birth').val('');
            $('#date_of_birth_Error').text('');
            $('#date_of_birth').removeClass('border-danger');

            $('#upazilla_thana').val('');
            $('#upazilla_thana_Error').text('');
            $('#upazilla_thana').removeClass('border-danger');

            $('#zip_code').val('');
            $('#zip_code_Error').text('');
            $('#zip_code').removeClass('border-danger');

            $('#group_id').val('').trigger('change');
            $('#group_id_Error').text('');
            $('#group_id').removeClass('border-danger');

            $('#image').val('');
            $('#image_Error').text('');
            $('#image').removeClass('border-danger');

            $('#status').val('');
            $('#status_Error').text('');
            $('#status').removeClass('border-danger');
        }

        // add client using ajax
        function addClient() {
            // Get values from input fields
            var id_no = $('#clientAddModal #id_no').val();
            var client_name = $('#clientAddModal #client_name').val();
            var company_name = $('#clientAddModal #company_name').val();
            var address = $('#clientAddModal #address').val();
            var phone = $('#clientAddModal #phone_number').val();
            var phone_optional = $('#clientAddModal #phone_optional').val();
            var previous_due = $('#clientAddModal #previous_due').val();
            var email = $('#clientAddModal #email').val();
            var date_of_birth = $('#clientAddModal #date_of_birth').val();
            var upazilla_thana = $('#clientAddModal #upazilla_thana').val();
            var zip_code = $('#clientAddModal #zip_code').val();
            var group_id = $('#clientAddModal #group_id').val();
            var image = $('#clientAddModal #image')[0].files[0];
            var status = $('#clientAddModal #status').val();
            var client_type = $('#clientAddModal #client_type').val();

            // Create form data to send files
            var formData = new FormData();
            formData.append('id_no', id_no);
            formData.append('client_name', client_name);
            formData.append('company_name', company_name);
            formData.append('address', address);
            formData.append('phone', phone);
            formData.append('phone_optional', phone_optional);
            formData.append('previous_due', previous_due);
            formData.append('email', email);
            formData.append('date_of_birth', date_of_birth);
            formData.append('upazilla_thana', upazilla_thana);
            formData.append('zip_code', zip_code);
            formData.append('group_id', group_id ?? '');
            formData.append('image', image ?? '');
            formData.append('type', 'modal');
            formData.append('status', status);
            formData.append('client_type', client_type);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                type: "POST",
                dataType: "json",
                data: formData, // Use FormData for files
                contentType: false,
                processData: false, // Important when using FormData
                url: "{{ route('user.client.store') }}",
                success: function(data) {
                    clearClientField();
                    $("#clientModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Client added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.yajra-datatable').DataTable().ajax.reload();
                    // Fetch updated list when data is added from another modal
                    fetchClients();

                    // Select last inserted data
                    setTimeout(function() {
                        getClientInfo('/get-client-info', data.id);
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.id_no) {
                        $('#id_no_Error').text($errors.id_no);
                        $('#id_no').addClass('border-danger');
                        toastr.error($errors.id_no);
                    }
                    if ($errors.client_name) {
                        $('#client_name_Error').text($errors.client_name);
                        $('#client_name').addClass('border-danger');
                        toastr.error($errors.client_name);
                    }
                    if ($errors.company_name) {
                        $('#company_name_Error').text($errors.company_name);
                        $('#company_name').addClass('border-danger');
                        toastr.error($errors.company_name);
                    }
                    if ($errors.address) {
                        $('#address_Error').text($errors.address);
                        $('#address').addClass('border-danger');
                        toastr.error($errors.address);
                    }
                    if ($errors.phone) {
                        $('#phone_Error').text($errors.phone);
                        $('#phone_number').addClass('border-danger');
                        toastr.error($errors.phone);
                    }
                    if ($errors.phone_optional) {
                        $('#phone_optional_Error').text($errors.phone_optional);
                        $('#phone_optional').addClass('border-danger');
                        toastr.error($errors.phone_optional);
                    }
                    if ($errors.previous_due) {
                        $('#previous_due_Error').text($errors.previous_due);
                        $('#previous_due').addClass('border-danger');
                        toastr.error($errors.previous_due);
                    }
                    if ($errors.email) {
                        $('#email_Error').text($errors.email);
                        $('#email').addClass('border-danger');
                        toastr.error($errors.email);
                    }
                    if ($errors.date_of_birth) {
                        $('#date_of_birth_Error').text($errors.date_of_birth);
                        $('#date_of_birth').addClass('border-danger');
                        toastr.error($errors.date_of_birth);
                    }
                    if ($errors.upazilla_thana) {
                        $('#upazilla_thana_Error').text($errors.upazilla_thana);
                        $('#upazilla_thana').addClass('border-danger');
                        toastr.error($errors.upazilla_thana);
                    }
                    if ($errors.zip_code) {
                        $('#zip_code_Error').text($errors.zip_code);
                        $('#zip_code').addClass('border-danger');
                        toastr.error($errors.zip_code);
                    }
                    if ($errors.group_id) {
                        $('#group_id_Error').text($errors.group_id);
                        $('#group_id').addClass('border-danger');
                        toastr.error($errors.group_id);
                    }
                    if ($errors.status) {
                        $('#status_Error').text($errors.status);
                        $('#status').addClass('border-danger');
                        toastr.error($errors.status);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.client.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#clientAddModal #id_no').val(data.id_no);
                    $('#clientAddModal #client_name').val(data.client_name);
                    $('#clientAddModal #company_name').val(data.company_name);
                    $('#clientAddModal #address').val(data.address);
                    $('#clientAddModal #phone_number').val(data.phone);
                    $('#clientAddModal #phone_optional').val(data.phone_optional);
                    $('#clientAddModal #previous_due').val(data.previous_due);
                    $('#clientAddModal #email').val(data.email);
                    $('#clientAddModal #date_of_birth').val(data.date_of_birth);
                    $('#clientAddModal #upazilla_thana').val(data.upazilla_thana);
                    $('#clientAddModal #zip_code').val(data.zip_code);
                    $('#clientAddModal #group_id').val(data.group_id);
                    $('#clientAddModal #status').val(data.status);
                    // adding the data to fields
                    // // hide show btn
                    $('#clientAddModal #id_number').text(data.id);
                    $('#clientAddModal #addText').addClass('d-none');
                    $('#clientAddModal #addClient').addClass('d-none');
                    $('#clientAddModal #updateText').removeClass('d-none');
                    $('#clientAddModal #updateClient').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#clientAddModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Client Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateClient(id) {
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
                    clearClientField();

                    $("#clientModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Client updated successfully!',
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
