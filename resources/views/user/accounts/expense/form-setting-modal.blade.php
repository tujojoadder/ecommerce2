<div class="modal fade" id="formSettingModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Receive Form Settings</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="form-group col-md-6">
                        <label class="input-group form-control d-flex justify-content-between">
                            <span class="form-switch-description tx-15 me-2">Date</span>
                            <input type="checkbox" name="date" class="form-switch-input" {{ config('expenses_date') == 1 ? 'checked' : '' }}>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                    </div> --}}

                    <div class="form-group col-md-6">
                        <label class="input-group form-control d-flex justify-content-between">
                            <span class="form-switch-description tx-15 me-2">{{ __('messages.expense_type') }}</span>
                            <input type="checkbox" name="expense_type" class="form-switch-input" {{ config('expenses_expense_type') == 1 ? 'checked' : '' }}>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                    </div>

                    @if ($queryString == 'create-staff-payment' || $queryString == 'staff-payment' || $staff_id != null || $queryString == 'staff-payment')
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Month</span>
                                <input type="checkbox" name="month" class="form-switch-input" {{ config('expenses_month') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Year</span>
                                <input type="checkbox" name="year" class="form-switch-input" {{ config('expenses_year') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Staffs</span>
                                <input type="checkbox" name="staff_id" class="form-switch-input" {{ config('expenses_staff_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    @endif

                    {{-- <div class="form-group col-md-6">
                        <label class="input-group form-control d-flex justify-content-between">
                            <span class="form-switch-description tx-15 me-2">Accounts</span>
                            <input type="checkbox" name="account_id" class="form-switch-input" {{ config('expenses_account_id') == 1 ? 'checked' : '' }}>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                    </div> --}}
                    @if ($queryString == 'create-money-return' || $queryString == 'money-return')
                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Clients</span>
                                <input type="checkbox" name="client_id" class="form-switch-input" {{ config('expenses_client_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}
                    @endif

                    @if ($queryString == 'create-supplier-payment' || $supplier_id != null || $queryString == 'supplier-payment')
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Suppliers</span>
                                <input type="checkbox" name="supplier_id" class="form-switch-input" {{ config('expenses_supplier_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Purchase ID</span>
                                <input type="checkbox" name="purchase_id" class="form-switch-input" {{ config('expenses_purchase_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    @endif

                    {{-- <div class="form-group col-md-6">
                        <label class="input-group form-control d-flex justify-content-between">
                            <span class="form-switch-description tx-15 me-2">Amount</span>
                            <input type="checkbox" name="amount" class="form-switch-input" {{ config('expenses_amount') == 1 ? 'checked' : '' }}>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                    </div> --}}

                    {{-- <div class="form-group col-md-6">
                        <label class="input-group form-control d-flex justify-content-between">
                            <span class="form-switch-description tx-15 me-2">Category</span>
                            <input type="checkbox" name="category_id" class="form-switch-input" {{ config('expenses_category_id') == 1 ? 'checked' : '' }}>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                    </div> --}}
                    @if ($queryString == 'create-money-return' || $queryString == 'money-return')
                    @else
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Sub Category</span>
                                <input type="checkbox" name="subcategory_id" class="form-switch-input" {{ config('expenses_subcategory_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    @endif

                    @if ($queryString == 'create-money-return' || $queryString == 'money-return' || $queryString == 'create-staff-payment' || $queryString == 'staff-payment')
                    @else
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Payment Methods</span>
                                <input type="checkbox" name="payment_id" class="form-switch-input" {{ config('expenses_payment_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Banks</span>
                                <input type="checkbox" name="bank_id" class="form-switch-input" {{ config('expenses_bank_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Cheque No</span>
                                <input type="checkbox" name="cheque_no" class="form-switch-input" {{ config('expenses_cheque_no') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Image</span>
                                <input type="checkbox" name="image" class="form-switch-input" {{ config('expenses_image') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    @endif

                    <div class="form-group col-md-6">
                        <label class="input-group form-control d-flex justify-content-between">
                            <span class="form-switch-description tx-15 me-2">Description</span>
                            <input type="checkbox" name="description" class="form-switch-input" {{ config('expenses_description') == 1 ? 'checked' : '' }}>
                            <span class="form-switch-indicator form-switch-indicator-lg"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-info" data-bs-dismiss="modal" type="button">Save</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function capitalizeWords(str) {
            return str.replace(/\b\w/g, function(match) {
                return match.toUpperCase();
            });
        }
        $("#formSettingModal input").on('click', function() {
            var table_name = 'expenses';
            var field_name = $(this).prop("name");
            var status = $(this).prop("checked");

            var url = '{{ route('enable.disable.field', [':table', ':field']) }}';
            url = url.replace(':table', table_name).replace(':field', field_name);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    var name = field_name.replace(/_/g, ' ');
                    toastr.success(capitalizeWords(name) + " Successfully Updated!");
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Not Found!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        $('#formSettingModal').on('hidden.bs.modal', function() {
            location.reload(); // Reload the page when the modal is closed
        });
    </script>
@endpush
