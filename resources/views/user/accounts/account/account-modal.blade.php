<div class="modal fade" id="accountAddModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addAccountText">Add New Account</h6>
                <h6 class="modal-title d-none" id="updateAccountText">Update Account | ID No: <span id="id_number"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="client-group-form">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Account title">
                            <label class="animated-label" for="title"><i class="fas fa-user"></i> {{ __('messages.account') }} {{ __('messages.title') }}</label>
                        </div>
                        <span class="text-danger small" id="title_error"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="initial_balance" id="initial_balance" placeholder="Initial Balance">
                            <label class="animated-label" for="initial_balance"><i class="fas fa-user"></i> {{ __('messages.initial') }} {{ __('messages.balance') }}</label>
                        </div>
                        <span class="text-danger small" id="initial_balance_error"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control clear-input" name="account_number" id="account_number" placeholder="Account Number" value="0">
                            <label class="animated-label" for="account_number"><i class="fas fa-user"></i> {{ __('messages.account') }} {{ __('messages.number') }}</label>
                        </div>
                        <span class="text-danger small" id="account_number_error"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="person" id="person" placeholder="Contact Person">
                            <label class="animated-label" for="person"><i class="fas fa-user"></i> {{ __('messages.contact_person') }}</label>
                        </div>
                        <span class="text-danger small" id="person_error"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="number" min="0" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                            <label class="animated-label" for="phone"><i class="fas fa-user"></i> {{ __('messages.phone') }} {{ __('messages.number') }}</label>
                        </div>
                        <span class="text-danger small" id="phone_error"></span>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="description" id="description" class="form-control" placeholder="Account description">
                            <label class="animated-label" for="description"><i class="fas fa-user"></i> {{ __('messages.account') }} {{ __('messages.description') }}</label>
                        </div>
                        <span class="text-danger small" id="description_error"></span>
                    </div>
                    {{-- <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Name">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <span class="text-danger small" id="status_error"></span>
                    </div> --}}
                </div>

                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addAccount" onclick="addAccount();"><i class="fas fa-plus"></i> {{ __('messages.add') }}</button>
                <button class="btn btn-info d-none" type="button" id="updateAccount" onclick="updateAccount();"><i class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="accountAddModalClose" type="button"><i class="fas fa-ban"></i> {{ __('messages.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        $(document).ready(function() {
            // for client add modal
            $("#clientAddAccount").click(function() {
                $("#clientAddModal").modal("show");
            });

            // for Account add modal
            $("#accountAddModalBtn").click(function() {
                $("#accountAddModal").modal("show");
            });
        });


        function fetchClients() {
            $.ajax({
                url: "{{ route('get.clients') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.client_name + '</option>';
                    });
                    $('#client_id').html(html);
                }
            });
        }
        $(document).ready(function() {
            fetchClients();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearAccountField() {
            $('#title').val('');
            $('#title_Error').text('');
            $('#title').removeClass('border-danger');

            $('#initial_balance').val('');
            $('#initial_balance_Error').text('');
            $('#initial_balance').removeClass('border-danger');

            $('#account_number').val('');
            $('#account_number_Error').text('');
            $('#account_number').removeClass('border-danger');

            $('#person').val('');
            $('#person_Error').text('');
            $('#person').removeClass('border-danger');

            $('#phone').val('');
            $('#phone_Error').text('');
            $('#phone').removeClass('border-danger');

            $('#description').val('');
            $('#description_Error').text('');
            $('#description').removeClass('border-danger');
        }

        // add client using ajax
        function addAccount() {
            var title = $('#title').val();
            var initial_balance = $('#initial_balance').val();
            var account_number = $('#account_number').val();
            var person = $('#person').val();
            var phone = $('#phone').val();
            var description = $('#description').val();
            var status = $('#status').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    title: title,
                    initial_balance: initial_balance,
                    account_number: account_number,
                    person: person,
                    phone: phone,
                    description: description,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.account.store') }}",
                success: function(account) {
                    clearAccountField();
                    $("#accountAddModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Account added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();

                    // fetch updatd list when data is added from another modal
                    fetchAccounts();
                    // select last inserted data
                    setTimeout(() => {
                        getAccountInfo('/get-account', account.id);
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.title) {
                        $('#title_Error').text($errors.title);
                        $('#title').addClass('border-danger');
                        toastr.error($errors.title);
                    }
                    if ($errors.initial_balance) {
                        $('#initial_balance_Error').text($errors.initial_balance);
                        $('#initial_balance').addClass('border-danger');
                        toastr.error($errors.initial_balance);
                    }
                    if ($errors.account_number) {
                        $('#account_number_Error').text($errors.account_number);
                        $('#account_number').addClass('border-danger');
                        toastr.error($errors.account_number);
                    }
                    if ($errors.person) {
                        $('#person_Error').text($errors.person);
                        $('#person').addClass('border-danger');
                        toastr.error($errors.person);
                    }
                    if ($errors.phone) {
                        $('#phone_Error').text($errors.phone);
                        $('#phone').addClass('border-danger');
                        toastr.error($errors.phone);
                    }
                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;
            var url = '{{ route('user.account.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#title').val(data.title);
                    $('#initial_balance').val(data.initial_balance);
                    $('#account_number').val(data.account_number);
                    $('#person').val(data.person);
                    $('#phone').val(data.phone);
                    $('#description').val(data.description);
                    $('#row_id').val(data.id);
                    // adding the data to fields
                    // // hide show btn
                    $('#id_number').text(data.id);
                    $('#addAccountText').addClass('d-none');
                    $('#addAccount').addClass('d-none');
                    $('#updateAccountText').removeClass('d-none');
                    $('#updateAccount').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#accountAddModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Account Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateAccount() {
            var data_id = $('#row_id').val();
            var title = $('#title').val();
            var initial_balance = $('#initial_balance').val();
            var account_number = $('#account_number').val();
            var person = $('#person').val();
            var phone = $('#phone').val();
            var description = $('#description').val();

            var url = '{{ route('user.account.update', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    title: title,
                    initial_balance: initial_balance,
                    account_number: account_number,
                    person: person,
                    phone: phone,
                    description: description,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearAccountField();

                    $("#accountAddModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Account updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.title) {
                        $('#title_Error').text($errors.title);
                        $('#title').addClass('border-danger');
                        toastr.error($errors.title);
                    }
                    if ($errors.initial_balance) {
                        $('#initial_balance_Error').text($errors.initial_balance);
                        $('#initial_balance').addClass('border-danger');
                        toastr.error($errors.initial_balance);
                    }
                    if ($errors.account_number) {
                        $('#account_number_Error').text($errors.account_number);
                        $('#account_number').addClass('border-danger');
                        toastr.error($errors.account_number);
                    }
                    if ($errors.person) {
                        $('#person_Error').text($errors.person);
                        $('#person').addClass('border-danger');
                        toastr.error($errors.person);
                    }
                    if ($errors.phone) {
                        $('#phone_Error').text($errors.phone);
                        $('#phone').addClass('border-danger');
                        toastr.error($errors.phone);
                    }
                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }
                }
            })
        }
        // update data using ajax
    </script>
@endpush
