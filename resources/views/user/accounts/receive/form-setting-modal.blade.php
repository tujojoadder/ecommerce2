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
                                <span class="form-switch-description tx-15 me-2">Clients</span>
                                <input type="checkbox" name="client_id" class="form-switch-input" {{ config('receives_client_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Invoices</span>
                                <input type="checkbox" name="invoice_id" class="form-switch-input" {{ config('receives_invoice_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Date</span>
                                <input type="checkbox" name="date" class="form-switch-input" {{ config('receives_date') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Account</span>
                                <input type="checkbox" name="account_id" class="form-switch-input" {{ config('receives_account_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Description</span>
                                <input type="checkbox" name="description" class="form-switch-input" {{ config('receives_description') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Amount</span>
                                <input type="checkbox" name="amount" class="form-switch-input" {{ config('receives_amount') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        {{-- <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Project</span>
                                <input type="checkbox" name="project_id" class="form-switch-input" {{ config('receives_project_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Chart Account</span>
                                <input type="checkbox" name="chart_account_id" class="form-switch-input" {{ config('receives_chart_account_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Chart Group</span>
                                <input type="checkbox" name="chart_group_id" class="form-switch-input" {{ config('receives_chart_group_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div> --}}

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Category</span>
                                <input type="checkbox" name="category_id" class="form-switch-input" {{ config('receives_category_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Payment</span>
                                <input type="checkbox" name="payment_id" class="form-switch-input" {{ config('receives_payment_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Bank</span>
                                <input type="checkbox" name="bank_id" class="form-switch-input" {{ config('receives_bank_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Cheque No</span>
                                <input type="checkbox" name="cheque_no" class="form-switch-input" {{ config('receives_cheque_no') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">SMS</span>
                                <input type="checkbox" name="sms" class="form-switch-input" {{ config('receives_sms') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Email</span>
                                <input type="checkbox" name="email" class="form-switch-input" {{ config('receives_email') == 1 ? 'checked' : '' }}>
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
                var table_name = 'receives';
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
