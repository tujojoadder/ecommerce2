<style>
    .select2-container--default {
        z-index: 102400 !important;
    }
</style>
<div class="modal fade" id="addReceiveModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title" id="addReceiveText">Add New Receive</h6>
                <h6 class="modal-title d-none" id="updateReceiveText">Update Receive | Voucher No: <span id="voucher_no"></span></h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- form field start --}}
                <div class="row" id="receive-form">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Client">
                            <span class="input-group-text"><i class="fas fa-user-tie" title="Client"></i></span>
                            <div class="input-group">
                                <select name="client_id" id="client_id" class="form-control select2 client_id"></select>
                            </div>
                            <a id="clientAddModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="client_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Invoice">
                            <span class="input-group-text" title="Invoice Id"><i class="fas fa-file-invoice"></i></span>
                            <div class="input-group">
                                <select name="invoice_id" id="invoice_id" class="form-control select2"></select>
                            </div>
                        </div>
                        <span class="text-danger small" id="invoice_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Date">
                            <span class="input-group-text" title="Date"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                            <input name="date" id="date" class="form-control fc-datepicker" placeholder="Date" value="{{ date('d/m/Y') }}" type="text" autocomplete="off">
                        </div>
                        <span class="text-danger small" id="date_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Account">
                            <span class="input-group-text"><i class="fas fa-university" title="Account"></i></span>
                            <div class="input-group">
                                <select name="account_id" id="account_id" class="form-control select2 account_id"></select>
                            </div>
                            <a id="accountModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="account_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Description">
                            <span class="input-group-text" title="Description"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                            <textarea name="description" id="description" class="form-control" cols="5" rows="1" placeholder="Receive description in short note"></textarea>
                        </div>
                        <span class="text-danger small" id="description_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Amount">
                            <span class="input-group-text" title="amount"><i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i></span>
                            <input name="amount" id="amount" type="number" step="any" class="form-control" placeholder="Money Amount">
                        </div>
                        <span class="text-danger small" id="amount_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Project">
                            <span class="input-group-text"><i class="fas fa-university" title="Category"></i></span>
                            <div class="input-group">
                                <select name="project_id" id="project_id" class="form-control select2"></select>
                            </div>
                            <a id="projectAddModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="project_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Chart Of Account">
                            <span class="input-group-text"><i class="fas fa-university" title="Chart Of account"></i></span>
                            <div class="input-group">
                                <select name="chart_account_id" id="chart_account_id" class="form-control select2"></select>
                            </div>
                            <a id="chartOfAccountBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="chart_account_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Chart Of Group">
                            <span class="input-group-text"><i class="fas fa-university" title="Chart Of account"></i></span>
                            <div class="input-group">
                                <select name="chart_group_id" id="chart_group_id" class="form-control select2"></select>
                            </div>

                        </div>
                        <span class="text-danger small" id="chart_group_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Receive Category">
                            <span class="input-group-text"><i class="fas fa-university" title="Receive Category"></i></span>
                            <div class="input-group">
                                <select name="category_id" id="category_id" class="form-control select2"></select>
                            </div>
                            <a id="receiveCategoryAddModalBtn" class="add-to-cart btn btn-danger" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="category_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Payment">
                            <span class="input-group-text"><i class="fas fa-money-check" title="Payment"></i></span>
                            <div class="input-group">
                                <select name="payment_id" id="payment_id" class="form-control select2"></select>
                            </div>
                        </div>
                        <span class="text-danger small" id="payment_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Bank">
                            <span class="input-group-text"><i class="fas fa-money-check" title="Bank"></i></span>
                            <div class="input-group">
                                <select name="bank_id" id="bank_id" class="form-control select2"></select>
                            </div>
                        </div>
                        <span class="text-danger small" id="bank_id_Error"></span>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Cheque No">
                            <span class="input-group-text"><i class="fas fa-bars" title="Cheque No"></i></span>
                            <input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="Cheque No">
                        </div>
                        <span class="text-danger small" id="cheque_no_Error"></span>
                    </div>

                    <div class="form-group mb-0 col-xl-6 col-lg-6 col-md-6">
                        <label class="input-group form-control d-flex justify-content-between py-1" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="SMS">
                            <span class="form-switch-description tx-15 me-2">
                                <i class="fas fa-sms"></i> SMS
                            </span>
                            <input type="checkbox" name="sms" id="sms" class="form-switch-input form-control-sm">
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                        <span class="text-danger small" id="sms_Error"></span>
                    </div>

                    <div class="form-group mb-0 col-xl-6 col-lg-6 col-md-6">
                        <label class="input-group form-control d-flex justify-content-between py-1" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="Email">
                            <span class="form-switch-description tx-15 me-2">
                                <i class="fas fa-at"></i> Email
                            </span>
                            <input type="checkbox" name="email" id="email" class="form-switch-input form-control-sm" checked>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                        <span class="text-danger small" id="email_Error"></span>
                    </div>
                    <input type="hidden" id="row_id">
                </div>
                {{-- form field end --}}
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="addReceive" onclick="addReceive();">Add New Receive</button>
                <button class="btn btn-info d-none" type="button" id="updateReceive" onclick="updateReceive();">Update Receive</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" id="receiveModalClose" type="button">Cancel</button>
            </div>
        </div>
    </div>
</div>
@include('user.project.project-modal')
@include('user.accounts.account.account-modal')
@include('user.client.client-add-modal')

@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClients();
            fetchAccounts();
            fetchProjects();
            fetchInvoices();
            fetchReceiveCategories();
            fetchChartOfAccount();
            fetchChartOfAccountGroup();
        });
    </script>
    {{-- ----------------------------------------------------------------------------------------------------------------------------------- --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearReceiveField() {
            $('#client_id').val('');
            $('#client_id_Error').text('');
            $('#client_id').removeClass('border-danger');

            $('#invoice_id').val('');
            $('#invoice_id_Error').text('');
            $('#invoice_id').removeClass('border-danger');

            $('#date').val('');
            $('#date_Error').text('');
            $('#date').removeClass('border-danger');

            $('#account_id').val('');
            $('#account_id_Error').text('');
            $('#account_id').removeClass('border-danger');

            $('#description').val('');
            $('#description_Error').text('');
            $('#description').removeClass('border-danger');

            $('#amount').val('');
            $('#amount_Error').text('');
            $('#amount').removeClass('border-danger');

            $('#project_id').val('');
            $('#project_id_Error').text('');
            $('#project_id').removeClass('border-danger');

            $('#chart_account_id').val('');
            $('#chart_account_id_Error').text('');
            $('#chart_account_id').removeClass('border-danger');

            $('#chart_group_id').val('');
            $('#chart_group_id_Error').text('');
            $('#chart_group_id').removeClass('border-danger');

            $('#category_id').val('');
            $('#category_id_Error').text('');
            $('#category_id').removeClass('border-danger');

            $('#payment_id').val('');
            $('#payment_id_Error').text('');
            $('#payment_id').removeClass('border-danger');

            $('#bank_id').val('');
            $('#bank_id_Error').text('');
            $('#bank_id').removeClass('border-danger');

            $('#cheque_no').val('');
            $('#cheque_no_Error').text('');
            $('#cheque_no').removeClass('border-danger');

            $('#sms').is(":checked");
            $('#sms_Error').text('');
            $('#sms').removeClass('border-danger');

            $('#email').is(":checked");
            $('#email_Error').text('');
            $('#email').removeClass('border-danger');
        }

        $('#receive-form').find('input, textarea, select').each(function() {
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
        function addReceive() {
            var client_id = $('#client_id').val();
            var invoice_id = $('#invoice_id').val();
            var date = $('#date').val();
            var account_id = $('#account_id').val();
            var description = $('#description').val();
            var amount = $('#amount').val();
            var project_id = $('#project_id').val();
            var chart_account_id = $('#chart_account_id').val();
            var chart_group_id = $('#chart_group_id').val();
            var category_id = $('#category_id').val();
            var payment_id = $('#payment_id').val();
            var bank_id = $('#bank_id').val();
            var cheque_no = $('#cheque_no').val();
            var sms = $('#sms').is(":checked");
            var email = $('#email').is(":checked");

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    client_id: client_id,
                    invoice_id: invoice_id,
                    date: date,
                    account_id: account_id,
                    description: description,
                    amount: amount,
                    project_id: project_id,
                    chart_account_id: chart_account_id,
                    chart_group_id: chart_group_id,
                    category_id: category_id,
                    payment_id: payment_id,
                    bank_id: bank_id,
                    cheque_no: cheque_no,
                    sms: sms,
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('user.receive.store') }}",
                success: function(group) {
                    clearReceiveField();

                    $("#receiveModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Receive added successfully!',
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

                    if ($errors.invoice_id) {
                        $('#invoice_id_Error').text($errors.invoice_id);
                        $('#invoice_id').addClass('border-danger');
                        toastr.error($errors.invoice_id);
                    }

                    if ($errors.date) {
                        $('#date_Error').text($errors.date);
                        $('#date').addClass('border-danger');
                        toastr.error($errors.date);
                    }

                    if ($errors.account_id) {
                        $('#account_id_Error').text($errors.account_id);
                        $('#account_id').addClass('border-danger');
                        toastr.error($errors.account_id);
                    }

                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }

                    if ($errors.amount) {
                        $('#amount_Error').text($errors.amount);
                        $('#amount').addClass('border-danger');
                        toastr.error($errors.amount);
                    }

                    if ($errors.project_id) {
                        $('#project_id_Error').text($errors.project_id);
                        $('#project_id').addClass('border-danger');
                        toastr.error($errors.project_id);
                    }

                    if ($errors.chart_account_id) {
                        $('#chart_account_id_Error').text($errors.chart_account_id);
                        $('#chart_account_id').addClass('border-danger');
                        toastr.error($errors.chart_account_id);
                    }

                    if ($errors.chart_group_id) {
                        $('#chart_group_id_Error').text($errors.chart_group_id);
                        $('#chart_group_id').addClass('border-danger');
                        toastr.error($errors.chart_group_id);
                    }

                    if ($errors.category_id) {
                        $('#category_id_Error').text($errors.category_id);
                        $('#category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }

                    if ($errors.payment_id) {
                        $('#payment_id_Error').text($errors.payment_id);
                        $('#payment_id').addClass('border-danger');
                        toastr.error($errors.payment_id);
                    }

                    if ($errors.bank_id) {
                        $('#bank_id_Error').text($errors.bank_id);
                        $('#bank_id').addClass('border-danger');
                        toastr.error($errors.bank_id);
                    }

                    if ($errors.cheque_no) {
                        $('#cheque_no_Error').text($errors.cheque_no);
                        $('#cheque_no').addClass('border-danger');
                        toastr.error($errors.cheque_no);
                    }

                    if ($errors.status) {
                        $('#status_Error').text($errors.status);
                        $('#status').addClass('border-danger');
                        toastr.error($errors.status);
                    }

                    if ($errors.sms) {
                        $('#sms_Error').text($errors.sms);
                        $('#sms').addClass('border-danger');
                        toastr.error($errors.sms);
                    }

                    if ($errors.email) {
                        $('#email_Error').text($errors.email);
                        $('#email').addClass('border-danger');
                        toastr.error($errors.email);
                    }
                }
            })
        }
        // add client using ajax


        // edit client using ajax
        function editReceive(id) {
            var data_id = id;
            var url = '{{ route('user.receive.edit', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    // adding the data to fields
                    $('#client_id').val(data.client_id).trigger('change');
                    $('#invoice_id').val(data.invoice_id).trigger('change');
                    $('#date').val(data.date);
                    $('#account_id').val(data.account_id).trigger('change');
                    $('#description').val(data.description);
                    $('#amount').val(data.amount);
                    $('#project_id').val(data.project_id).trigger('change');
                    $('#chart_account_id').val(data.chart_account_id).trigger('change');
                    $('#chart_group_id').val(data.chart_group_id).trigger('change');
                    $('#category_id').val(data.category_id).trigger('change');
                    $('#payment_id').val(data.payment_id).trigger('change');
                    $('#bank_id').val(data.bank_id).trigger('change');
                    $('#cheque_no').val(data.cheque_no);

                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // hide show btn
                    $('#addReceiveText').addClass('d-none');
                    $('#updateReceiveText').removeClass('d-none');
                    $('#voucher_no').text(data.id);
                    $('#addReceive').addClass('d-none');
                    $('#updateReceive').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $("#addReceiveModal").modal("show");
                    // modal show when edit button is clicked
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Receive Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        }
        // edit client using ajax

        // update data using ajax
        function updateReceive(id) {
            var receive_id = $('#row_id').val();

            var client_id = $('#client_id').val();
            var invoice_id = $('#invoice_id').val();
            var date = $('#date').val();
            var account_id = $('#account_id').val();
            var description = $('#description').val();
            var amount = $('#amount').val();
            var project_id = $('#project_id').val();
            var chart_account_id = $('#chart_account_id').val();
            var chart_group_id = $('#chart_group_id').val();
            var category_id = $('#category_id').val();
            var payment_id = $('#payment_id').val();
            var bank_id = $('#bank_id').val();
            var cheque_no = $('#cheque_no').val();
            var sms = $('#sms').is(":checked");
            var email = $('#email').is(":checked");

            var url = '{{ route('user.receive.update', ':id') }}';
            url = url.replace(':id', receive_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    client_id: client_id,
                    invoice_id: invoice_id,
                    date: date,
                    account_id: account_id,
                    description: description,
                    amount: amount,
                    project_id: project_id,
                    chart_account_id: chart_account_id,
                    chart_group_id: chart_group_id,
                    category_id: category_id,
                    payment_id: payment_id,
                    bank_id: bank_id,
                    cheque_no: cheque_no,
                    sms: sms,
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearReceiveField();

                    $("#receiveModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Receive updated successfully!',
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

                    if ($errors.invoice_id) {
                        $('#invoice_id_Error').text($errors.invoice_id);
                        $('#invoice_id').addClass('border-danger');
                        toastr.error($errors.invoice_id);
                    }

                    if ($errors.date) {
                        $('#date_Error').text($errors.date);
                        $('#date').addClass('border-danger');
                        toastr.error($errors.date);
                    }

                    if ($errors.account_id) {
                        $('#account_id_Error').text($errors.account_id);
                        $('#account_id').addClass('border-danger');
                        toastr.error($errors.account_id);
                    }

                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }

                    if ($errors.amount) {
                        $('#amount_Error').text($errors.amount);
                        $('#amount').addClass('border-danger');
                        toastr.error($errors.amount);
                    }

                    if ($errors.project_id) {
                        $('#project_id_Error').text($errors.project_id);
                        $('#project_id').addClass('border-danger');
                        toastr.error($errors.project_id);
                    }

                    if ($errors.chart_account_id) {
                        $('#chart_account_id_Error').text($errors.chart_account_id);
                        $('#chart_account_id').addClass('border-danger');
                        toastr.error($errors.chart_account_id);
                    }

                    if ($errors.chart_group_id) {
                        $('#chart_group_id_Error').text($errors.chart_group_id);
                        $('#chart_group_id').addClass('border-danger');
                        toastr.error($errors.chart_group_id);
                    }

                    if ($errors.category_id) {
                        $('#category_id_Error').text($errors.category_id);
                        $('#category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }

                    if ($errors.payment_id) {
                        $('#payment_id_Error').text($errors.payment_id);
                        $('#payment_id').addClass('border-danger');
                        toastr.error($errors.payment_id);
                    }

                    if ($errors.bank_id) {
                        $('#bank_id_Error').text($errors.bank_id);
                        $('#bank_id').addClass('border-danger');
                        toastr.error($errors.bank_id);
                    }

                    if ($errors.cheque_no) {
                        $('#cheque_no_Error').text($errors.cheque_no);
                        $('#cheque_no').addClass('border-danger');
                        toastr.error($errors.cheque_no);
                    }

                    if ($errors.status) {
                        $('#status_Error').text($errors.status);
                        $('#status').addClass('border-danger');
                        toastr.error($errors.status);
                    }

                    if ($errors.sms) {
                        $('#sms_Error').text($errors.sms);
                        $('#sms').addClass('border-danger');
                        toastr.error($errors.sms);
                    }

                    if ($errors.email) {
                        $('#email_Error').text($errors.email);
                        $('#email').addClass('border-danger');
                        toastr.error($errors.email);
                    }
                }
            })
        }
        // update data using ajax
    </script>
@endpush
