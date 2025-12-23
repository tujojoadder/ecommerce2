<div class="collapse mg-t-5 {{ $queryString == 'create-supplier-payment' || $supplier_id != null ? 'show' : '' }} {{ $queryString == 'create-staff-payment' || $supplier_id != null ? 'show' : '' }} {{ $queryString == 'create-expense' ? 'show' : '' }} {{ $queryString == 'create-money-return' ? 'show' : '' }} {{ $queryString == 'create-personal-expense' ? 'show' : '' }} {{ $queryString == 'create-daily-expense' ? 'show' : '' }}" id="addExpenseCollapse">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                @if ($queryString == 'create-money-return' || $queryString == 'money-return')
                    <h6 class="modal-title" id="addExpenseText">{{ __('messages.money') }} {{ __('messages.return') }}</h6>
                @elseif ($queryString == 'create-supplier-payment' || $supplier_id != null || $queryString == 'supplier-payment')
                    <h6 class="modal-title" id="addExpenseText">{{ __('messages.add_supplier_payment') }}</h6>
                @elseif ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null || $queryString == 'staff-payment')
                    <h6 class="modal-title" id="addExpenseText">{{ __('messages.add_staff_payment') }}</h6>
                @elseif ($queryString == 'create-personal-expense' || $queryString == 'personal-expense')
                    <h6 class="modal-title" id="addExpenseText">{{ __('messages.create') }} {{ __('messages.personal_expense') }}</h6>
                @elseif ($queryString == 'create-daily-expense' || $queryString == 'daily-expense')
                    <h6 class="modal-title" id="addExpenseText">{{ __('messages.create') }} {{ __('messages.daily_expense') }}</h6>
                @else
                    <h6 class="modal-title" id="addExpenseText">{{ __('messages.expense') }} {{ __('messages.create') }}</h6>
                @endif
                <h6 class="modal-title d-none" id="updateExpenseText">{{ __('messages.update') }} {{ __('messages.expense') }} | {{ __('messages.id_no') }}: <span id="voucher_no"></span></h6>
            </div>
            <div>
                <div class="d-flex align-items-center">
                    <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-lg btn-secondary text-white me-2 d-flex align-items-center">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                    <a href="{{ route('user.client.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-list d-inline"></i> Client List
                    </a>
                    <a href="{{ route('user.client-group.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-layer-group d-inline"></i> Client Group
                    </a>
                    @if ($queryString == 'create-expense' || $queryString == 'create-money-return' || $queryString == 'create-supplier-payment' || $queryString == 'create-staff-payment')
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/TJKc2DTtst8?si=GeqmIXdKxyVExgnL">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="expense-form">
                <div class="{{ config('expenses_date') == 1 ? '' : 'd-none' }} {{ config('expenses_expense_type') == 1 ? 'col-xl-3 col-lg-3 col-md-3 col-12' : 'col-xl-6 col-lg-6 col-md-6 col-12' }}">
                    <div class="form-group">
                        <input class="form-control fc-datepicker" name="date" id="date" placeholder="MM/DD/YYYY" value="{{ date('d/m/Y') }}" type="text" autocomplete="off">
                        <label for="date" class="animated-label active-label"><i class="fas fa-calendar-alt"></i> {{ __('messages.date') }}</label>
                    </div>
                    <span class="text-danger small" id="date_Error"></span>
                </div>
                <div class="{{ config('expenses_expense_type') == 1 ? '' : 'd-none' }} col-xl-3 col-lg-3 col-md-3 col-12">
                    <select name="expense_type" id="expense_type" class="select2 form-control" style="width: 100% !important;">
                        <option label="{{ __('messages.expense_type') }}"></option>
                        <option value="office_expense">{{ __('messages.office_expense') }}</option>
                        <option value="default" selected>{{ __('messages.default') }}</option>
                    </select>
                    <label for="expense_type" class="animated-label active-label ms-3"><i class="fas fa-calendar-alt"></i> {{ __('messages.expense_type') }}</label>
                    <span class="text-danger small" id="expense_type_Error"></span>
                </div>
                @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null || $queryString == 'staff-payment')
                    <div class="{{ config('expenses_month') == 1 ? '' : 'd-none' }} form-group col-xl-3 col-lg-3 col-md-3" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.month') }}">

                        <div class="d-flex">
                            <div class="input-group">
                                <div class="input-group">
                                    <select name="month" id="month" class="form-control month" required>
                                        <option {{ date('m') == 1 ? 'selected' : '' }} value="1">January</option>
                                        <option {{ date('m') == 2 ? 'selected' : '' }} value="2">February</option>
                                        <option {{ date('m') == 3 ? 'selected' : '' }} value="3">March</option>
                                        <option {{ date('m') == 4 ? 'selected' : '' }} value="4">April</option>
                                        <option {{ date('m') == 5 ? 'selected' : '' }} value="5">May</option>
                                        <option {{ date('m') == 6 ? 'selected' : '' }} value="6">June</option>
                                        <option {{ date('m') == 7 ? 'selected' : '' }} value="7">July</option>
                                        <option {{ date('m') == 8 ? 'selected' : '' }} value="8">August</option>
                                        <option {{ date('m') == 9 ? 'selected' : '' }} value="9">September</option>
                                        <option {{ date('m') == 10 ? 'selected' : '' }} value="10">October</option>
                                        <option {{ date('m') == 11 ? 'selected' : '' }} value="11">November</option>
                                        <option {{ date('m') == 12 ? 'selected' : '' }} value="12">December</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger small" id="month_Error"></span>
                    </div>

                    <div class="{{ config('expenses_year') == 1 ? '' : 'd-none' }} form-group col-xl-3 col-lg-3 col-md-3" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.month') }}">

                        <div class="d-flex">
                            <div class="input-group">
                                <div class="input-group">
                                    <select name="year" id="year" class="form-control year" required>
                                        @for ($i = date('Y') - 10; $i <= date('Y'); $i++)
                                            <option {{ date('Y') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger small" id="year_Error"></span>
                    </div>

                    <div class="{{ config('expenses_staff_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.staff') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="staff_id" id="staff_id" class="form-control select2 staff_id" required>
                                </select>
                            </div>
                            <a id="staffModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="staff_id_Error"></span>
                    </div>
                @endif
                <div class="{{ config('expenses_account_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.account') }}">
                    <div class="d-flex">
                        <div class="input-group">
                            <select name="account_id" id="account_id" class="form-control select2 account_id">
                            </select>
                        </div>
                        <a id="accountModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger small" id="account_id_Error"></span>
                </div>
                @if ($queryString == 'create-money-return' || $queryString == 'money-return')
                    <div class="{{ config('expenses_client_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="client_id" id="client_id" class="form-control select2" required>
                                </select>
                            </div>
                            <a id="clientAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="client_id_Error"></span>
                    </div>
                @endif
                @if ($queryString == 'create-supplier-payment' || $supplier_id != null || $queryString == 'supplier-payment')
                    <div class="{{ config('expenses_supplier_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                                </select>
                            </div>
                        </div>
                        <span class="text-danger small" id="supplier_id_Error"></span>
                    </div>

                    <div class="purchase_id_for_add_div form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.purchase') }} {{ __('messages.id_no') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="purchase_id" id="purchase_id" class="form-control select2">
                                </select>
                            </div>
                        </div>
                        <span class="text-danger small" id="purchase_id_Error"></span>
                    </div>
                @endif
                <div class="col-xl-6 col-lg-6 col-md-6 {{ config('expenses_amount') == 1 ? '' : 'd-none' }}">
                    <div class="form-group">
                        <input id="amount" type="number" step="any" class="form-control @error('amount') is-invalid @enderror" name="amount" value="" placeholder="{{ __('messages.amount') }}">
                        <label class="animated-label" for="amount"><i class="fas fa-user"></i> {{ __('messages.amount') }}</label>
                        <span class="text-danger small" id="amount_Error"></span>
                    </div>
                </div>
                <div class="{{ config('expenses_category_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.expense') }} {{ __('messages.category') }}">
                    <div class="d-flex">
                        <div class="input-group">
                            <select name="category_id" id="expense_category_id" class="form-control select2">
                            </select>
                        </div>
                        <a id="expenseCategoryBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                    </div>
                    <span class="text-danger small" id="category_id_Error"></span>
                </div>
                @if ($queryString == 'create-money-return' || $queryString == 'money-return')
                @else
                    <div class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('expenses_subcategory_id') == 1 ? '' : 'd-none' }}" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.expense') }} {{ __('messages.subcategory') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                                </select>
                            </div>
                            <a id="ExpenseSubcategoryBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="subcategory_id_Error"></span>
                    </div>
                @endif

                @if ($queryString == 'create-money-return' || $queryString == 'money-return' || $queryString == 'create-staff-payment' || $queryString == 'staff-payment')
                @else
                    <div class="{{ config('expenses_payment_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.payment') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="payment_id" id="payment_id" class="form-control select2">
                                </select>
                            </div>
                        </div>
                        <span class="text-danger small" id="payment_id_Error"></span>
                    </div>
                    <div class="{{ config('expenses_bank_id') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.bank') }}">
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="bank_id" id="bank_id" class="form-control select2">
                                </select>
                            </div>
                        </div>
                        <span class="text-danger small" id="bank_id_Error"></span>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('expenses_cheque_no') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input id="cheque_no" type="text" class="form-control @error('cheque_no') is-invalid @enderror" name="cheque_no">
                            <label class="animated-label" for="cheque_no"><i class="fas fa-money-check"></i> {{ __('messages.cheque_no') }}</label>
                        </div>
                        <span class="text-danger small" id="cheque_no_Error"></span>
                    </div>
                    <div class="{{ config('expenses_image') == 1 ? '' : 'd-none' }} form-group col-xl-6 col-lg-6 col-md-6" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="{{ __('messages.name') }}">
                        <div class="form-group">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.image') }}">
                                <input type="file" accept="image/*" name="image" class="form-control @error('image') is-invalid border-danger @enderror image" placeholder="" id="image">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div id="image-show" class=""></div>
                            </div>
                        </div>
                        <span class="text-danger small" id="image_Error"></span>
                    </div>
                @endif

                <div class="col-xl-6 col-lg-6 col-md-6 {{ config('expenses_description') == 1 ? '' : 'd-none' }}">
                    <div class="form-group">
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description">
                        <label class="animated-label" for="description"><i class="fas fa-keyboard"></i> {{ __('messages.expense') }} {{ __('messages.description') }} {{ __('messages.in_a_short_note') }}</label>
                    </div>
                    <span class="text-danger small" id="description_Error"></span>
                </div>
                <input type="hidden" id="row_id">
                <div class="col-xl-12 col-lg-12 col-md-12 text-center mb-4 mt-4">
                    <button class="btn btn-primary" type="button" id="addExpense" onclick="addExpense();"><i class="fas fa-plus"></i> {{ __('messages.add_new') }}</button>
                    <button class="btn btn-info d-none" type="button" id="updateExpense" onclick="updateExpense();"><i class="fas fa-plus"></i> {{ __('messages.update') }} {{ __('messages.expense') }}</button>
                    {{-- <a id="addExpenseBtnClose" class="btn ripple btn-danger text-white" data-bs-toggle="collapse" data-bs-target="#addExpenseCollapse" aria-expanded="true" aria-controls="addExpenseCollapse" type="button">{{ __('messages.close') }}</a> --}}
                    <a class="btn ripple btn-danger text-white" href="{{ route('user.expense.index') }}"><i class="fas fa-ban"></i> {{ __('messages.close') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('user.accounts.expense.form-setting-modal')
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchStaffs();

            fetchSuppliers();
            fetchBanks();
            fetchPaymentMethods();
            @if ($supplier_id != null)
                setTimeout(() => {
                    $("#supplier_id").val("{{ $supplier_id }}").trigger('change');
                }, 500);
            @endif
            @if ($staff_id != null)
                setTimeout(() => {
                    $("#staff_id").val("{{ $staff_id }}").trigger('change');
                }, 500);
            @endif
        });

        $(document).ready(function() {
            $('#image').change(function() {
                $('#image-show').html('');
                setTimeout(() => {
                    var file = this.files[0];
                    if (file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#image-show').append("<img class='rounded-pill' src=" + e.target.result + ">");
                            $('#image-show').addClass('card card-body mt-2 p-1');
                            $('#image-show').show();
                        };
                        reader.readAsDataURL(file);
                    }
                }, 200);
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearExpenseField() {
            $('#date').val('');
            $('#date_Error').text('');
            $('#date').removeClass('border-danger');

            $('#expense_type').val('');
            $('#expense_type_Error').text('');
            $('#expense_type').removeClass('border-danger');

            $('#account_id').val('');
            $('#account_id_Error').text('');
            $('#account_id').removeClass('border-danger');

            @if ($queryString == 'create-supplier-payment' || $supplier_id != null)
                $('#supplier_id').val('').trigger('change');
                $('#supplier_id_Error').text('');
                $('#supplier_id').removeClass('border-danger');

                $('#purchase_id').val('').trigger('change');
                $('#purchase_id_Error').text('');
                $('#purchase_id').removeClass('border-danger');
            @endif
            @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null)
                $('#staff_id').val('').trigger('change');
                $('#staff_id_Error').text('');
                $('#staff_id').removeClass('border-danger');

                $('#month').val('');
                $('#month_Error').text('');
                $('#month').removeClass('border-danger');

                $('#year').val('');
                $('#year_Error').text('');
                $('#year').removeClass('border-danger');
            @endif
            @if ($queryString == 'create-money-return')
                $('#client_id').val('').trigger('change');
                $('#client_id_Error').text('');
                $('#client_id').removeClass('border-danger');
            @endif

            $('#amount').val('');
            $('#amount_Error').text('');
            $('#amount').removeClass('border-danger');

            $('#expense_category_id').val('');
            $('#category_id_Error').text('');
            $('#expense_category_id').removeClass('border-danger');

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

            $('#image').val('');
            $('#image_Error').text('');
            $('#image').removeClass('border-danger');

            $('#description').val('');
            $('#description_Error').text('');
            $('#description').removeClass('border-danger');
        }

        $('#expense-form').find('input, textarea, select').each(function() {
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
        function addExpense() {
            // hide show btn
            $('#addExpenseText').removeClass('d-none');
            $('#updateExpenseText').addClass('d-none');
            $('#addExpense').removeClass('d-none');
            $('#updateExpense').addClass('d-none');
            // hide show btn

            var date = $('#date').val();
            var expense_type = $('#expense_type').val();
            var account_id = $('#account_id').val();
            @if ($queryString == 'create-supplier-payment' || $supplier_id != null)
                var supplier_id = $('#supplier_id').val();
                if (supplier_id.length <= 0) {
                    $('#supplier_id_Error').text('The supplier field is required');
                    $('#supplier_id').removeClass('border-danger');
                    abort();
                }
                var purchase_id = $('#purchase_id').val();
                if (supplier_id.length <= 0) {
                    $('#purchase_id_Error').text('The purchase id field is required');
                    $('#purchase_id').removeClass('border-danger');
                    abort();
                }
                var link = "{{ route('user.expense.index') }}?supplier-payment";
            @endif
            @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null)
                var staff_id = $('#staff_id').val();
                if (staff_id.length <= 0) {
                    $('#staff_id_Error').text('The staff field is required');
                    $('#staff_id').removeClass('border-danger');
                    abort();
                }
                var month = $('#month').val();
                var year = $('#year').val();
                var link = "{{ route('user.expense.index') }}?staff-payment";
            @endif
            @if ($queryString == 'create-money-return')
                var client_id = $('#client_id').val();
                if (client_id.length <= 0) {
                    $('#client_id_Error').text('The client field is required');
                    $('#client_id').removeClass('border-danger');
                    abort();
                }
                var link = "{{ route('user.expense.index') }}?money-payment";
            @endif
            @if ($queryString == 'create-personal-expense' || $queryString == 'personal-expense')
                var personal_expense = 'personal_expense';
                var link = "{{ route('user.expense.index') }}?personal-expense";
            @endif
            @if ($queryString == 'create-daily-expense' || $queryString == 'daily-expense')
                var daily_expense = 'daily_expense';
                var link = "{{ route('user.expense.index') }}?daily-expense";
            @else
                var link = "{{ route('user.expense.index') }}";
            @endif

            var amount = $('#amount').val();
            var category_id = $('#expense_category_id').val();
            var subcategory_id = $('#subcategory_id').val();
            var payment_id = $('#payment_id').val();
            var bank_id = $('#bank_id').val();
            var cheque_no = $('#cheque_no').val();
            var image = $('#image')[0].files[0] ?? '';
            var description = $('#description').val();
            var formData = new FormData();
            formData.append('date', date);
            formData.append('expense_type', expense_type);
            formData.append('account_id', account_id);
            @if ($queryString == 'create-personal-expense' || $queryString == 'personal-expense')
                formData.append('transaction_type', personal_expense ?? '');
            @endif
            @if ($queryString == 'create-daily-expense' || $queryString == 'daily-expense')
                formData.append('transaction_type', daily_expense ?? '');
            @endif
            @if ($queryString == 'create-supplier-payment' || $supplier_id != null)
                formData.append('supplier_id', supplier_id ?? '');
                formData.append('purchase_id', purchase_id ?? '');
                formData.append('transaction_type', 'supplier_payment');
            @endif
            @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null)
                formData.append('staff_id', staff_id ?? '');
                formData.append('month', month ?? '');
                formData.append('year', year ?? '');
                formData.append('transaction_type', 'staff_payment');
            @endif
            @if ($queryString == 'create-money-return')
                formData.append('client_id', client_id ?? '');
                formData.append('transaction_type', 'money_return');
            @endif
            formData.append('amount', amount ?? '');
            formData.append('category_id', category_id ?? '');
            formData.append('subcategory_id', subcategory_id ?? '');
            formData.append('payment_id', payment_id ?? '');
            formData.append('bank_id', bank_id ?? '');
            formData.append('cheque_no', cheque_no ?? '');
            formData.append('image', image ?? '');
            formData.append('description', description ?? '');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                type: "POST",
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                url: "{{ route('user.expense.store') }}",
                success: function(group) {
                    clearExpenseField();

                    $("#addExpenseBtnClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Expense added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.href = link;
                    $('.yajra-datatable').DataTable().ajax.reload();
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;

                    if ($errors.date) {
                        $('#date_Error').text($errors.date);
                        $('#date').addClass('border-danger');
                        toastr.error($errors.date);
                    }
                    if ($errors.expense_type) {
                        $('#expense_type_Error').text($errors.expense_type);
                        $('#expense_type').addClass('border-danger');
                        toastr.error($errors.expense_type);
                    }
                    if ($errors.account_id) {
                        $('#account_id_Error').text($errors.account_id);
                        $('#account_id').addClass('border-danger');
                        toastr.error($errors.account_id);
                    }
                    @if ($queryString == 'create-supplier-payment' || $supplier_id != null)
                        if ($errors.supplier_id) {
                            $('#supplier_id_Error').text($errors.supplier_id);
                            $('#supplier_id').addClass('border-danger');
                            toastr.error($errors.supplier_id);
                        }
                        if ($errors.purchase_id) {
                            $('#purchase_id_Error').text($errors.purchase_id);
                            $('#purchase_id').addClass('border-danger');
                            toastr.error($errors.purchase_id);
                        }
                    @endif
                    @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null)
                        if ($errors.staff_id) {
                            $('#staff_id_Error').text($errors.staff_id);
                            $('#staff_id').addClass('border-danger');
                            toastr.error($errors.staff_id);
                        }
                    @endif
                    if ($errors.amount) {
                        $('#amount_Error').text($errors.amount);
                        $('#amount').addClass('border-danger');
                        toastr.error($errors.amount);
                    }
                    if ($errors.category_id) {
                        $('#category_id_Error').text($errors.category_id);
                        $('#expense_category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }
                    if ($errors.subcategory_id) {
                        $('#subcategory_id_Error').text($errors.subcategory_id);
                        $('#subcategory_id').addClass('border-danger');
                        toastr.error($errors.subcategory_id);
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
                    if ($errors.image) {
                        $('#image_Error').text($errors.image);
                        $('#image').addClass('border-danger');
                        toastr.error($errors.image);
                    }
                    if ($errors.description) {
                        $('#description_Error').text($errors.description);
                        $('#description').addClass('border-danger');
                        toastr.error($errors.description);
                    }

                }
            })
        }
        // add client using ajax


        // edit client using ajax
        function editExpense(id) {
            var data_id = id;
            var url = '{{ route('user.expense.edit', ':id') }}';
            url = url.replace(':id', data_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    // adding the data to fields
                    $('.animated-label').addClass('active-label');
                    $('#date').val(data.date);
                    $('#expense_type').val(data.expense_type).trigger('change');
                    getAccountInfo('/get-account', data.account_id);
                    @if ($queryString == 'money-return')
                        getClientInfo('/get-client-info', data.client_id);
                    @endif
                    @if ($queryString == 'create-supplier-payment' || $queryString == 'supplier-payment')
                        getSupplierInfo('/get-supplier-info', data.supplier_id);
                        // $('#supplier_id').val(data.supplier_id).trigger('change');
                        $('#purchase_id').val(data.purchase_id).trigger('change');
                    @endif
                    @if ($queryString == 'staff-payment')
                        setTimeout(() => {
                            $("#staff_id").val(data.staff_id).trigger('change');
                        }, 500);
                        $('#month').val(data.month);
                        $('#year').val(data.year);
                    @endif
                    setInterval(() => {
                        $('#amount').val(data.amount);
                    }, 500);
                    getExpenseCategoryInfo('/get-expense-category', data.category_id);
                    // $('#expense_category_id').val(data.category_id).trigger('change');
                    getExpenseSubCategoryInfo('/get-expense-subcategory', data.subcategory_id);
                    // $('#subcategory_id').val(data.subcategory_id).trigger('change');
                    getPaymentMethodInfo('/get-payment-method', data.payment_id);
                    // $('#payment_id').val(data.payment_id).trigger('change');
                    $('#bank_id').val(data.bank_id).trigger('change');;
                    $('#cheque_no').val(data.cheque_no);
                    $('#image').val();
                    $('#description').val(data.description);

                    $('#row_id').val(data.id);
                    // adding the data to fields

                    // hide show btn
                    $('#addExpenseText').addClass('d-none');
                    $('#updateExpenseText').removeClass('d-none');
                    $('#voucher_no').text(data.id);
                    $('#addExpense').addClass('d-none');
                    $('#updateExpense').removeClass('d-none');
                    // hide show btn

                    // modal show when edit button is clicked
                    $('#addExpenseCollapse').collapse('show');
                    // modal show when edit button is clicked

                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
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
        function updateExpense(id) {
            var expense_id = $('#row_id').val();

            var date = $('#date').val();
            var expense_type = $('#expense_type').val();
            var account_id = $('#account_id').val();
            @if ($queryString == 'create-supplier-payment' || $queryString == 'supplier-payment')
                var supplier_id = $('#supplier_id').val();
                var purchase_id = $('#purchase_id').val();
                var link = "{{ route('user.expense.index') }}?supplier-payment";
            @endif
            @if ($queryString == 'staff-payment' || $queryString == 'create-staff-payment')
                var staff_id = $('#staff_id').val();
                var month = $('#month').val();
                var year = $('#year').val();
                var link = "{{ route('user.expense.index') }}?staff-payment";
            @endif
            @if ($queryString == 'create-personal-expense' || $queryString == 'personal-expense')
                var personal_expense = 'personal_expense';
                var link = "{{ route('user.expense.index') }}?personal-expense";
            @endif
            @if ($queryString == 'create-daily-expense' || $queryString == 'daily-expense')
                var daily_expense = 'daily_expense';
                var link = "{{ route('user.expense.index') }}?daily-expense";
            @else
                var link = "{{ route('user.expense.index') }}";
            @endif
            var amount = $('#amount').val();
            var category_id = $('#expense_category_id').val();
            var subcategory_id = $('#subcategory_id').val();
            var payment_id = $('#payment_id').val();
            var bank_id = $('#bank_id').val();
            var cheque_no = $('#cheque_no').val();
            var image = $('#image').val();
            var description = $('#description').val();

            var url = '{{ route('user.expense.update', ':id') }}';
            url = url.replace(':id', expense_id);
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: {
                    date: date,
                    expense_type: expense_type,
                    account_id: account_id,
                    @if ($queryString == 'create-personal-expense' || $queryString == 'personal-expense')
                        transaction_type: personal_expense,
                    @endif
                    @if ($queryString == 'create-daily-expense' || $queryString == 'daily-expense')
                        transaction_type: daily_expense,
                    @endif
                    @if ($queryString == 'create-supplier-payment' || $queryString == 'supplier-payment')
                        supplier_id: supplier_id,
                        purchase_id: purchase_id,
                        transaction_type: 'supplier_payment',
                    @endif
                    @if ($queryString == 'staff-payment' || $queryString == 'create-staff-payment')
                        staff_id: staff_id,
                        month: month,
                        year: year,
                        transaction_type: 'staff_payment',
                    @endif
                    amount: amount,
                    category_id: category_id,
                    subcategory_id: subcategory_id,
                    payment_id: payment_id,
                    bank_id: bank_id,
                    cheque_no: cheque_no,
                    image: image,
                    description: description,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                url: url,
                success: function(group) {
                    clearExpenseField();

                    $('#addExpenseCollapse').collapse('toggle');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Expense updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.yajra-datatable').DataTable().ajax.reload();
                    location.href = link;
                },
                error: function(error) {
                    var $errors = error.responseJSON.errors;
                    if ($errors.date) {
                        $('#date_Error').text($errors.date);
                        $('#date').addClass('border-danger');
                        toastr.error($errors.date);
                    }
                    if ($errors.expense_type) {
                        $('#expense_type_Error').text($errors.expense_type);
                        $('#expense_type').addClass('border-danger');
                        toastr.error($errors.expense_type);
                    }
                    if ($errors.account_id) {
                        $('#account_id_Error').text($errors.account_id);
                        $('#account_id').addClass('border-danger');
                        toastr.error($errors.account_id);
                    }
                    @if ($queryString == 'create-supplier-payment' || $supplier_id != null)
                        if ($errors.supplier_id) {
                            $('#supplier_id_Error').text($errors.supplier_id);
                            $('#supplier_id').addClass('border-danger');
                            toastr.error($errors.supplier_id);
                        }
                        if ($errors.purchase_id) {
                            $('#purchase_id_Error').text($errors.purchase_id);
                            $('#purchase_id').addClass('border-danger');
                            toastr.error($errors.purchase_id);
                        }
                    @endif
                    @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null)
                        if ($errors.staff_id) {
                            $('#staff_id_Error').text($errors.staff_id);
                            $('#staff_id').addClass('border-danger');
                            toastr.error($errors.staff_id);
                        }
                        if ($errors.month) {
                            $('#month_Error').text($errors.month);
                            $('#month').addClass('border-danger');
                            toastr.error($errors.month);
                        }
                        if ($errors.year) {
                            $('#year_Error').text($errors.year);
                            $('#year').addClass('border-danger');
                            toastr.error($errors.year);
                        }
                    @endif
                    if ($errors.amount) {
                        $('#amount_Error').text($errors.amount);
                        $('#amount').addClass('border-danger');
                        toastr.error($errors.amount);
                    }
                    if ($errors.category_id) {
                        $('#category_id_Error').text($errors.category_id);
                        $('#expense_category_id').addClass('border-danger');
                        toastr.error($errors.category_id);
                    }
                    if ($errors.subcategory_id) {
                        $('#subcategory_id_Error').text($errors.subcategory_id);
                        $('#subcategory_id').addClass('border-danger');
                        toastr.error($errors.subcategory_id);
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
                    if ($errors.image) {
                        $('#image_Error').text($errors.image);
                        $('#image').addClass('border-danger');
                        toastr.error($errors.image);
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
