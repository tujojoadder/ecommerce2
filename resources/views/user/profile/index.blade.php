@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/profile/privacy/change/password');
        $erpdemo = request()->getHost() == 'erp.bsoftbd.com';
    @endphp
    <style>
        .form-label {
            color: black;
        }
    </style>
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="ps-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" id="image-preview" src="{{ Auth::user()->image == !null ? asset('storage/profile/' . Auth::user()->image) : asset('dashboard/img/icons/user.png') }}" class="p-0">
                                <a href="JavaScript:void(0);" id="choose-image-btn" class="fas fa-camera profile-edit bg-info"></a>
                                <form action="{{ route('user.profile.update.image', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="file" accept="image/*" id="image-file" name="image" accept="image/*" hidden>
                                    @if (!$erpdemo)
                                        <button class="btn btn-sm btn-success mt-2" type="submit">{{ __('messages.update') }} {{ __('messages.image') }}</button>
                                    @endif
                                </form>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20 mt-4">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <h5 class="main-profile-name">{{ Auth::user()->name }} </h5>
                                        <span class="ms-2">({{ Auth::user()->username }})</span>
                                    </div>

                                    <p class="main-profile-name-text">
                                        {{ Auth::user()->designation_id }}
                                    </p>
                                </div>
                            </div>
                            <h6>Bio</h6>
                            <div class="main-profile-bio">
                                {{ Auth::user()->description }}
                            </div>

                            <div class="main-profile-work-list">
                                <div class="d-flex align-items-center">
                                    <div class="media-logo bg-secondary text-white">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="media-body p-2 rounded-lg">
                                        <a href="{{ route('user.profile.index') }}" class="{{ Request::is('user/profile') ? 'btn btn-outline-dark active' : 'btn btn-outline-dark' }}">{{ __('messages.profile') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="main-profile-work-list">
                                <div class="d-flex align-items-center">
                                    <div class="media-logo bg-secondary text-white">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="media-body p-2 rounded-lg">
                                        @if ($erpdemo)
                                            <a href="javascript:;" class="{{ Request::is('user/profile/privacy/change/password') ? 'btn btn-outline-dark active' : 'btn btn-outline-dark' }}" onclick="comingSoon();">{{ __('messages.change') }} {{ __('messages.password') }}</a>
                                        @else
                                            <a href="{{ route('user.profile.change.password.index') }}" class="{{ Request::is('user/profile/privacy/change/password') ? 'btn btn-outline-dark active' : 'btn btn-outline-dark' }}">{{ __('messages.change') }} {{ __('messages.password') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /Col -->

        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if ($route)
                        <form class="form-horizontal" action="{{ route('user.profile.change.password.update') }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="mb-4 main-content-label d-flex justify-content-between">
                                            <span>{{ $pageTitle }}</span>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 mb-2">
                                                <label class="form-label mb-0">{{ __('messages.current') }} {{ __('messages.password') }}</label>
                                                <input type="text" name="current_password" class="@error('current_password') is-invalid border-danger @enderror form-control" placeholder="Current Password" autofocus required>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="form-label mb-0">{{ __('messages.new') }} {{ __('messages.password') }}</label>
                                                <input type="text" name="password" class="@error('password') is-invalid border-danger @enderror form-control" placeholder="Type New Password" required>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label class="form-label mb-0">{{ __('messages.current') }} {{ __('messages.password') }}</label>
                                                <input type="text" name="confirm_password" class="@error('confirm_password') is-invalid border-danger @enderror form-control" placeholder="Re-type Password" required>
                                            </div>
                                            <div id="password-match" class="text-danger"></div>
                                            <div id="password-strength" class="text-danger"></div>
                                            <div class="col-md-12 mt-2">
                                                <button class="btn btn-success btn-block">{{ __('messages.change') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form class="form-horizontal" action="{{ route('user.profile.update', Auth::user()->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4 main-content-label d-flex justify-content-between">
                                <span>Personal Information</span>
                                <a href="javascript:;" id="edit-profile-btn" class="btn btn-sm btn-info">
                                    <i class="fas fa-pen"></i>
                                    <span class="edit-button-text"> {{ __('messages.edit') }}</span>
                                    <span class="edit-button-text d-none">{{ __('messages.cancel') }}</span>
                                </a>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.user_name') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" id="username" class="form-control bg-white border-0" placeholder="User Name" value="{{ Auth::user()->username }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.full_name') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="name" id="name" class="@error('name') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.full_name') }}" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.email') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="email" name="email" id="email" class="@error('email') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.email') }}" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.father_name') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="fathers_name" id="fathers_name" class="@error('fathers_name') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.father_name') }}" value="{{ old('fathers_name', Auth::user()->fathers_name) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.mother_name') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="mothers_name" id="mothers_name" class="@error('mothers_name') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.mother_name') }}" value="{{ old('mothers_name', Auth::user()->mothers_name) }}">
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.present') }} {{ __('messages.address') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="present_address" id="present_address" class="@error('present_address') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.present') }} {{ __('messages.address') }}" value="{{ old('present_address', Auth::user()->present_address) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.permanent') }} {{ __('messages.address') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="parmanent_address" id="parmanent_address" class="@error('parmanent_address') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.permanent') }} {{ __('messages.address') }}" value="{{ old('parmanent_address', Auth::user()->parmanent_address) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.phone_number') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="number" name="phone" id="phone" class="@error('phone') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="Phone" value="{{ old('phone', Auth::user()->phone) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.nationality') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="nationality" id="nationality" class="@error('nationality') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.nationality') }}" value="{{ old('nationality', Auth::user()->nationality) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.nid') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="number" name="nid" id="nid" class="@error('nid') is-invalid border-danger @enderror form-control bg-white border-0" placeholder="{{ __('messages.nid') }}" value="{{ old('nid', Auth::user()->nid) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.blood_group') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <select name="blood_group" id="blood_group" class="@error('blood_group') is-invalid border-danger @enderror form-control bg-white border-0" data-placeholder="Blood Group">
                                            <option {{ Auth::user()->blood_group == 'A+' ? 'selected' : 'selected' }} value="A+">A +(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'A-' ? 'selected' : '' }} value="A-">A -(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'B+' ? 'selected' : '' }} value="B+">B +(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'B-' ? 'selected' : '' }} value="B-">B -(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'O+' ? 'selected' : '' }} value="O+">O +(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'O-' ? 'selected' : '' }} value="O-">O -(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'AB+' ? 'selected' : '' }} value="AB+">AB +(ve)</option>
                                            <option {{ Auth::user()->blood_group == 'AB-' ? 'selected' : '' }} value="AB-">AB -(ve)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.religion') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <select name="religion" id="religion" class="@error('religion') is-invalid border-danger @enderror form-control bg-white border-0">
                                            <option {{ Auth::user()->religion == 'Islam' ? 'selected' : 'selected' }} value="Islam">Islam</option>
                                            <option {{ Auth::user()->religion == 'Hinduism' ? 'selected' : '' }} value="Hinduism">Hinduism</option>
                                            <option {{ Auth::user()->religion == 'Buddhism' ? 'selected' : '' }} value="Buddhism">Buddhism</option>
                                            <option {{ Auth::user()->religion == 'Christianity' ? 'selected' : '' }} value="Christianity">Christianity</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.date_of_birth') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <input type="text" name="date_of_birth" id="date_of_birth" class="@error('date_of_birth') is-invalid border-danger @enderror form-control bg-white border-0 fc-datepicker" value="{{ date('d/m/Y') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.designation') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <select name="designation_id" id="designation_id" class="@error('designation_id') is-invalid border-danger @enderror form-control bg-white border-0 select2">
                                            <option value="1">Student</option>
                                            <option value="2">Banker</option>
                                            <option value="3">Doctor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <label class="form-label mb-0">{{ __('messages.department') }}</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-center"><span>:</span></div>
                                    <div class="col-8">
                                        <select name="department_id" id="department_id" class="@error('department_id') is-invalid border-danger @enderror form-control bg-white border-0 select2">
                                            <option value="1">Science</option>
                                            <option value="2">Arc</option>
                                            <option value="3">Commerce</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-footer border-0 d-flex justify-content-end px-0">
                                <button type="submit" class="btn btn-primary waves-effect waves-light d-none" id="update-btn">{{ __('messages.update') }} {{ __('messages.profile') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#choose-image-btn").on('click', function() {
                $("#image-file").click();
            });
            // Function to handle file input change
            $("#image-file").change(function() {
                // Get the selected file
                var file = this.files[0];
                if (file) {
                    // Display the image preview (optional)
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#image-preview").attr("src", e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Clear the image preview if no file is selected
                    $("#image-preview").attr("src", "").hide();
                }
            });

            // edit
            $("#edit-profile-btn").on('click', function() {
                $("#username").toggleClass('border-0');
                $("#name").toggleClass('border-0');
                $("#email").toggleClass('border-0');
                $("#fathers_name").toggleClass('border-0');
                $("#mothers_name").toggleClass('border-0');
                $("#present_address").toggleClass('border-0');
                $("#parmanent_address").toggleClass('border-0');
                $("#phone").toggleClass('border-0');
                $("#nationality").toggleClass('border-0');
                $("#nid").toggleClass('border-0');
                $("#blood_group").toggleClass('border-0');
                $("#religion").toggleClass('border-0');
                $("#date_of_birth").toggleClass('border-0');
                $("#designation_id").toggleClass('border-0');
                $("#department_id").toggleClass('border-0');
                $("#update-btn").toggleClass('d-none');
                $(".edit-button-text").toggleClass('d-none');
                $("#edit-profile-btn").toggleClass('btn-info btn-danger');
            });
        });
    </script>
    <script>
        // Function to update password match status
        function updatePasswordMatch() {
            var newPassword = $('input[name="password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();
            var passwordMatchDiv = $('#password-match');

            if (newPassword === confirmPassword) {
                passwordMatchDiv.text('Passwords match');
                $("#password-match").addClass('text-success');
                $("#password-match").removeClass('text-danger');
            } else {
                $("#password-match").removeClass('text-success');
                $("#password-match").addClass('text-danger');
                passwordMatchDiv.text('Passwords do not match');
            }
        }

        // Attach keyup event listeners to the password fields
        $('input[name="password"]').keyup(function() {
            updatePasswordMatch();
        });

        $('input[name="confirm_password"]').keyup(updatePasswordMatch);
    </script>
@endpush
