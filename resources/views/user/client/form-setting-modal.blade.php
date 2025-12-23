    <div class="modal fade" id="formSettingModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Client Form Settings</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6 {{ config('clients_id_no') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.id_no') }}</span>
                                <input type="checkbox" name="id_no" class="form-switch-input" {{ config('clients_id_no') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_client_name') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.client') }} {{ __('messages.name') }}</span>
                                <input type="checkbox" name="client_name" class="form-switch-input" {{ config('clients_client_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_fathers_name') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.fathers_name') }}</span>
                                <input type="checkbox" name="fathers_name" class="form-switch-input" {{ config('clients_fathers_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_mothers_name') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.mothers_name') }}</span>
                                <input type="checkbox" name="mothers_name" class="form-switch-input" {{ config('clients_mothers_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_company_name') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.company') }} {{ __('messages.name') }}</span>
                                <input type="checkbox" name="company_name" class="form-switch-input" {{ config('clients_company_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_address') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me75">{{ __('messages.address') }}</span>
                                <input type="checkbox" name="address" class="form-switch-input" {{ config('clients_address') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_phone') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me75">{{ __('messages.phone_number') }}</span>
                                <input type="checkbox" name="phone" class="form-switch-input" {{ config('clients_phone') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_phone_optional') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }} 2</span>
                                <input type="checkbox" name="phone_optional" class="form-switch-input" {{ config('clients_phone_optional') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_previous_due') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.previous_due') }}</span>
                                <input type="checkbox" name="previous_due" class="form-switch-input" {{ config('clients_previous_due') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_max_due_limit') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.max_due_limit') }}</span>
                                <input type="checkbox" name="max_due_limit" class="form-switch-input" {{ config('clients_max_due_limit') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_email') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.email') }}</span>
                                <input type="checkbox" name="email" class="form-switch-input" {{ config('clients_email') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_date_of_birth') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.date_of_birth') }}</span>
                                <input type="checkbox" name="date_of_birth" class="form-switch-input" {{ config('clients_date_of_birth') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_upazilla_thana') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.upzilla') }}</span>
                                <input type="checkbox" name="upazilla_thana" class="form-switch-input" {{ config('clients_upazilla_thana') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_street_road') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.street_road') }}</span>
                                <input type="checkbox" name="street_road" class="form-switch-input" {{ config('clients_street_road') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_reference') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.reference') }}</span>
                                <input type="checkbox" name="reference" class="form-switch-input" {{ config('clients_reference') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{ config('clients_zip_code') == 0 ? 'd-none' : '' }}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.zip_code') }}</span>
                                <input type="checkbox" name="zip_code" class="form-switch-input" {{ config('clients_zip_code') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_group_id') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.client') }} {{ __('messages.group') }}</span>
                                <input type="checkbox" name="group_id" class="form-switch-input" {{ config('clients_group_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_image') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.image') }}</span>
                                <input type="checkbox" name="image" class="form-switch-input" {{ config('clients_image') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6 {{-- config('clients_status') == 0 ? 'd-none' : '' --}}">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.status') }}</span>
                                <input type="checkbox" name="status" class="form-switch-input" {{ config('clients_status') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-info" data-bs-dismiss="modal" type="button">{{ __('messages.save') }}</button>
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
                var table_name = 'clients';
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
                            title: 'Group Not Found!',
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
