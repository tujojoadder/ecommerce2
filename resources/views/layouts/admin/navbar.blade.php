<div class="main-header side-header sticky nav nav-item">
    <div class="container-fluid main-container ">
        <div class="main-header-left ">
            <div class="app-sidebar__toggle mobile-toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="fas fa-bars text-white"
                        data-eva="menu-outline"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="fas fa-times text-white"
                        data-eva="close-outline"></i></a>
            </div>
            <div class="responsive-logo">
                <a href="index.html" class="header-logo"><img src="{{ asset('dashboard/img/brand/logo.png') }}"
                        class="logo-11"></a>
            </div>
            <h3 class="text-white mb-0 ms-3">{{ config('company.name') }}</h3>
        </div>
        <div
            class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto  ms-auto">
            <select name="package" class="form-control select2" id="package">
                <option {{ siteSettings()->package == 'basic' ? 'selected' : '' }} value="basic">Basic</option>
                <option {{ siteSettings()->package == 'professional' ? 'selected' : '' }} value="professional">
                    Professional</option>
                <option {{ siteSettings()->package == 'business' ? 'selected' : '' }} value="business">Business</option>
            </select>
        </div>
        <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
            aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
        </button>
        <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <div class="main-header-right me-2">
                    <div>
                        <a href="{{ route('admin.clean.data') }}" class="btn btn-danger rounded-pill me-2"><i
                                class="fas fa-tint"></i> {{ __('messages.clear') }} {{ __('messages.all') }}</a>
                        <a href="{{ route('maintenance.storage_link.get') }}" class="btn btn-info rounded-pill me-2"><i
                                class="fas fa-"></i> {{ __('messages.storage_link') }}</a>
                    </div>
                    <div class="nav nav-item nav-link" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="input-group-btn">
                                    <button type="reset" class="btn btn-default">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="submit" class="btn btn-default nav-link">
                                        <i class="fe fe-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <li class="dropdown nav-item main-layout">
                        <a class="new theme-layout nav-link-bg layout-setting">
                            <span class="dark-layout"><i class="fe fe-moon"></i></span>
                            <span class="light-layout"><i class="fe fe-sun"></i></span>
                        </a>
                    </li>
                    <div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
                        <div class="dropdown main-profile-menu nav nav-item nav-link">
                            {{-- <a class="profile-user d-flex" href=""><img src="{{ Auth::guard('admin')->user()->image == !null ? asset('storage/profile/' . Auth::guard('admin')->user()->image) : asset('dashboard/img/icons/user.png') }}" alt="user-img" class="rounded-circle mCS_img_loaded bg-white"><span></span></a> --}}
                            <div class="dropdown-menu">
                                <div class="main-header-profile header-img">
                                    <div class="main-img-user border bg-white"><img class="rounded-circle"
                                            alt=""
                                            src="{{ Auth::guard('admin')->user()->image == !null ? asset('storage/profile/' . Auth::guard('admin')->user()->image) : asset('dashboard/img/icons/user.png') }}">
                                    </div>
                                    <h6>{{ Auth::guard('admin')->user()->name }}</h6>
                                    <span>{{ Auth::guard('admin')->user()->username }}</span>
                                </div>
                                <a class="dropdown-item" href="javascript:;" onclick="comingSoon();"><i
                                        class="far fa-user"></i> My Profile</a>
                                <a class="dropdown-item" href="javascript:;" onclick="comingSoon();"><i
                                        class="fas fa-lock"></i> Change Password</a>
                                <a class="dropdown-item" href="javascript:;" onclick="comingSoon();"><i
                                        class="far fa-clock"></i> Activity Logs</a>
                                <a class="dropdown-item" href="javascript:;" onclick="comingSoon();"><i
                                        class="fas fa-sliders-h"></i> Settings</a>
                                <a class="dropdown-item" href="{{ route('admin.managers.index') }}"><i
                                        class="fas fa-universal-access"></i> Usage Permission</a>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fas fa-sign-out-alt"></i> Sign Out</a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#package').change(function() {
                var package = $(this).val();
                var sitePackage = "{{ siteSettings()->package }}";
                if ((sitePackage == 'professional' && (package == 'basic' || package == 'business')) || (
                        sitePackage == 'business' && (package == 'professional' || package == 'basic'))) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'You can\'t downgrade package!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    $.ajax({
                        url: '/admin/update-package/' + package,
                        method: 'GET',
                        data: {
                            package: package
                        },
                        success: function(response) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Package Updated!',
                                text: 'Your package has been updated successfully. Now you are a ' +
                                    package + ' user!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(error) {
                            // handle error response
                        }
                    });
                }
            });
        });
    </script>
@endpush
