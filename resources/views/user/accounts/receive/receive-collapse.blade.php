@php
    $client_id = $_GET['client_id'] ?? '';
@endphp
<div class="collapse {{ $queryString == 'create' || $queryString == 'supplier-receive' || $client_id ? 'show' : '' }} mg-t-5" id="addReceiveCollapse">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h6 class="modal-title" id="addReceiveText">{{ __('messages.add_new_receive') }}</h6>
                <h6 class="modal-title d-none" id="updateReceiveText">{{ __('messages.update') }} {{ __('messages.receive') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="d-flex">
                    <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2 d-flex align-items-center">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                    <a href="{{ route('user.receive.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-list d-inline"></i> {{ __('messages.receive') }} {{ __('messages.list') }}
                    </a>
                    <a href="{{ route('user.receive-category.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-layer-group d-inline"></i> {{ __('messages.receive') }} {{ __('messages.category') }}
                    </a>
                </div>
                @if ($queryString == 'create' || $queryString == 'supplier-receive' || $client_id)
                    <div class="d-flex">
                        <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/gplWthmKLec?si=6bTaz7Lyz_JGIg6r">
                            <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="receive-form">
                <div class="form-group mb-3 col-xl-6 col-lg-6 col-md-6 {{ config('receives_client_id') == 1 ? ($queryString == 'supplier-receive' ? 'd-none' : '') : 'd-none' }}" id="client_id_div">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                        <div class="input-group">
                            <select name="client_id" id="client_id" class="form-control client_id"></select>
                        </div>
                        <a id="clientAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small ms-2" id="client_id_Error"></span>
                </div>
                <div class="form-group mb-3 col-xl-6 col-lg-6 col-md-6 {{ config('receives_client_id') == 1 ? ($queryString == 'supplier-receive' ? '' : 'd-none') : 'd-none' }}" id="supplier_id_div">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                        <div class="input-group">
                            <select name="supplier_id" id="supplier_id" class="form-control supplier_id"></select>
                        </div>
                        <a id="supplierAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small ms-2" id="supplier_id_Error"></span>
                </div>
                <div class="form-group mb-3 col-xl-6 col-lg-6 col-md-6 {{ config('receives_invoice_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.invoice') }}">
                        <div class="input-group">
                            <select name="invoice_id" id="invoice_id" class="form-control select2"></select>
                        </div>
                        <a class="add-btn btn btn-success" href="{{ route('user.invoice.index') }}?create"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small ms-2" id="invoice_id_Error"></span>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 {{ config('receives_date') == 1 ? '' : 'd-none' }}">
                    <div class="form-group">
                        <input name="date" id="date" class="form-control fc-datepicker" placeholder="{{ __('messages.date') }}" value="{{ date('d/m/Y') }}" type="text" autocomplete="off">
                        <label class="animated-label active-label" for="date"><i class="fas fa-money-check"></i> {{ __('messages.date') }}</label>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="date_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_account_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.account') }}">
                        <div class="input-group">
                            <select name="account_id" id="account_id" class="form-control select2 account_id"></select>
                        </div>
                        <a id="accountModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="account_id_Error"></span>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 {{ config('receives_description') == 1 ? '' : 'd-none' }}">
                    <div class="form-group">
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" @error('description') autofocus @enderror placeholder="{{ __('messages.description') }}">
                        <label class="animated-label" for="description"><i class="fas fa-sticky-note"></i> {{ __('messages.receive') }} {{ __('messages.description') }}</label>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 {{ config('receives_amount') == 1 ? '' : 'd-none' }}">
                    <div class="form-group">
                        <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" @error('amount') @enderror>
                        <label class="animated-label" id="amount-label" for="amount">{{ config('company.currency_symbol') }} {{ __('messages.amount') }}</label>
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_project_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.project') }}">
                        <div class="input-group">
                            <select name="project_id" id="project_id" class="form-control select2"></select>
                        </div>
                        <a id="projectAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="project_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_chart_account_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.chart_of_account') }}">
                        <span class="input-group-text"><i class="fas fa-university" title="{{ __('messages.chart_of_account') }}"></i></span>
                        <div class="input-group">
                            <select name="chart_account_id" id="chart_account_id" class="form-control select2"></select>
                        </div>
                        <a id="chartOfAccountBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="chart_account_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_chart_group_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.chart_of_account_group') }}">
                        <div class="input-group">
                            <select name="chart_group_id" id="chart_group_id" class="form-control select2"></select>
                        </div>
                        <a id="chartOfAccountGroup" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="chart_group_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_category_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.receive') }} {{ __('messages.category') }}">
                        <div class="input-group">
                            <select name="category_id" id="category_id" class="form-control select2 receive_category_id"></select>
                        </div>
                        <a id="receiveCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="category_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_subcategory_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.receive') }} {{ __('messages.subcategory') }}">
                        <div class="input-group">
                            <select name="subcategory_id" id="subcategory_id" class="form-control select2"></select>
                        </div>
                        <a id="receiveSubCategoryAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="subcategory_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_payment_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.payment') }}">
                        <div class="input-group">
                            <select name="payment_id" id="payment_id" class="form-control select2"></select>
                        </div>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="payment_id_Error"></span>
                </div>
                <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('receives_bank_id') == 1 ? '' : 'd-none' }}">
                    <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.bank') }}">
                        <div class="input-group">
                            <select name="bank_id" id="bank_id" class="form-control select2"></select>
                        </div>
                    </div>
                    <span class="text-danger font-weight-bolder small" id="bank_id_Error"></span>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 {{ config('receives_cheque_no') == 1 ? '' : 'd-none' }}">
                    <div class="form-group">
                        <input id="cheque_no" type="text" class="form-control @error('cheque_no') is-invalid @enderror" name="cheque_no" @error('cheque_no') autofocus @enderror>
                        <label class="animated-label" for="cheque_no"><i class="fas fa-money-check"></i> {{ __('messages.check_no') }}</label>
                        @error('cheque_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="form-group mb-0 col-xl-3 col-lg-3 col-md-3 col-6 {{ config('receives_sms') == 1 ? '' : 'd-none' }}">
                    <label class="input-group form-control d-flex justify-content-between py-1 checkbox-input" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.sms') }}">
                        <span class="form-switch-description tx-15 me-2">
                            <i class="fas fa-sms"></i> {{ __('messages.sms') }}
                        </span>
                        <input type="checkbox" name="send_sms" id="send_sms" class="form-switch-input form-control-sm" {{ config('receives_sms') == 1 ? 'checked' : '' }}>
                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                    </label>
                    <span class="text-danger font-weight-bolder small" id="send_sms_Error"></span>
                </div>

                <div class="form-group mb-0 col-xl-3 col-lg-3 col-md-3 col-6 {{ config('receives_email') == 1 ? '' : 'd-none' }}">
                    <label class="input-group form-control d-flex justify-content-between py-1 checkbox-input" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.email') }}">
                        <span class="form-switch-description tx-15 me-2">
                            <i class="fas fa-at"></i> {{ __('messages.email') }}
                        </span>
                        <input type="checkbox" name="send_email" id="send_email" class="form-switch-input form-control-sm" {{ config('receives_email') == 1 ? 'checked' : '' }}>
                        <span class="form-switch-indicator form-switch-indicator-lg"></span>
                    </label>
                    <span class="text-danger font-weight-bolder small" id="send_email_Error"></span>
                </div>
                <input type="hidden" id="row_id">
                <div class="form-group mt-4 col-xl-12 col-lg-12 col-md-12">
                    <div class="text-center">
                        <button class="btn btn-primary" type="button" id="addReceive" onclick="addReceive();"><i class="fas fa-plus"></i> {{ __('messages.add_new_receive') }}</button>
                        <button class="btn btn-info d-none" type="button" id="updateReceive" onclick="updateReceive();"><i class="fas fa-plus"></i> {{ __('messages.update') }} {{ __('messages.receive') }}</button>
                        {{-- <a id="addReceiveBtnClose" class="btn ripple btn-danger text-white" data-bs-toggle="collapse" data-bs-target="#addReceiveCollapse" aria-expanded="true" aria-controls="addReceiveCollapse" type="button">{{ __('messages.close') }}</a> --}}
                        <a class="btn ripple btn-danger text-white" href="{{ route('user.receive.index') }}" type="button"><i class="fas fa-ban"></i> {{ __('messages.close') }}</a>
                    </div>
                </div>
            </div>
            {{-- form field end --}}
        </div>
    </div>

</div>
@include('user.accounts.receive.form-setting-modal')
@include('user.supplier.supplier-add-modal')
@push('scripts')
    <script src="{{ asset('dashboard/js/get-client-info.js') }}"></script>
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                var client_id = "{{ $client_id }}";
                getClientInfo('/get-client-info', client_id);
            }, 1000);
        });
    </script>
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

            $('#supplier_id').val('');
            $('#supplier_id_Error').text('');
            $('#supplier_id').removeClass('border-danger');

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

            $('#subcategory_id').val('');
            $('#subcategory_id_Error').text('');
            $('#subcategory_id').removeClass('border-danger');

            $('#payment_id').val('');
            $('#payment_id_Error').text('');
            $('#payment_id').removeClass('border-danger');

            $('#bank_id').val('');
            $('#bank_id_Error').text('');
            $('#bank_id').removeClass('border-danger');

            $('#cheque_no').val('');
            $('#cheque_no_Error').text('');
            $('#cheque_no').removeClass('border-danger');

            $('#send_sms').is(":checked");
            $('#send_sms_Error').text('');
            $('#send_sms').removeClass('border-danger');

            $('#send_email').is(":checked");
            $('#send_email_Error').text('');
            $('#send_email').removeClass('border-danger');
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

        // add client using ajax
        function addReceive() {
            $("#addReceive").attr('disabled', '');
            var client_id = $('#client_id').val();
            var supplier_id = $('#supplier_id').val();
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
            var send_sms = $('#send_sms').is(":checked");
            var send_email = $('#send_email').is(":checked");

            if (amount <= 0) {
                Swal.fire({
                    toast: true,
                    position: 'top',
                    icon: 'error',
                    title: 'Amount can not be zero (0)!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#amount").focus();

                setTimeout(() => {
                    $("#addReceive").removeAttr('disabled', '');
                }, 2000);
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        client_id: client_id,
                        supplier_id: supplier_id,
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
                        send_sms: send_sms,
                        send_email: send_email,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('user.receive.store') }}",
                    success: function(group) {
                        clearReceiveField();

                        $('#addReceiveCollapse').collapse('toggle');
                        if (group.balance_status == false) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Received added successfully! But sms can\'t send right now!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Receive added successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        $('.yajra-datatable').DataTable().ajax.reload();
                        @if ($queryString == 'create' || $queryString == 'supplier-receive' || $client_id)
                            setTimeout(() => {
                                location.href = "{{ route('user.receive.index') }}";
                            }, 1500);
                        @endif
                    },
                    error: function(error) {
                        var $errors = error.responseJSON.errors;
                        setTimeout(() => {
                            $("#addReceive").removeAttr('disabled', '');
                        }, 2000);

                        if ($errors.client_id) {
                            $('#client_id_Error').text($errors.client_id);
                            $('#client_id').addClass('border-danger');
                            toastr.error($errors.client_id);
                        }

                        if ($errors.supplier_id) {
                            $('#supplier_id_Error').text($errors.supplier_id);
                            $('#supplier_id').addClass('border-danger');
                            toastr.error($errors.supplier_id);
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

                        if ($errors.send_sms) {
                            $('#send_sms_Error').text($errors.send_sms);
                            $('#send_sms').addClass('border-danger');
                            toastr.error($errors.send_sms);
                        }

                        if ($errors.send_email) {
                            $('#send_email_Error').text($errors.send_email);
                            $('#send_email').addClass('border-danger');
                            toastr.error($errors.send_email);
                        }
                    }
                })
            }

        }
        // add client using ajax

        // edit client using ajax
        function editReceive(id) {
            $("#updateReceive").removeAttr('disabled', '');
            var data_id = id;
            var url = '{{ route('user.receive.edit', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    // adding the data to fields
                    if (data.client_id == null) {
                        $("#supplier_id_div").removeClass('d-none');
                        $("#client_id_div").addClass('d-none');

                        var html = '<option value="' + data.supplier_id + '">' + data.supplier_name + '</option>'
                        $('#supplier_id').html(html);
                        $('#supplier_id').val(data.supplier_id).trigger('change');
                    } else {
                        $("#client_id_div").removeClass('d-none');
                        $("#supplier_id_div").addClass('d-none');

                        var html = '<option value="' + data.client_id + '">' + data.client_name + '</option>'
                        $('#client_id').html(html);
                        $('#client_id').val(data.client_id).trigger('change');
                    }

                    setTimeout(() => {
                        $('#invoice_id').val(data.invoice_id).trigger('change');
                    }, 1000);
                    $('#date').val(data.date);

                    getAccountInfo('/get-account', data.account_id);
                    $('#account_id').val(data.account_id).trigger('change');

                    $('#description').val(data.description);
                    $('#project_id').val(data.project_id).trigger('change');
                    $('#chart_account_id').val(data.chart_account_id).trigger('change');
                    $('#chart_group_id').val(data.chart_group_id).trigger('change');
                    $('#category_id').val(data.category_id).trigger('change');

                    getPaymentMethodInfo('/get-payment-method', data.payment_id);
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
                    $('#addReceiveCollapse').collapse('show');
                    // modal show when edit button is clicked

                    // scroll top when clicked
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");

                    $(".animated-label").addClass('active-label');
                    setTimeout(() => {
                        $('#amount').val(data.amount);
                    }, 1500);
                },
                error: function(error) {
                    setTimeout(() => {
                        $("#updateReceive").attr('disabled', '');
                    }, 3000);
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
            var supplier_id = $('#supplier_id').val();
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
            var send_sms = $('#send_sms').is(":checked");
            var send_email = $('#send_email').is(":checked");

            var url = '{{ route('user.receive.update', ':id') }}';
            url = url.replace(':id', receive_id);
            if (amount <= 0) {
                Swal.fire({
                    toast: true,
                    position: 'top',
                    icon: 'error',
                    title: 'Amount can not be zero (0)!',
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#amount").focus();
            } else {
                $.ajax({
                    type: "PUT",
                    dataType: "json",
                    data: {
                        client_id: client_id,
                        supplier_id: supplier_id,
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
                        send_sms: send_sms,
                        send_email: send_email,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url,
                    success: function(group) {
                        clearReceiveField();

                        // $("#receiveModalClose").click();
                        $('#addReceiveCollapse').collapse('toggle');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Receive updated successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.yajra-datatable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        var $errors = error.responseJSON.errors;
                        if ($errors.client_id) {
                            $('#client_id_Error').text($errors.client_id);
                            $('#client_id').addClass('border-danger');
                            toastr.error($errors.client_id);
                        }

                        if ($errors.supplier_id) {
                            $('#supplier_id_Error').text($errors.supplier_id);
                            $('#supplier_id').addClass('border-danger');
                            toastr.error($errors.supplier_id);
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

                        if ($errors.send_sms) {
                            $('#send_sms_Error').text($errors.send_sms);
                            $('#send_sms').addClass('border-danger');
                            toastr.error($errors.send_sms);
                        }

                        if ($errors.send_email) {
                            $('#send_email_Error').text($errors.send_email);
                            $('#send_email').addClass('border-danger');
                            toastr.error($errors.send_email);
                        }
                    }
                })
            }
        }
        // update data using ajax
    </script>
@endpush
