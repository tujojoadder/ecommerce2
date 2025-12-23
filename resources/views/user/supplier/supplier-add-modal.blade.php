<div class="modal fade" id="supplierAddModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addText">Add New Supplier</h6>
                <h6 class="modal-title d-none" id="updateText">Update Supplier | ID No: <span id="id_number"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="client-group-form">
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_supplier_name') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name">
                        <label class="animated-label ms-3" for="supplier_name"><i class="fas fa-user"></i> {{ __('messages.supplier_name') }}</label>
                        <span class="text-danger small" id="supplier_name_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_company_name') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
                        <label class="animated-label ms-3" for="company_name"><i class="fas fa-building"></i> {{ __('messages.company_name') }}</label>
                        <span class="text-danger small" id="company_name_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_address') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                        <label class="animated-label ms-3" for="address"><i class="fas fa-map-pin"></i> {{ __('messages.address') }}</label>
                        <span class="text-danger small" id="address_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_phone') == 1 ? '' : 'd-none' }}">
                        <input type="number" min="0" class="form-control" name="supplier_phone" id="supplier_phone" placeholder="Phone Number">
                        <label class="animated-label ms-3" for="supplier_phone"><i class="fas fa-mobile"></i> {{ __('messages.phone') }}</label>
                        <span class="text-danger small" id="supplier_phone_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_phone_optional') == 1 ? '' : 'd-none' }}">
                        <input type="number" min="0" class="form-control" name="phone_optional" id="phone_optional" placeholder="Phone Number (Optional)">
                        <label class="animated-label ms-3" for="phone_optional"><i class="fas fa-mobile"></i> {{ __('messages.phone') }} (Optional)</label>
                        <span class="text-danger small" id="phone_optional_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_previous_due') == 1 ? '' : 'd-none' }}">
                        <input type="number" step="any" class="form-control" name="previous_due" id="previous_due" placeholder="Previous Due">
                        <label class="animated-label ms-3" for="previous_due">{{ config('company.currency_symbol') }} {{ __('messages.previous_due') }}</label>
                        <span class="text-danger small" id="previous_due_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_email') == 1 ? '' : 'd-none' }}">
                        <input type="email" class="form-control" name="email" id="email" placeholder="email">
                        <label class="animated-label ms-3" for="email"><i class="fas fa-envelope"></i> {{ __('messages.email') }}</label>
                        <span class="text-danger small" id="email_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_city_state') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="city_state" id="city_state" placeholder="City / State">
                        <label class="animated-label ms-3" for="city_state"><i class="fas fa-city"></i> {{ __('messages.city') }}</label>
                        <span class="text-danger small" id="city_state_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_zip_code') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zip Code">
                        <label class="animated-label ms-3" for="zip_code"><i class="fas fa-map-marked-alt"></i> {{ __('messages.zip_code') }}</label>
                        <span class="text-danger small" id="zip_code_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_country_name') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="country_name" id="country_name" placeholder="Country Name">
                        <label class="animated-label ms-3" for="country_name"><i class="fas fa-map-marked-alt"></i> {{ __('messages.country') }}</label>
                        <span class="text-danger small" id="country_name_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_domain') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="domain" id="domain" placeholder="Domain">
                        <label class="animated-label ms-3" for="domain"><i class="fas fa-map-marked-alt"></i> {{ __('messages.domain') }}</label>
                        <span class="text-danger small" id="domain_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_bank_account') == 1 ? '' : 'd-none' }}">
                        <input type="text" class="form-control" name="bank_account" id="bank_account" placeholder="Bank Account">
                        <label class="animated-label ms-3" for="bank_account"><i class="fas fa-map-marked-alt"></i> {{ __('messages.bank') }}</label>
                        <span class="text-danger small" id="bank_account_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_image') == 1 ? '' : 'd-none' }}">
                        <input type="file" accept="image/*" name="image" id="image" class="form-control image" placeholder="" id="image">
                        <span class="text-danger small" id="image_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_group_id') == 1 ? '' : 'd-none' }}">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Group">
                                <select name="group_id" id="group_id" class="form-control select2">
                                </select>
                            </div>
                            <a id="supplierGroupModalBtn" class="add-to-cart add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="group_id_error"></span>
                    </div>
                    <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_supplier_status') == 1 ? '' : 'd-none' }}">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Status">
                            <select name="supplier_status" id="supplier_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <span class="text-danger small" id="supplier_status_error"></span>
                    </div>
                </div>
                <input type="hidden" id="row_id">
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-success" type="button" id="addSupplier" onclick="addSupplier();"><i class="fas fa-plus"></i> Add Supplier</button>
                <button class="btn btn-info d-none" type="button" id="updateSupplier" onclick="updateSupplier();"><i class="fas fa-plus"></i> Update Group</button>
                <button class="btn btn-danger m-0" data-bs-dismiss="modal" id="supplierModalClose" type="button"><i class="fas fa-ban"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
@include('user.supplier.group.supplier-group-modal')
@push('scripts')
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script src="{{ asset('dashboard/js/get-supplier-info.js') }}"></script>
    <script>
        $(document).ready(function() {
            // for client group modal
            $("#supplierGroupModalBtn").click(function() {
                $("#supplierGroupModal").modal("show");
            });
        });


        function fetchSuppliersGroups() {
            $.ajax({
                url: "{{ route('get.suppliers.group') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#group_id').html(html);
                }
            });
        }
        $(document).ready(function() {
            fetchSuppliersGroups();
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearSupplierField() {
            $('#supplier_name').val('');
            $('#supplier_name_Error').text('');
            $('#supplier_name').removeClass('border-danger');

            $('#company_name').val('');
            $('#company_name_Error').text('');
            $('#company_name').removeClass('border-danger');

            $('#address').val('');
            $('#address_Error').text('');
            $('#address').removeClass('border-danger');

            $('#supplier_phone').val('');
            $('#supplier_phone_Error').text('');
            $('#supplier_phone').removeClass('border-danger');

            $('#phone_optional').val('');
            $('#phone_optional_Error').text('');
            $('#phone_optional').removeClass('border-danger');

            $('#previous_due').val('');
            $('#previous_due_Error').text('');
            $('#previous_due').removeClass('border-danger');

            $('#email').val('');
            $('#email_Error').text('');
            $('#email').removeClass('border-danger');

            $('#city_state').val('');
            $('#city_state_Error').text('');
            $('#city_state').removeClass('border-danger');

            $('#zip_code').val('');
            $('#zip_code_Error').text('');
            $('#zip_code').removeClass('border-danger');

            $('#country_name').val('');
            $('#country_name_Error').text('');
            $('#country_name').removeClass('border-danger');

            $('#domain').val('');
            $('#domain_Error').text('');
            $('#domain').removeClass('border-danger');

            $('#bank_account').val('');
            $('#bank_account_Error').text('');
            $('#bank_account').removeClass('border-danger');

            $('#group_id').val('').trigger('change');
            $('#group_id_Error').text('');
            $('#group_id').removeClass('border-danger');

            $('#image').val('');
            $('#image_Error').text('');
            $('#image').removeClass('border-danger');

            $('#supplier_status').val('');
            $('#supplier_status_Error').text('');
            $('#supplier_status').removeClass('border-danger');
        }

        // add client using ajax
        function addSupplier() {
            // Get values from input fields
            var supplier_name = $('#supplier_name').val();
            var company_name = $('#company_name').val();
            var address = $('#address').val();
            var phone = $('#supplier_phone').val();
            var phone_optional = $('#phone_optional').val();
            var previous_due = $('#previous_due').val();
            var email = $('#email').val();
            var city_state = $('#city_state').val();
            var zip_code = $('#zip_code').val();
            var country_name = $('#country_name').val();
            var domain = $('#domain').val();
            var bank_account = $('#bank_account').val();
            var image = $('#image')[0].files[0];
            var group_id = $('#group_id').val();
            var status = $('#supplier_status').val();

            // Create form data to send files
            var formData = new FormData();
            formData.append('supplier_name', supplier_name);
            formData.append('company_name', company_name);
            formData.append('address', address);
            formData.append('phone', phone);
            formData.append('phone_optional', phone_optional);
            formData.append('previous_due', previous_due);
            formData.append('email', email);
            formData.append('city_state', city_state);
            formData.append('zip_code', zip_code);
            formData.append('country_name', country_name);
            formData.append('domain', domain);
            formData.append('bank_account', bank_account);
            formData.append('image', image ?? '');
            formData.append('group_id', group_id);
            formData.append('status', status);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                type: "POST",
                dataType: "json",
                data: formData, // Use FormData for files
                contentType: false,
                processData: false, // Important when using FormData
                url: "{{ route('user.supplier.store') }}",
                success: function(data) {
                    clearSupplierField();
                    $("#supplierModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Supplier added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#file-export-datatable').DataTable().ajax.reload();
                    // Fetch updated list when data is added from another modal
                    fetchSuppliers();
                    // Select last inserted data
                    setTimeout(function() {
                        getSupplierInfo('/get-supplier-info', data.id);
                    }, 1000);
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.supplier_name) {
                        $('#supplier_name_Error').text($errors.supplier_name);
                        $('#supplier_name').addClass('border-danger');
                        toastr.error($errors.supplier_name);
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
                        $('#supplier_phone_Error').text($errors.phone);
                        $('#supplier_phone').addClass('border-danger');
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
                    if ($errors.city_state) {
                        $('#city_state_Error').text($errors.city_state);
                        $('#city_state').addClass('border-danger');
                        toastr.error($errors.city_state);
                    }
                    if ($errors.zip_code) {
                        $('#zip_code_Error').text($errors.zip_code);
                        $('#zip_code').addClass('border-danger');
                        toastr.error($errors.zip_code);
                    }
                    if ($errors.country_name) {
                        $('#country_name_Error').text($errors.country_name);
                        $('#country_name').addClass('border-danger');
                        toastr.error($errors.country_name);
                    }
                    if ($errors.domain) {
                        $('#domain_Error').text($errors.domain);
                        $('#domain').addClass('border-danger');
                        toastr.error($errors.domain);
                    }
                    if ($errors.bank_account) {
                        $('#bank_account_Error').text($errors.bank_account);
                        $('#bank_account').addClass('border-danger');
                        toastr.error($errors.bank_account);
                    }
                    if ($errors.image) {
                        $('#image_Error').text($errors.image);
                        $('#image').addClass('border-danger');
                        toastr.error($errors.image);
                    }
                    if ($errors.group_id) {
                        $('#group_id_Error').text($errors.group_id);
                        $('#group_id').addClass('border-danger');
                        toastr.error($errors.group_id);
                    }
                    if ($errors.status) {
                        $('#supplier_status_Error').text($errors.status);
                        $('#supplier_status').addClass('border-danger');
                        toastr.error($errors.status);
                    }
                }
            });
        }

        // add product using ajax


        // edit product using ajax
        function edit(id) {
            var data_id = id;

            var url = '{{ route('user.supplier.edit', ':id') }}';
            url = url.replace(':id', data_id);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,

                success: function(data) {
                    // adding the data to fields
                    $('#id_no').val(data.id_no);

                    var supplier_name = $('#supplier_name').val();
                    var company_name = $('#company_name').val();
                    var address = $('#address').val();
                    var phone = $('#phone').val();
                    var phone_optional = $('#phone_optional').val();
                    var previous_due = $('#previous_due').val();
                    var email = $('#email').val();
                    var city_state = $('#city_state').val();
                    var zip_code = $('#zip_code').val();
                    var country_name = $('#country_name').val();
                    var domain = $('#domain').val();
                    var bank_account = $('#bank_account').val();
                    var image = $('#image')[0].files[0];
                    var group_id = $('#group_id').val();
                    var status = $('#supplier_status').val();
                    // adding the data to fields
                    // // hide show btn
                    $('#id_number').text(data.id);
                    $('#addText').addClass('d-none');
                    $('#addSupplier').addClass('d-none');
                    $('#updateText').removeClass('d-none');
                    $('#updateSupplier').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#supplierAddModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Supplier Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateSupplier(id) {
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
                    clearSupplierField();

                    $("#supplierModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Supplier updated successfully!',
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
