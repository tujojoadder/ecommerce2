<div class="main-header side-header sticky nav nav-item" style="z-index: 1021 !important">
    <div class="container-fluid main-container " id="navbar-part">
        <div class="main-header-left">
            <div class="app-sidebar__toggle mobile-toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="javascript:void(0);"><i class="fas fa-bars text-dark" data-eva="menu-outline"></i></a>
                <a class="close-toggle" href="javascript:void(0);"><i class="fas fa-times text-dark" data-eva="close-outline"></i></a>
            </div>
            <div class="responsive-logo">
                <a href="index.html" class="header-logo"><img src="{{ asset('dashboard/img/brand/logo.png') }}" class="logo-11"></a>
                {{-- <a href="index.html" class="header-logo"><img src="{{ asset('dashboard/img/brand/logo-white.png') }}" class="logo-1"></a> --}}
            </div>
            <h3 class="text-dark mb-0 ms-3">{{ config('company.name') }}</h3>
            <div class="countdown ms-3 d-none">
                <ul class="d-flex justify-content-center mb-0 px-0 gap-1">
                    <span class="btn btn-info btn-sm font-weight-bolder px-1 py-0 mb-1 days" style="font-size: 20px">00</span>
                    <span class="btn btn-info btn-sm font-weight-bolder px-1 py-0 mb-1 hours" style="font-size: 20px">00</span>
                    <span class="btn btn-info btn-sm font-weight-bolder px-1 py-0 mb-1 minutes" style="font-size: 20px">00</span>
                    <span class="btn btn-info btn-sm font-weight-bolder px-1 py-0 mb-1 seconds" style="font-size: 20px">00</span>
                </ul>
            </div>
        </div>
        <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
        </button>
        <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto" style="z-index: 9999;">
            {{-- <small class="me-5">Badwidth: {{ number_format(memory_get_usage() / (1024 * 1024), 2) }} MB</small> --}}
            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <div class="main-header-right me-2">
                    <div>
                        <a href="{{ route('optimize.clear') }}" class="btn btn-outline-dark rounded-pill me-2"><i class="fas fa-tint" style="color: gray !important;"></i> {{ __('messages.clear') }} {{ __('messages.cache') }}</a>
                        @if (config('dashboard.backup') == 1)
                            @if (isPurchasedGDBP() == false)
                                <a href="{{ route('user.backup.download.locally') }}" class="btn btn-outline-info rounded-pill me-2"><i class="fas fa-download"></i> {{ __('messages.backup') }}</a>
                                @if (config('settings.google_client_credentials') == 1)
                                    <a href="{{ route('user.backup.get.drive.permission') }}" class="btn btn-outline-info rounded-pill me-2 d-none"><i class="fas fa-download"></i> {{ __('messages.get_google_backup') }}</a>
                                @endif
                            @else
                                <a href="{{ route('user.backup.download') }}" class="btn btn-outline-info rounded-pill me-2"><i class="fas fa-download"></i> {{ __('messages.google_backup') }}</a>
                            @endif
                        @endif
                        {{-- <a href="{{ route('user.start.google.auth') }}" class="btn btn-outline-info rounded-pill me-2"><i class="fas fa-download"></i> {{ __('messages.backup') }}</a> --}}
                    </div>
                    <div class="" id="">
                        <div class="dropdown border-0 main-profile-menu nav nav-item nav-link" id="lang">
                            <a class="d-flex border p-1 px-3 rounded-pill align-items-center text-dark" href="javascript:;"><i class="fas fa-language text-info me-2" style="font-size: 25px"></i>{{ __('messages.language') }}</a>
                            <div class="dropdown-menu">
                                {{-- <div class="dropdown-item ar"><img src="{{ asset('dashboard/svg/cn.svg') }}" alt=""> {{ __('messages.arabic') }}</div> --}}
                                <div class="dropdown-item en"><img src="{{ asset('dashboard/svg/en.svg') }}" alt=""> {{ __('messages.english') }}</div>
                                <div class="dropdown-item bn"><img src="{{ asset('dashboard/svg/bn.svg') }}" alt=""> {{ __('messages.bangla') }}</div>
                                {{-- <div class="dropdown-item mb-0 hi"><img src="{{ asset('dashboard/svg/hi.svg') }}" alt=""> {{ __('messages.hindi') }}</div> --}}
                            </div>
                        </div>
                    </div>
                    <li class="dropdown nav-item main-layout">
                        <div class="dropdown border-0 main-profile-menu nav nav-item nav-link" id="lang">
                            <a class="btn bg-transparent border text-dark rounded-pill me-2">
                                <span class=""><i class="fas fa-calculator" style="color: var(--dark-btn-color) !important;"></i></span>
                            </a>
                            <div class="dropdown-menu bg-transparent shadow-none">
                                @include('layouts.user.calculator')
                            </div>
                        </div>
                    </li>
                    {{-- <li class="dropdown nav-item main-layout">
                        <a class="new theme-layout nav-link-bg layout-setting">
                            <span class="dark-layout"><i class="fe fe-moon"></i></span>
                            <span class="light-layout"><i class="fe fe-sun"></i></span>
                        </a>
                    </li> --}}
                    <div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
                        <div class="dropdown main-profile-menu nav nav-item nav-link">
                            <a class="profile-user d-flex" href="javascript:;"><img src="{{ Auth::user()->image == !null ? asset('storage/profile/' . Auth::user()->image) : asset('dashboard/img/icons/user.png') }}" alt="user-img" class="rounded-circle mCS_img_loaded bg-white"><span></span></a>
                            <div class="dropdown-menu">
                                <div class="main-header-profile header-img">
                                    <div class="main-img-user border bg-white"><img class="rounded-circle" alt="" src="{{ Auth::user()->image == !null ? asset('storage/profile/' . Auth::user()->image) : asset('dashboard/img/icons/user.png') }}"></div>
                                    <h6>{{ Auth::user()->name }} <small>({{ Auth::user()->username }})</small></h6>
                                </div>
                                <a class="dropdown-item" href="{{ route('user.profile.index') }}"><i class="far fa-user"></i> {{ __('messages.my_profile') }}</a>
                                @if (request()->getHost() == 'dev.bhisab.oxhostbd.com' || request()->getHost() == 'erp.bsoftbd.com')
                                @else
                                    <a class="dropdown-item" href="{{ route('user.profile.change.password.index') }}"><i class="fas fa-lock"></i> {{ __('messages.change_password') }}</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('user.settings.roles.index') }}"><i class="fas fa-user-shield"></i> {{ __('messages.roles') }}</a>
                                <a class="dropdown-item" href="{{ route('user.staff.index') }}?user"><i class="fas fa-user-plus"></i> {{ __('messages.user') }} {{ __('messages.list') }}</a>
                                <a class="dropdown-item" href="{{ route('user.settings.index') }}"><i class="fas fa-sliders-h"></i> {{ __('messages.settings') }}</a>
                                <a class="dropdown-item" href="{{ route('user.configuration.shortcut-menu.index') }}"><i class="fas fa-thumbtack"></i> {{ __('messages.shortcut_menu') }}</a>
                                <a class="dropdown-item" href="{{ route('user.configuration.company-information.index') }}"><i class="far fa-building"></i> {{ __('messages.company_information') }}</a>
                                @if (config('dashboard.server_info') == 1)
                                    <a class="dropdown-item" href="{{ route('user.settings.server.info.index') }}"><i class="fas fa-server"></i> {{ __('messages.server_info') }}</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> {{ __('messages.signout') }}</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#lang .dropdown-menu .dropdown-item").click(function() {
                var selectedLang = $(this).attr('class').split(' ')[1];
                var url = "{{ route('language') }}";
                window.location.href = url + "?lang=" + selectedLang;
            });
        });
    </script>
@endpush
