<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll overflow-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="{{ route('user.home') }}"> <img src="{{ config('company.logo') }}" class="main-logo" alt="logo"></a>
            <a class="desktop-logo logo-dark active" href="{{ route('user.home') }}"><img src="{{ asset('dashboard/img/brand/logo-white.png') }}" class="main-logo" alt="logo"></a>

            <a class="logo-icon mobile-logo icon-light active" href="{{ route('user.home') }}"><img src="{{ asset('dashboard/img/brand/favicon.png') }}" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-dark active" href="{{ route('user.home') }}"><img src="{{ asset('dashboard/img/brand/favicon-white.png') }}" alt="logo"></a>
        </div>
        <div class="main-sidemenu">
            <div class="main-sidebar-loggedin">
                <div class="app-sidebar__user">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                            <img src="{{ Auth::guard('admin')->user()->image ? asset('storage/profile/' . Auth::guard('admin')->user()->image) : asset('dashboard/img/icons/user.png') }}" alt="user-img" class="rounded-circle mCS_img_loaded">
                        </div>
                        <div class="user-info">
                            <h6 class=" mb-0 text-dark">{{ Auth::guard('admin')->user()->name }}</h6>
                            <span class="text-muted app-sidebar__user-name text-sm">{{ Auth::guard('admin')->user()->username }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar-navs d-flex justify-content-center">
                <ul class="nav  nav-pills-circle">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Settings" aria-describedby="tooltip365540">
                        <a class="nav-link text-center m-2">
                            <i class="fe fe-settings"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Followers">
                        <a class="nav-link text-center m-2">
                            <i class="fe fe-user"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Logout">
                        <a class="nav-link text-center m-2" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fe fe-power"></i>
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu ">
                <li class="slide">
                    <a class="side-menu__item {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin.index') }}"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Dashboard</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ Request::is('admin/language') ? 'active' : '' }}" href="{{ route('admin.lang.index') }}"><i class="side-menu__icon fe fe-globe"></i><span class="side-menu__label">Site Language</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ Request::is('admin/settings/field/setting') ? 'active' : '' }}" href="{{ route('admin.setting.fieldSetting') }}"><i class="side-menu__icon fe fe-globe"></i><span class="side-menu__label">Manage Field</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ Request::is('admin/software/management') ? 'active' : '' }}" href="{{ route('admin.software.management.index') }}"><i class="side-menu__icon fe fe-globe"></i><span class="side-menu__label">Software Management</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ Request::is('admin/backup/logs') ? 'active' : '' }}" href="{{ route('admin.backup.logs') }}"><i class="side-menu__icon fe fe-globe"></i><span class="side-menu__label">Backup Logs</span></a>
                </li>
            </ul>
        </div>
    </aside>
</div>
