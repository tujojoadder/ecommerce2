    <div class="modal fade" id="formSettingModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('messages.staff') }} {{ __('messages.settings') }}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.name') }}</span>
                                <input type="checkbox" name="name" class="form-switch-input" {{ config('users_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.user_name') }}</span>
                                <input type="checkbox" name="username" class="form-switch-input" {{ config('users_username') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.email') }}</span>
                                <input type="checkbox" name="email" class="form-switch-input" {{ config('users_email') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.phone_number') }}</span>
                                <input type="checkbox" name="phone" class="form-switch-input" {{ config('users_phone') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.father_name') }}</span>
                                <input type="checkbox" name="fathers_name" class="form-switch-input" {{ config('users_fathers_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.mother_name') }}</span>
                                <input type="checkbox" name="mothers_name" class="form-switch-input" {{ config('users_mothers_name') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.present') }} {{ __('messages.address') }}</span>
                                <input type="checkbox" name="present_address" class="form-switch-input" {{ config('users_present_address') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.parmanent') }} {{ __('messages.address') }}</span>
                                <input type="checkbox" name="parmanent_address" class="form-switch-input" {{ config('users_parmanent_address') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.date_of_birth') }}</span>
                                <input type="checkbox" name="date_of_birth" class="form-switch-input" {{ config('users_date_of_birth') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.nationality') }}</span>
                                <input type="checkbox" name="nationality" class="form-switch-input" {{ config('users_nationality') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.religion') }}</span>
                                <input type="checkbox" name="religion" class="form-switch-input" {{ config('users_religion') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.martial') }} {{ __('messages.status') }}</span>
                                <input type="checkbox" name="marital_status" class="form-switch-input" {{ config('users_marital_status') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.nid') }}</span>
                                <input type="checkbox" name="nid" class="form-switch-input" {{ config('users_nid') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.birth_certificate') }}</span>
                                <input type="checkbox" name="birth_certificate" class="form-switch-input" {{ config('users_birth_certificate') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.blood_group') }}</span>
                                <input type="checkbox" name="blood_group" class="form-switch-input" {{ config('users_blood_group') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.gender') }}</span>
                                <input type="checkbox" name="gender" class="form-switch-input" {{ config('users_gender') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.educational_qualification') }}</span>
                                <input type="checkbox" name="edu_qualification" class="form-switch-input" {{ config('users_edu_qualification') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.experience') }}</span>
                                <input type="checkbox" name="experience" class="form-switch-input" {{ config('users_experience') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.staff_id') }}</span>
                                <input type="checkbox" name="staff_id" class="form-switch-input" {{ config('users_staff_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.image') }}</span>
                                <input type="checkbox" name="image" class="form-switch-input" {{ config('users_image') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.type') }}</span>
                                <input type="checkbox" name="staff_type" class="form-switch-input" {{ config('users_staff_type') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.department') }}</span>
                                <input type="checkbox" name="department_id" class="form-switch-input" {{ config('users_department_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.designation') }}</span>
                                <input type="checkbox" name="designation_id" class="form-switch-input" {{ config('users_designation_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.office_zone') }}</span>
                                <input type="checkbox" name="office_zone" class="form-switch-input" {{ config('users_office_zone') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.joining_date') }}</span>
                                <input type="checkbox" name="joining_date" class="form-switch-input" {{ config('users_joining_date') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.discharge_date') }}</span>
                                <input type="checkbox" name="discharge_date" class="form-switch-input" {{ config('users_discharge_date') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.machine_id') }}</span>
                                <input type="checkbox" name="machine_id" class="form-switch-input" {{ config('users_machine_id') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.status') }}</span>
                                <input type="checkbox" name="status" class="form-switch-input" {{ config('users_status') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-group form-control d-flex justify-content-between">
                                <span class="form-switch-description tx-15 me-2">{{ __('messages.description') }}</span>
                                <input type="checkbox" name="description" class="form-switch-input" {{ config('users_description') == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="button">{{ __('messages.save') }}</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">{{ __('messages.close') }}</button>
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
                var table_name = 'users';
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
