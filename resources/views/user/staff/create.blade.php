@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/staff/edit/*');
    @endphp
    <style>
        .select2-container--default {
            z-index: 1040 !important;
        }
    </style>
    <div class="main-content-body">
        <form action="{{ $route ? route('user.staff.update', $staff->id) : route('user.staff.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($route)
                @method('PUT')
            @endif
            <!-- Col -->
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex">
                        <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2">
                            <i class="fas fa-cog d-inline"></i>
                        </a>
                        <a href="{{ route('user.staff.index') }}?{{ request()->has('user') ? 'user' : '' }}" class="btn btn-secondary me-2">
                            <i class="fas fa-list d-inline"></i> {{ request()->has('user') ? __('messages.user') : __('messages.staff') }} {{ __('messages.list') }}
                        </a>
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/qEvvnplupHA?si=VjTrkln3SkGBONkM">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if (request()->has('user'))
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_name') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('name') is-invalid border-danger @enderror form-control" name="name" value="{{ old('name', $route ? $staff->name : '') }}" id="name" required placeholder="{{ __('messages.name') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user-alt"></i> {{ __('messages.name') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="@error('username') is-invalid border-danger @enderror form-control" name="username" {{ $route ? 'readonly' : '' }} id="username" value="{{ $route ? $staff->username : '' }}" placeholder="{{ __('messages.username') }}" required>
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user"></i> {{ __('messages.username') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="@error('password') is-invalid border-danger @enderror form-control" name="password" id="password" value="" placeholder="{{ Request::is('user/staff/create') ? __('messages.password') : 'Leave blank if not changing!' }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="password"><i class="fas fa-lock"></i> {{ __('messages.password') }}</label>
                                </div>
                            </div>
                        @else
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_name') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('name') is-invalid border-danger @enderror form-control" name="name" value="{{ old('name', $route ? $staff->name : '') }}" id="name" required placeholder="{{ __('messages.name') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user"></i> {{ __('messages.name') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_username') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('username') is-invalid border-danger @enderror form-control" name="username" {{ $route ? 'readonly' : '' }} id="username" value="{{ $route ? $staff->username : '' }}" placeholder="{{ __('messages.user_name') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user"></i> {{ __('messages.username') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_email') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email', $route ? $staff->email : '') }}" class="@error('email') is-invalid border-danger @enderror form-control" placeholder="{{ __('messages.email') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-envelope"></i> {{ __('messages.email') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_phone') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="number" name="phone" value="{{ old('phone', $route ? $staff->phone : '') }}" min="0" class="@error('phone') is-invalid border-danger @enderror form-control" placeholder="{{ __('messages.phone_number') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-phone"></i> {{ __('messages.phone_number') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_fathers_name') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('fathers_name') is-invalid border-danger @enderror form-control" name="fathers_name" value="{{ old('fathers_name', $route ? $staff->fathers_name : '') }}" placeholder="{{ __('messages.father_name') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user-tie"></i> {{ __('messages.father_name') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_mothers_name') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('mothers_name') is-invalid border-danger @enderror form-control" name="mothers_name" value="{{ old('mothers_name', $route ? $staff->mothers_name : '') }}" placeholder="{{ __('messages.mother_name') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user-tie"></i> {{ __('messages.mother_name') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_present_address') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('present_address') is-invalid border-danger @enderror form-control" name="present_address" value="{{ old('present_address', $route ? $staff->present_address : '') }}" placeholder="{{ __('messages.address') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-location-arrow"></i> {{ __('messages.address') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_parmanent_address') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('parmanent_address') is-invalid border-danger @enderror form-control" name="parmanent_address" value="{{ old('parmanent_address', $route ? $staff->parmanent_address : '') }}" placeholder="{{ __('messages.address') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-thumbtack"></i> {{ __('messages.parmanent') }} {{ __('messages.address') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_date_of_birth') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input class="@error('date_of_birth') is-invalid border-danger @enderror form-control fc-datepicker" name="date_of_birth" value="{{ old('date_of_birth', $route ? $staff->date_of_birth : '') }}" placeholder="MM/DD/YYYY" type="text" autocomplete="off">
                                    <label class="animated-label active-label" for="vat"><i class="fas fa-calendar-alt"></i> {{ __('messages.date_of_birth') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_nationality') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('nationality') is-invalid border-danger @enderror form-control" name="nationality" value="{{ old('nationality', $route ? $staff->nationality : '') }}" placeholder="{{ __('messages.nationality') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-id-card"></i> {{ __('messages.nationality') }}</label>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6  {{ config('users_religion') == 1 ? '' : 'd-none' }}">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.religion') }}">
                                    <select name="religion" class="@error('religion') is-invalid border-danger @enderror form-control">
                                        <option {{ $route ? ($staff->religion == 'Islam' ? 'selected' : '') : '' }} value="Islam" {{ $route ? '' : 'selected' }}>{{ __('messages.islam') }}</option>
                                        <option {{ $route ? ($staff->religion == 'Hinduism' ? 'selected' : '') : '' }} value="Hinduism">{{ __('messages.hinduism') }}</option>
                                        <option {{ $route ? ($staff->religion == 'Buddhism' ? 'selected' : '') : '' }} value="Buddhism">{{ __('messages.buddhism') }}</option>
                                        <option {{ $route ? ($staff->religion == 'Christianity' ? 'selected' : '') : '' }} value="Christianity">{{ __('messages.chirstianity') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6  {{ config('users_marital_status') == 1 ? '' : 'd-none' }}">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.martial') }} {{ __('messages.status') }}">
                                    <select name="marital_status" class="@error('marital_status') is-invalid border-danger @enderror form-control">
                                        <option {{ $route ? ($staff->marital_status == 'Married' ? 'selected' : '') : '' }} value="Married">Married</option>
                                        <option {{ $route ? ($staff->marital_status == 'Unmarried' ? 'selected' : '') : '' }} value="Unmarried">Un Married</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_nid') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('nid') is-invalid border-danger @enderror form-control" name="nid" value="{{ old('nid', $route ? $staff->nid : '') }}" placeholder="{{ __('messages.nid') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-id-card"></i> {{ __('messages.nid') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_birth_certificate') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('birth_certificate') is-invalid border-danger @enderror form-control" name="birth_certificate" value="{{ old('birth_certificate', $route ? $staff->birth_certificate : '') }}" placeholder="{{ __('messages.birth_certificate') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="far fa-id-badge"></i> {{ __('messages.birth_certificate') }}</label>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6  {{ config('users_blood_group') == 1 ? '' : 'd-none' }}">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.blood_group') }}">
                                    <select name="blood_group" class="@error('blood_group') is-invalid border-danger @enderror form-control" data-placeholder="Blood Group">
                                        <option {{ $route ? ($staff->blood_group == 'A+' ? 'selected' : '') : '' }} value="A+">A+ (ve)</option>
                                        <option {{ $route ? ($staff->blood_group == 'A-' ? 'selected' : '') : '' }} value="A-">A- (ve)</option>
                                        <option {{ $route ? ($staff->blood_group == 'B+' ? 'selected' : '') : '' }} value="B+">B+ (ve)</option>
                                        <option {{ $route ? ($staff->blood_group == 'B-' ? 'selected' : '') : '' }} value="B-">B- (ve)</option>
                                        <option {{ $route ? ($staff->blood_group == 'O+' ? 'selected' : '') : '' }} value="O+">O+ (ve)</option>
                                        <option {{ $route ? ($staff->blood_group == 'O-' ? 'selected' : '') : '' }} value="O-">O- (ve)</option>
                                        <option {{ $route ? ($staff->blood_group == 'AB+' ? 'selected' : '') : '' }} value="AB+">AB+ (ve))</option>
                                        <option {{ $route ? ($staff->blood_group == 'AB-' ? 'selected' : '') : '' }} value="AB-">AB- (ve))</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6  {{ config('users_gender') == 1 ? '' : 'd-none' }}">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.gender') }}">
                                    <select name="gender" class="@error('gender') is-invalid border-danger @enderror form-control">
                                        <option {{ $route ? ($staff->gender == 'Male' ? 'selected' : '') : '' }} value="Male">{{ __('messages.male') }}</option>
                                        <option {{ $route ? ($staff->gender == 'Female' ? 'selected' : '') : '' }} value="Female">{{ __('messages.female') }}</option>
                                        <option {{ $route ? ($staff->gender == 'Other' ? 'selected' : '') : '' }} value="Other">{{ __('messages.other') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_edu_qualification') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('edu_qualification') is-invalid border-danger @enderror form-control" name="edu_qualification" value="{{ old('edu_qualification', $route ? $staff->edu_qualification : '') }}" placeholder="{{ __('messages.educational_qualification') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-user-graduate"></i> {{ __('messages.educational_qualification') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_experience') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('experience') is-invalid border-danger @enderror form-control" name="experience" value="{{ old('experience', $route ? $staff->experience : '') }}" placeholder="{{ __('messages.experience') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-briefcase"></i> {{ __('messages.experience') }}</label>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_staff_id') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('staff_id') is-invalid border-danger @enderror form-control" name="staff_id" value="{{ old('staff_id', $route ? $staff->staff_id : '') }}" placeholder="{{ __('messages.staff_id') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-id-card-alt"></i> {{ __('messages.staff_id') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_image') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="file" accept="image/*" name="image" value="{{ old('image', $route ? $staff->image : '') }}" class="@error('image') is-invalid border-danger @enderror form-control image" placeholder="" id="image">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_staff_type') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('staff_type') is-invalid border-danger @enderror form-control" name="staff_type" value="{{ old('staff_type', $route ? $staff->staff_type : '') }}" placeholder="{{ __('messages.type') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-layer-group"></i> {{ __('messages.staff') }} {{ __('messages.type') }}</label>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6 {{ config('users_department_id') == 1 ? '' : 'd-none' }}">
                                <div class="d-flex">
                                    <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.department') }}">
                                        <select id="department_id" name="department_id" class="@error('department_id') is-invalid border-danger @enderror form-control select2">
                                        </select>
                                    </div>
                                    <a class="add-btn btn btn-success" type="button" href="javascript:;" data-bs-target="#staffDepartmentModal" data-bs-toggle="modal"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6 {{ config('users_designation_id') == 1 ? '' : 'd-none' }}">
                                <div class="d-flex">
                                    <div class="input-group d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.designation') }}">
                                        <select id="designation_id" name="designation_id" class="@error('designation_id') is-invalid border-danger @enderror form-control select2">
                                        </select>
                                    </div>
                                    <a class="add-btn btn btn-success" type="button" href="javascript:;" data-bs-target="#staffDesignationModal" data-bs-toggle="modal"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_office_zone') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('office_zone') is-invalid border-danger @enderror form-control" name="office_zone" value="{{ old('office_zone', $route ? $staff->office_zone : '') }}" placeholder="{{ __('messages.office_zone') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-business-time"></i> {{ __('messages.office_zone') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_joining_date') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('joining_date') is-invalid border-danger @enderror form-control fc-datepicker" name="joining_date" value="{{ old('joining_date', $route ? $staff->joining_date : '') }}" placeholder="MM/DD/YYYY" autocomplete="off">
                                    <label class="animated-label active-label" for="vat"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.joining_date') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_discharge_date') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="text" class="@error('discharge_date') is-invalid border-danger @enderror form-control fc-datepicker" name="discharge_date" value="{{ old('discharge_date', $route ? $staff->discharge_date : '') }}" placeholder="MM/DD/YYYY" autocomplete="off">
                                    <label class="animated-label active-label" for="vat"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.discharge_date') }}</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6  {{ config('users_machine_id') == 1 ? '' : 'd-none' }}">
                                <div class="form-group">
                                    <input type="number" min="0" name="machine_id" value="{{ old('machine_id', $route ? $staff->machine_id : '') }}" class="@error('machine_id') is-invalid border-danger @enderror form-control" placeholder="{{ __('messages.machine_id') }}">
                                    <label class="animated-label {{ $route ? 'active-label' : '' }}" for="vat"><i class="fas fa-portrait"></i> {{ __('messages.machine_id') }}</label>
                                </div>
                            </div>
                            <div class="form-group col-xl-4 col-lg-4 col-md-6  {{ config('users_status') == 1 ? '' : 'd-none' }}">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.status') }}">
                                    <select name="status" value="{{ old('status', $route ? $staff->status : '') }}" class="@error('status') is-invalid border-danger @enderror form-control">
                                        <option {{ $route ? ($staff->status == '1' ? 'selected' : '') : '' }} value="1">{{ __('messages.active') }}</option>
                                        <option {{ $route ? ($staff->status == '0' ? 'selected' : '') : '' }} value="0">{{ __('messages.deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12 {{ config('users_description') == 1 ? '' : 'd-none' }}">
                                <div class="input-group d-block">
                                    <textarea name="description" id="summernote" class="@error('description') is-invalid border-danger @enderror form-control w-100" cols="5" rows="3" placeholder="{{ __('messages.description') }}">{{ $route ? $staff->description : '' }}</textarea>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                            <button type="submit" class="add-to-cart btn btn-success btn-block">{{ __($route ? 'Update Staff' : 'Add Staff') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Col -->
        </form>
    </div>
    @include('user.staff.department.department-modal')
    @include('user.staff.designation.designation-modal')
    @include('user.staff.form-setting-modal')
@endsection
@push('scripts')
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif


        // fetch all Department brands
        function fetchDepartment() {
            $.ajax({
                url: "{{ route('get.staff.departments') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#department_id').html(html);
                }
            });
        }

        function fetchDesignation() {
            $.ajax({
                url: "{{ route('get.staff.designations') }}",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, value) {
                        html += '<option value="">Select</option>';
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#designation_id').html(html);
                }
            });
        }
        $(document).ready(function() {
            fetchDepartment();
            fetchDesignation();

        });
    </script>
@endpush
