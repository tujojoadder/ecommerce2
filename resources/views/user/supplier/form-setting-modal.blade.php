    <div class="modal fade" id="supplierFormSettingModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('messages.supplier') }} {{ __('messages.settings') }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 {{-- config('suppliers_supplier_name') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.supplier') }} {{ __('messages.name') }}</span>
                                <input type="checkbox" name="supplier_name" class="form-switch-input" {{ config('suppliers_supplier_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_company_name') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.company') }} {{ __('messages.name') }}</span>
                                <input type="checkbox" name="company_name" class="form-switch-input" {{ config('suppliers_company_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_phone') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }}</span>
                                <input type="checkbox" name="phone" class="form-switch-input" {{ config('suppliers_phone') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('suppliers_phone_optional') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }} ({{ __('messages.optional') }})</span>
                                <input type="checkbox" name="phone_optional" class="form-switch-input" {{ config('suppliers_phone_optional') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_email') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.email') }}</span>
                                <input type="checkbox" name="email" class="form-switch-input" {{ config('suppliers_email') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_previous_due') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.previous_due') }}</span>
                                <input type="checkbox" name="previous_due" class="form-switch-input" {{ config('suppliers_previous_due') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_address') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me75">{{ __('messages.present') }} {{ __('messages.address') }}</span>
                                <input type="checkbox" name="address" class="form-switch-input" {{ config('suppliers_address') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('suppliers_city_state') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.city') }}</span>
                                <input type="checkbox" name="city_state" class="form-switch-input" {{ config('suppliers_city_state') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('suppliers_zip_code') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.zip_code') }}</span>
                                <input type="checkbox" name="zip_code" class="form-switch-input" {{ config('suppliers_zip_code') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('suppliers_country_name') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.country') }} {{ __('messages.name') }}</span>
                                <input type="checkbox" name="country_name" class="form-switch-input" {{ config('suppliers_country_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('suppliers_domain') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.domain') }}</span>
                                <input type="checkbox" name="domain" class="form-switch-input" {{ config('suppliers_domain') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_bank_account') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.bank') }} {{ __('messages.account') }}</span>
                                <input type="checkbox" name="bank_account" class="form-switch-input" {{ config('suppliers_bank_account') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_image') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.image') }}</span>
                                <input type="checkbox" name="image" class="form-switch-input" {{ config('suppliers_image') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_group_id') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.supplier') }} {{ __('messages.group') }}</span>
                                <input type="checkbox" name="group_id" class="form-switch-input" {{ config('suppliers_group_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('suppliers_status') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.status') }}</span>
                                <input type="checkbox" name="status" class="form-switch-input" {{ config('suppliers_status') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" data-bs-dismiss="modal" type="button">{{ __('messages.save') }}</button>
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
            $("#supplierFormSettingModal input").on('click', function() {
                var table_name = 'suppliers';
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
                            title: 'Field Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            });

            $('#supplierFormSettingModal').on('hidden.bs.modal', function() {
                location.reload(); // Reload the page when the modal is closed
            });
        </script>
    @endpush
