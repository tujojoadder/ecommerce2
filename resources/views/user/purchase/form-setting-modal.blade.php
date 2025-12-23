    <div class="modal fade" id="formSettingModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Receive Form Settings</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Invoice ID</span>
                                <input type="checkbox" name="invoice_id" class="form-switch-input" {{ config('purchases_invoice_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Issued Date</span>
                                <input type="checkbox" name="issued_date" class="form-switch-input" {{ config('purchases_issued_date') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Supplier</span>
                                <input type="checkbox" name="supplier_id" class="form-switch-input" {{ config('purchases_supplier_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Warehouse</span>
                                <input type="checkbox" name="warehouse_id" class="form-switch-input" {{ config('purchases_warehouse_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Discount</span>
                                <input type="checkbox" name="discount" class="form-switch-input" {{ config('purchases_discount') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Transport Fare</span>
                                <input type="checkbox" name="transport_fare" class="form-switch-input" {{ config('purchases_transport_fare') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Vat</span>
                                <input type="checkbox" name="vat" class="form-switch-input" {{ config('purchases_vat') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Accounts</span>
                                <input type="checkbox" name="account_id" class="form-switch-input" {{ config('purchases_account_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Category</span>
                                <input type="checkbox" name="category_id" class="form-switch-input" {{ config('purchases_category_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">Receive Amount</span>
                                <input type="checkbox" name="receive_amount" class="form-switch-input" {{ config('purchases_receive_amount') == 1 ? 'checked' : '' }}>
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
                var table_name = 'purchases';
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
