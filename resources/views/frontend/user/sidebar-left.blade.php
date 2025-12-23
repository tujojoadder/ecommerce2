@php
    $queryString = $_SERVER['QUERY_STRING'] ?? '';
@endphp
<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll overflow-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="{{ route('user.home') }}"> <img style="height: 70px !important;" src="{{ config('company.logo') }}" class="main-logo" alt="logo"></a>
            <a class="desktop-logo logo-dark active" href="{{ route('user.home') }}"><img style="height: 70px !important;" src="{{ config('company.logo') }}" class="main-logo" alt="logo"></a>

            <a class="logo-icon mobile-logo icon-light active" href="{{ route('user.home') }}"><img src="{{ asset('dashboard/img/brand/favicon.png') }}" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-dark active" href="{{ route('user.home') }}"><img src="{{ asset('dashboard/img/brand/favicon-white.png') }}" alt="logo"></a>
        </div>
        <div class="main-sidemenu" style="margin-top: 100px; height: 100vh; overflow-y: scroll;">
            <div class="main-sidebar-loggedin p-0 mt-0">
                <div class="app-sidebar__user">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-info">
                            <h6 class="text-dark">{{ Auth::user()->name }} (<span class="text-secondary">{{ Auth::user()->username }}</span>)</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar-navs d-flex justify-content-center p-0">
                <ul class="nav  nav-pills-circle">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Settings" aria-describedby="tooltip365540">
                        <a class="nav-link text-center m-2" href="{{ route('user.settings.index') }}">
                            <i class="fe fe-settings"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ __('messages.profile') }}">
                        <a class="nav-link text-center m-2" href="{{ route('user.profile.index') }}">
                            <i class="fe fe-user"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Logout">
                        <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fe fe-power"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            @canany(['access-all', 'sms-visibility'])
                @if (config('sidebar.sms') == 1)
                    <div class="text-center">
                        {{ __('messages.sms_balance') }}: <span id="sms-balance">0 ৳</span>
                        <a href="{{ route('recharge.sms.balance') }}" class=""><img width="90%" class="rounded-pill border border-info px-2 py-1" src="{{ asset('dashboard/img/add-balance.png') }}" alt=""></a>
                    </div>
                @endif
            @endcanany
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
            <ul class="side-menu " style="margin: 0.5rem !important;">
                <li class="slide">
                    <a class="side-menu__item {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user.home') }}"><img height="25" class="side-menu__icon" src="{{ asset('icon/new/dashboard.svg') }}" alt=""><span class="side-menu__label">{{ __('messages.dashboard') }}</span></a>
                </li>
                @canany(['access-all', 'client-visibility', 'supplier-visibility'])
                    @if (config('sidebar.crm') == 1)
                        <li class="slide {{ Request::is('user/supplier*') ? 'is-expanded' : '' }} {{ ($queryString == 'loan' || Request::is('user/client/loan') ? '' : Request::is('user/client*')) ? 'is-expanded' : '' }}">
                            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                                {{-- <i class="side-menu__icon fe fe-grid"></i> --}}
                                <img height="25" class="side-menu__icon" src="{{ asset('icon/new/crm.svg') }}" alt="">
                                <span class="side-menu__label">{{ __('messages.crm') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                @canany(['access-all', 'client-visibility'])
                                    @if (config('sidebar.clients') == 1)
                                        <li class="sub-slide {{ ($queryString == 'loan' || Request::is('user/client/loan') ? '' : Request::is('user/client*')) ? 'is-expanded bg-custom' : '' }}">
                                            <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.client') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                            <ul class="sub-slide-menu">
                                                <li class="sub-slide2">
                                                    @canany(['access-all', 'client-create'])
                                                        <a class="sub-side-menu__item {{ Request::is('user/client/create') ? 'active' : '' }}" href="{{ route('user.client.create') }}">{{ __('messages.add_new_client') }}</a>
                                                    @endcanany
                                                    <a class="sub-side-menu__item {{ Request::is('user/client') ? 'active' : '' }}" href="{{ route('user.client.index') }}">{{ __('messages.client') }} {{ __('messages.list') }}</a>
                                                    @if (config('sidebar.client_group') == 1)
                                                        @canany(['access-all', 'client-group-visibility'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/client/group') ? 'active' : '' }}" href="{{ route('user.client-group.index') }}">{{ __('messages.client') }} {{ __('messages.group') }}</a>
                                                        @endcanany
                                                    @endif
                                                    @if (config('sidebar.client_statement') == 1)
                                                        @canany(['access-all', 'client-view'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/client/statements') ? 'active' : '' }}" href="{{ route('user.client.statements') }}">{{ __('messages.client') }} {{ __('messages.statement') }}</a>
                                                        @endcanany
                                                    @endif
                                                    @if (config('client.remaining_due_date') == 1)
                                                        @canany(['access-all', 'client-remaining-due-date-view'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/client/remaining/due/date') ? 'active' : '' }}" href="{{ route('user.client.remaining.due.list') }}">{{ __('messages.remaining_due_date') }}</a>
                                                        @endcanany
                                                    @endif
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endcanany
                                @canany(['access-all', 'supplier-visibility'])
                                    @if (config('sidebar.suppliers') == 1)
                                        <li class="sub-slide {{ Request::is('user/supplier*') ? 'is-expanded bg-custom' : '' }}">
                                            <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.supplier') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                            <ul class="sub-slide-menu">
                                                <li class="sub-slide2">
                                                    @canany(['access-all', 'supplier-create'])
                                                        <a class="sub-side-menu__item {{ Request::is('user/supplier/create') ? 'active' : '' }}" href="{{ route('user.supplier.create') }}">{{ __('messages.add_new_supplier') }}</a>
                                                    @endcanany
                                                    <a class="sub-side-menu__item {{ Request::is('user/supplier') ? 'active' : '' }}" href="{{ route('user.supplier.index') }}">{{ __('messages.supplier') }} {{ __('messages.list') }}</a>
                                                    @if (config('sidebar.supplier_group') == 1)
                                                        @canany(['access-all', 'supplier-group-visibility'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/supplier/group') ? 'active' : '' }}" href="{{ route('user.supplier-group.index') }}">{{ __('messages.supplier') }} {{ __('messages.group') }}</a>
                                                        @endcanany
                                                    @endif
                                                    @if (config('sidebar.supplier_statement') == 1)
                                                        @canany(['access-all', 'supplier-view'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/supplier/statements') ? 'active' : '' }}" href="{{ route('user.supplier.statements') }}">{{ __('messages.supplier') }} {{ __('messages.statement') }}</a>
                                                        @endcanany
                                                    @endif
                                                    @if (config('supplier.remaining_due_date') == 1)
                                                        @canany(['access-all', 'supplier-remaining-due-date-view'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/supplier/remaining/due/date') ? 'active' : '' }}" href="{{ route('user.supplier.remaining.due.list') }}">{{ __('messages.remaining_due_date') }}</a>
                                                        @endcanany
                                                    @endif
                                                    @if (config('supplier.cheque_schedule') == 1)
                                                        @canany(['access-all', 'supplier-cheque-schedule'])
                                                            <a class="sub-side-menu__item {{ Request::is('user/supplier/cheque/schedule') ? 'active' : '' }}" href="{{ route('user.cheque.schudule.index') }}">{{ __('messages.cheque_schedule') }}</a>
                                                        @endcanany
                                                    @endif
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endcanany
                            </ul>
                        </li>
                    @endif
                @endcanany

                @canany(['access-all', 'account-visibility', 'receive-visibility', 'expense-visibility', 'transfer-visibility', 'profit-view'])
                    @if (config('sidebar.accounts') == 1)
                        <li class="slide {{ Request::is('user/account*') ? 'is-expanded' : '' }} {{ Request::is('user/total/balance/report') ? 'is-expanded' : '' }} {{ Request::is('user/transfer*') ? 'is-expanded' : '' }} {{ Request::is('user/profit*') ? 'is-expanded' : '' }} {{ Request::is('user/receive*') ? 'is-expanded' : '' }} {{ Request::is('user/expense*') && !$queryString == 'create-staff-payment' && !$queryString == 'staff-payment' ? 'is-expanded' : '' }}">
                            <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                                <img height="25" class="side-menu__icon" src="{{ asset('icon/new/account.svg') }}" alt="">
                                <span class="side-menu__label">{{ __('messages.account') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                @canany(['access-all', 'receive-visibility'])
                                    @if (config('sidebar.receive') == 1)
                                        <li class="sub-slide {{ Request::is('user/receive*') ? 'is-expanded' : '' }}">
                                            <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.receive') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                            <ul class="sub-slide-menu">
                                                <li class="sub-slide2">
                                                    @canany(['access-all', 'receive-create'])
                                                        <a class="sub-side-menu__item {{ $queryString == 'create' ? 'active' : '' }}" href="{{ route('user.receive.index') }}?create">{{ __('messages.receive_from_client') }}</a>
                                                        <a class="sub-side-menu__item {{ $queryString == 'supplier-receive' ? 'active' : '' }}" href="{{ route('user.receive.index') }}?supplier-receive">{{ __('messages.receive_from_supplier') }}</a>
                                                    @endcanany
                                                    <a class="sub-side-menu__item {{ ($queryString == 'create' || $queryString == 'supplier-receive' ? '' : Request::is('user/receive')) ? 'active' : '' }}" href="{{ route('user.receive.index') }}">{{ __('messages.receive') }} {{ __('messages.list') }}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endcanany
                                @canany(['access-all', 'expense-visibility'])
                                    @if (config('sidebar.expense') == 1)
                                        <li class="sub-slide {{ Request::is('user/expense*') && !$queryString == 'create-staff-payment' && !$queryString == 'staff-payment' ? 'is-expanded' : '' }}">
                                            <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.expense') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                            <ul class="sub-slide-menu">
                                                <li class="sub-slide2">
                                                    @php
                                                        $expenseMenuActivation = ($queryString == 'supplier-payment' || $queryString == 'create-supplier-payment' || $queryString == 'create-personal-expense' || $queryString == 'personal-expense' || $queryString == 'create-daily-expense' || $queryString == 'daily-expense' || $queryString == 'money-return' || $queryString == 'create-money-return' || $queryString == 'create-expense' ? '' : Request::is('user/expense')) ? 'active' : '';
                                                    @endphp
                                                    @canany(['access-all', 'expense-create'])
                                                        <a class="sub-side-menu__item {{ $queryString == 'create-expense' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?create-expense">{{ __('messages.add_new') }}</a>
                                                    @endcanany
                                                    <a class="sub-side-menu__item {{ $expenseMenuActivation }}" href="{{ route('user.expense.index') }}">{{ __('messages.expense') }} {{ __('messages.list') }}</a>
                                                    @if (config('sidebar.personal_expense') == 1)
                                                        <a class="sub-side-menu__item {{ $queryString == 'personal-expense' || $queryString == 'create-personal-expense' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?personal-expense">{{ __('messages.personal_expense') }}</a>
                                                    @endif
                                                    @if (config('sidebar.daily_expense') == 1)
                                                        <a class="sub-side-menu__item {{ $queryString == 'daily-expense' || $queryString == 'create-daily-expense' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?daily-expense">{{ __('messages.daily_expense') }}</a>
                                                    @endif
                                                    @canany(['access-all', 'supplier-payment-create'])
                                                        <a class="sub-side-menu__item {{ $queryString == 'supplier-payment' || $queryString == 'create-supplier-payment' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?supplier-payment">{{ __('messages.supplier') }} {{ __('messages.payment') }}</a>
                                                    @endcanany
                                                    @canany(['access-all', 'client-money-return-visibility'])
                                                        <a class="sub-side-menu__item {{ $queryString == 'money-return' || $queryString == 'create-money-return' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?money-return">{{ __('messages.client') }} {{ __('messages.money') }} {{ __('messages.return') }}</a>
                                                    @endcanany
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endcanany
                                @canany(['access-all', 'account-visibility'])
                                    @if (config('sidebar.account') == 1)
                                        <li class="sub-slide {{ Request::is('user/account*') ? 'is-expanded' : '' }}">
                                            <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.account') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                            <ul class="sub-slide-menu">
                                                <li class="sub-slide2">
                                                    @canany(['access-all', 'account-create'])
                                                        <a class="sub-side-menu__item {{ Request::is('user/account/create') ? 'active' : '' }}" href="{{ route('user.account.create') }}">{{ __('messages.account') }} {{ __('messages.create') }}</a>
                                                    @endcanany
                                                    <a class="sub-side-menu__item {{ Request::is('user/account') ? 'active' : '' }}" href="{{ route('user.account.index') }}">{{ __('messages.account') }} {{ __('messages.list') }}</a>
                                                    @canany(['access-all', 'account-view'])
                                                        @if (config('sidebar.account_balance') == 1)
                                                            <a class="sub-side-menu__item {{ Request::is('user/account/view/balance') ? 'active' : '' }}" href="{{ route('user.account.view.balance') }}">{{ __('messages.account') }} {{ __('messages.balance') }}</a>
                                                        @endif
                                                        @if (config('sidebar.account_statement') == 1)
                                                            <a class="sub-side-menu__item {{ Request::is('user/account/view/statement') ? 'active' : '' }}" href="{{ route('user.account.view.statement') }}">{{ __('messages.statement') }}</a>
                                                        @endif
                                                    @endcanany
                                                <li><a class="sub-side-menu__item {{ Request::is('user/account/total') ? 'active' : '' }}" href="{{ route('user.account.total') }}">{{ __('messages.total') }}</a></li>
                                        </li>
                                </ul>
                            </li>
                        @endif
                    @endcanany
                    @canany(['access-all', 'transfer-visibility'])
                        @if (config('sidebar.transfer') == 1)
                            <li class="sub-slide {{ Request::is('user/transfer*') ? 'is-expanded' : '' }}">
                                <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.transfer') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                <ul class="sub-slide-menu">
                                    <li class="sub-slide2">
                                        @canany(['access-all', 'transfer-create'])
                                            <a class="sub-side-menu__item {{ Request::is('user/transfer/create') ? 'active' : '' }}" data-bs-toggle="sub-slide" href="{{ route('user.transfer.create') }}">{{ __('messages.transfer') }} {{ __('messages.create') }}</a>
                                        @endcanany
                                        <a class="sub-side-menu__item {{ Request::is('user/transfer') ? 'active' : '' }}" data-bs-toggle="sub-slide" href="{{ route('user.transfer.index') }}">{{ __('messages.transfer') }} {{ __('messages.list') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endcanany
                    @canany(['access-all', 'profit-view'])
                        @if (config('sidebar.profit') == 1)
                            <li><a class="sub-side-menu__item {{ Request::is('user/profit') ? 'active' : '' }}" href="{{ route('user.profit.index') }}">{{ __('messages.profit') }}</a></li>
                        @endif
                    @endcanany
                    @canany(['access-all', 'total-balance-report-view'])
                        @if (config('sidebar.total_balance_report') == 1)
                            <li class="sub-slide">
                                <a class="slide-item {{ Request::is('user/total/balance/report') ? 'active' : '' }}" href="{{ route('user.total.balance.report') }}"><span class="sub-side-menu__label">{{ __('messages.total_balance_report') }}</span></a>
                            </li>
                        @endif
                    @endcanany
                </ul>
                </li>
                @endif
            @endcanany

            @canany(['access-all', 'project-visibility'])
                @if (config('sidebar.project') == 1)
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;"><i class="side-menu__icon far fa-money-bill-alt"></i><span class="side-menu__label">{{ __('messages.project') }}</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item" href="{{ route('user.project.index') }}?create">{{ __('messages.project') }} {{ __('messages.create') }}</a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.project.index') }}">{{ __('messages.project') }} {{ __('messages.list') }}</a></li>
                            <li><a class="sub-side-menu__item" href="">{{ __('messages.project') }} {{ __('messages.statement') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'loan-visibility'])
                @if (config('sidebar.loan') == 1)
                    <li class="slide {{ $queryString == 'loan' || $queryString == 'loan-receive' || $queryString == 'loan-payment' || Request::is('user/client/loan') || Request::is('user/loan') ? 'is-expanded bg-custom' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/invoice.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.loan') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @canany(['access-all', 'client-create'])
                                <li><a class="sub-side-menu__item {{ Request::is('user/client/create') ? 'active' : '' }}" href="{{ route('user.client.create') }}?loan">{{ __('messages.add_new_client') }}</a></li>
                            @endcanany
                            <li><a class="sub-side-menu__item {{ Request::is('user/client/loan') ? 'active' : '' }}" href="{{ route('user.client.loan.client') }}?loan">{{ __('messages.client') }} {{ __('messages.list') }}</a></li>
                            @canany(['access-all', 'client-loan-create', 'client-loan-visibility'])
                                <li><a class="sub-side-menu__item {{ $queryString == 'loan-receive' ? 'active' : '' }}" href="{{ route('user.loan.index') }}?loan-receive">{{ __('messages.loan_receive') }}</a></li>
                                <li><a class="sub-side-menu__item {{ $queryString == 'loan-payment' ? 'active' : '' }}" href="{{ route('user.loan.index') }}?loan-payment">{{ __('messages.loan_payment') }}</a></li>
                            @endcanany
                        </ul>
                    </li>
                @endif
            @endcanany
            @canany(['access-all'])

                    <li class="slide {{ Request::is('user/order*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/invoice.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.order') }} {{ __('messages.list') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @canany(['access-all'])
                                <li><a class="sub-side-menu__item {{ Request::is('user/order?requested') ? 'active' : '' }}" href="{{ route('user.order.index') }}?requested">{{ __('messages.requested') }} {{ __('messages.order') }}</a></li>
                                <li><a class="sub-side-menu__item {{ Request::is('user/order?placed') ? 'active' : '' }}" href="{{ route('user.order.index') }}?placed">{{ __('messages.placed') }} {{ __('messages.order') }}</a></li>
                                <li><a class="sub-side-menu__item {{ Request::is('user/order?process') ? 'active' : '' }}" href="{{ route('user.order.index') }}?process">{{ __('messages.process') }} {{ __('messages.order') }}</a></li>
                                <li><a class="sub-side-menu__item {{ Request::is('user/order?delivered') ? 'active' : '' }}" href="{{ route('user.order.index') }}?delivered">{{ __('messages.delivered') }} {{ __('messages.order') }}</a></li>
                                <li><a class="sub-side-menu__item {{ Request::is('user/order?rejected') ? 'active' : '' }}" href="{{ route('user.order.index') }}?rejected">{{ __('messages.rejected') }} {{ __('messages.order') }}</a></li>
                            @endcanany

                        </ul>
                    </li>
            @endcanany

            @canany(['access-all', 'invoice-visibility', 'draft-invoice-visibility'])
                @if (config('sidebar.invoice') == 1)
                    <li class="slide {{ Request::is('user/invoice*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/invoice.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.bill') }} {{ __('messages.invoice') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @canany(['access-all', 'invoice-create'])
                                <li><a class="sub-side-menu__item {{ request()->routeIs('user.invoice.create') ? 'active' : '' }}" href="{{ route('user.invoice.create') }}">{{ __('messages.add_new') }}</a></li>
                                {{-- <li><a class="sub-side-menu__item {{ $queryString == 'create' ? 'active' : '' }}" href="{{ route('user.invoice.index') }}?create">{{ __('messages.add_new') }}</a></li> --}}
                            @endcanany
                            @canany(['access-all', 'invoice-view', 'invoice-visibility'])
                                <li><a class="sub-side-menu__item {{ ($queryString == 'create' ? '' : Request::is('user/invoice') && $queryString !== 'draft' && $queryString !== 'sales-return') ? 'active' : '' }}" href="{{ route('user.invoice.index') }}">{{ __('messages.invoice') }} {{ __('messages.list') }}</a></li>
                            @endcanany
                            @if (config('sidebar.draft_invoice') == 1)
                                @canany(['access-all', 'draft-invoice-visibility'])
                                    <li class="sub-slide {{ $queryString == 'draft' || request()->routeIs('user.invoice.create.draft') ? 'is-expanded bg-custom' : '' }}">
                                        <a class="slide-item {{ $queryString == 'draft' || request()->routeIs('user.invoice.create.draft') ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.draft') }} {{ __('messages.invoice') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu">
                                            <li class="sub-slide2"></li>
                                            <li><a class="sub-side-menu__item {{ request()->routeIs('user.invoice.create.draft') ? 'active' : '' }}" href="{{ route('user.invoice.create.draft') }}"> {{ __('messages.add') }} {{ __('messages.draft') }}</a></li>
                                            <li><a class="sub-side-menu__item {{ $queryString == 'draft' ? 'active' : '' }}" href="{{ route('user.invoice.index') }}?draft"> {{ __('messages.draft') }} {{ __('messages.invoice') }}</a></li>
                                        </ul>
                                    </li>
                                @endcanany
                            @endif
                            @if (config('sidebar.invoice_return') == 1)
                                <li class="sub-slide {{ request()->routeIs('user.invoice.create.return') || request()->routeIs('user.invoice.sales.return') || $queryString == 'sales-return' ? 'is-expanded bg-custom' : '' }}">
                                    <a class="slide-item {{ request()->routeIs('user.invoice.create.return') || request()->routeIs('user.invoice.sales.return') || $queryString == 'sales-return' ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.sales') }} {{ __('messages.return') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu">
                                        <li class="sub-slide2">
                                            <a class="sub-side-menu__item {{ request()->routeIs('user.invoice.create.return') ? 'active' : '' }}" href="{{ route('user.invoice.create.return') }}">{{ __('messages.add') }} {{ __('messages.return') }}</a>
                                            {{-- <a class="sub-side-menu__item {{ $queryString == 'sales-return' ? 'active' : '' }}" href="{{ route('user.invoice.index') }}?sales-return">{{ __('messages.add') }} {{ __('messages.return') }}</a> --}}
                                            <a class="sub-side-menu__item {{ request()->routeIs('user.invoice.sales.return') ? 'active' : '' }}" href="{{ route('user.invoice.sales.return') }}">{{ __('messages.return') }} {{ __('messages.list') }}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'asset-n-stock-visibility'])
                @if (config('sidebar.asset_and_stock') == 1)
                    <li class="slide {{ Request::is('user/asset-and-stock*') ? 'is-expanded bg-custom' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/product.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.asset') }} {{ __('messages.and') }} {{ __('messages.stock') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item {{ $queryString == 'stock-list' ? 'active' : '' }}" href="{{ route('user.asset-and-stock.index') }}?stock-list">{{ __('messages.stock') }} {{ __('messages.list') }}</a></li>
                            <li><a class="sub-side-menu__item {{ $queryString == 'asset-list' ? 'active' : '' }}" href="{{ route('user.asset-and-stock.index') }}?asset-list">{{ __('messages.asset') }} {{ __('messages.list') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'raw-material-visibility'])
                @if (config('sidebar.raw_material') == 1)
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;"><i class="side-menu__icon fas fa-cart-plus"></i><span class="side-menu__label">{{ __('messages.raw_metarial') }}</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item" href="{{ route('user.metarial.index') }}">{{ __('messages.raw_metarial') }} {{ __('messages.list') }} </a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.metarial.buy') }}">{{ __('messages.raw_metarial') }} {{ __('messages.purchase') }} </a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.metarial.stock') }}">{{ __('messages.stock') }}</a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.metarial.group') }}">{{ __('messages.group') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'batch-product-visibility'])
                @if (config('sidebar.batch_product') == 1)
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <i class="side-menu__icon fab fa-squarespace ul_i_menu"></i>
                            <span class="side-menu__label">{{ __('messages.batch') }} {{ __('messages.product') }}</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item" href="{{ route('user.batchProduct.create') }}">{{ __('messages.batch') }} {{ __('messages.product') }} {{ __('messages.create') }}</a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.batchProduct.index') }}">{{ __('messages.batch') }} {{ __('messages.product') }} {{ __('messages.list') }}</a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.batchProduct.transfer') }}">{{ __('messages.batch') . ' ' . __('messages.product') . ' ' . __('messages.transfer') }}</a></li>
                            <li><a class="sub-side-menu__item" href="{{ route('user.batchProduct.transfer.report') }}">{{ __('messages.batch') . ' ' . __('messages.product') . ' ' . __('messages.transfer') . ' ' . __('messages.report') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'product-visibility', 'product-group-visibility', 'product-unit-visibility', 'product-asset-visibility', 'product-barcode-visibility', 'product-purchase-visibility'])
                @if (config('sidebar.products') == 1)
                    <li class="slide  {{ Request::is('user/product*') || Request::is('user/purchase*') || Request::is('user/warehouse*') || Request::is('user/stock*') || Request::is('user/category*') || Request::is('user/subcategory*') || Request::is('user/subsubcategory*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            {{-- <i class="side-menu__icon fe fe-grid"></i> --}}
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/product.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.product') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @canany(['access-all', 'product-visibility', 'product-group-visibility'])
                                @if (config('sidebar.product') == 1)
                                    <li class="sub-slide {{ (Request::is('user/product*') && !Request::is('user/product-*')) || Request::is('user/product-group')  || Request::is('user/category*')  || Request::is('user/subcategory*') || Request::is('user/subsubcategory*') ? 'is-expanded bg-custom' : '' }}">
                                        <a class="slide-item {{ (Request::is('user/product*') && !Request::is('user/product-*')) || Request::is('user/product-group') ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.product') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu">
                                            <li class="sub-slide2">
                                                <a class="sub-side-menu__item {{ Request::is('user/product/create') ? 'active' : '' }}" href="{{ route('user.product.create') }}">{{ __('messages.product') . ' ' . __('messages.create') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/product') ? 'active' : '' }}" href="{{ route('user.product.index') }}">{{ __('messages.product') }} {{ __('messages.list') }}</a>
                                                @if (config('sidebar.product_group') == 1)
                                                    <a class="sub-side-menu__item {{ Request::is('user/product-group*') ? 'active' : '' }}" href="{{ route('user.product-group.index') }}">{{ __('messages.product') . ' ' . __('messages.group') }}</a>
                                                @endif
                                                <li><a class="sub-side-menu__item {{ Request::is('user/category') ? 'active' : '' }}" href="{{ route('user.category.index') }}">{{ __('messages.product') }} {{ __('messages.category') }}</a></li>
                                                <li><a class="sub-side-menu__item {{ Request::is('user/subcategory') ? 'active' : '' }}" href="{{ route('user.subcategory.index') }}">{{ __('messages.product') }} {{ __('messages.subcategory') }}</a></li>
                                                <li><a class="sub-side-menu__item {{ Request::is('user/subsubcategory') ? 'active' : '' }}" href="{{ route('user.subsubcategory.index') }}">{{ __('messages.product') }} {{ __('messages.subsubcategory') }}</a></li>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            @endcanany
                            @canany(['access-all', 'product-asset-visibility', 'product-barcode-visibility', 'product-unit-visibility'])
                                <li class="sub-slide {{ Request::is('user/product-*') && !Request::is('user/product-group') ? 'is-expanded bg-custom' : '' }}">
                                    <a class="slide-item {{ Request::is('user/product-*') && !Request::is('user/product-group') ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.product') }} {{ __('messages.asset') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu">
                                        <li class="sub-slide2">
                                            @if (config('sidebar.product_asset') == 1)
                                                @if (config('sidebar.product_brand') == 1)
                                                    <a class="sub-side-menu__item {{ $queryString == 'brand' ? 'active' : '' }}" href="{{ route('user.product-asset.index') }}?brand">{{ __('messages.product') }} {{ __('messages.brand') }}</a>
                                                @endif
                                                @if (config('sidebar.product_size') == 1)
                                                    <a class="sub-side-menu__item {{ $queryString == 'size' ? 'active' : '' }}" href="{{ route('user.product-asset.index') }}?size">{{ __('messages.product') }} {{ __('messages.size') }}</a>
                                                @endif
                                                @if (config('sidebar.product_color') == 1)
                                                    <a class="sub-side-menu__item {{ $queryString == 'color' ? 'active' : '' }}" href="{{ route('user.product-asset.index') }}?color">{{ __('messages.product') }} {{ __('messages.color') }}</a>
                                                @endif
                                                @if (config('sidebar.product_unit') == 1)
                                                    <a class="sub-side-menu__item {{ Request::is('user/product-unit') ? 'active' : '' }}" href="{{ route('user.product-unit.index') }}">{{ __('messages.product') }} {{ __('messages.unit') }}</a>
                                                @endif
                                                @if (config('sidebar.product_barcode') == 1)
                                                    <a class="sub-side-menu__item {{ Request::is('user/product-barcode') ? 'active' : '' }}" href="{{ route('user.product-barcode.index') }}">{{ __('messages.product') }} {{ __('messages.barcode') }}</a>
                                                @endif
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            @endcanany
                            @canany(['access-all', 'product-purchase-visibility'])
                                @if (config('sidebar.purchase') == 1)
                                    <li class="sub-slide  {{ $queryString != 'purchase-return' && !Request::is('user/purchase/return') && Request::is('user/purchase*') ? 'is-expanded bg-custom' : '' }}">
                                        <a class="slide-item {{ $queryString != 'purchase-return' && !Request::is('user/purchase/return') && Request::is('user/purchase*') ? 'active' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.purchase') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu {{ $queryString != 'purchase-return' && !Request::is('user/purchase/return') && Request::is('user/purchase*') ? 'open' : '' }}">
                                            <li class="sub-slide2">
                                                <a class="sub-side-menu__item {{ $queryString != 'purchase-return' && !Request::is('user/purchase/return') && Request::is('user/purchase/create') ? 'active' : '' }}" href="{{ route('user.purchase.create') }}">{{ __('messages.add_new') }}</a>
                                                <a class="sub-side-menu__item {{ $queryString != 'purchase-return' && !Request::is('user/purchase/return') && Request::is('user/purchase') ? 'active' : '' }}" href="{{ route('user.purchase.index') }}">{{ __('messages.purchase') }} {{ __('messages.list') }}</a>
                                                @if (config('sidebar.invoice_wise_purchase') == 1)
                                                    <a class="sub-side-menu__item {{ Request::is('user/purchase/invoice') ? 'active' : '' }}" href="{{ route('user.purchase.invoice') }}">{{ __('messages.purchase') }} {{ __('messages.invoice') }} {{ __('messages.list') }}</a>
                                                @endif
                                                @if (config('sidebar.purchase_report') == 1)
                                                    <a class="sub-side-menu__item {{ Request::is('user/purchase/report*') ? 'active' : '' }}" href="{{ route('user.purchase.report') }}">{{ __('messages.purchase') }} {{ __('messages.report') }}</a>
                                                @endif
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                @if (config('sidebar.purchase_return') == 1)
                                    <li class="sub-slide  {{ $queryString == 'purchase-return' || Request::is('user/purchase/return*') ? 'is-expanded bg-custom' : '' }}">
                                        <a class="slide-item {{ $queryString == 'purchase-return' || Request::is('user/purchase/return*') ? 'active' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.purchase') }} {{ __('messages.return') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu {{ $queryString == 'purchase-return' || Request::is('user/purchase/return*') ? 'open' : '' }}">
                                            <li class="sub-slide2">
                                                <a class="sub-side-menu__item {{ $queryString == 'purchase-return' ? 'active' : '' }}" href="{{ route('user.purchase.create') }}?purchase-return">{{ __('messages.add_new') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/purchase/return') ? 'active' : '' }}" href="{{ route('user.purchase.return') }}">{{ __('messages.purchase') }} {{ __('messages.return') }} {{ __('messages.list') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/purchase/return/invoice') ? 'active' : '' }}" href="{{ route('user.purchase.return.invoice') }}">{{ __('messages.return') }} {{ __('messages.invoice') }} {{ __('messages.list') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/purchase/return/report') ? 'active' : '' }}" href="{{ route('user.purchase.return.report') }}">{{ __('messages.purchase') }} {{ __('messages.return') }} {{ __('messages.report') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            @endcanany
                            @canany(['access-all', 'warehouse-visibility'])
                                @if (config('sidebar.warehouse') == 1)
                                    <li class="sub-slide">
                                        <a class="slide-item {{ Request::is('user/warehouse') ? 'active' : '' }}" data-bs-toggle="sub-slide" href="{{ route('user.warehouse.index') }}"><span class="sub-side-menu__label">{{ __('messages.warehouse') }}</span></a>
                                    </li>
                                @endif
                            @endcanany
                            @if (config('sidebar.product_stock') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/stock') ? 'active' : '' }}" href="{{ route('user.stock.index') }}">{{ __('messages.product') }} {{ __('messages.stock') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'sms-visibility'])
                @if (config('sidebar.sms') == 1)
                    <li class="slide {{ Request::is('user/sms*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            {{-- <i class="side-menu__icon far fa-money-bill-alt"></i> --}}
                            <img class="side-menu__icon" src="{{ asset('icon/sms.svg') }}" type="">
                            <span class="side-menu__label">{{ __('messages.sms') }}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item {{ Route::is('user.sms.send.to.client') ? 'active' : '' }}" href="{{ route('user.sms.send.to.client') }}">{{ __('messages.customer') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Route::is('user.sms.send.to.client.group') ? 'active' : '' }}" href="{{ route('user.sms.send.to.client.group') }}">{{ __('messages.customer') }} {{ __('messages.group') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Route::is('user.sms.send.to.supplier') ? 'active' : '' }}" href="{{ route('user.sms.send.to.supplier') }}">{{ __('messages.supplier') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Route::is('user.sms.send.to.supplier.group') ? 'active' : '' }}" href="{{ route('user.sms.send.to.supplier.group') }}">{{ __('messages.supplier') }} {{ __('messages.group') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Route::is('user.sms.send.schedule.wise') ? 'active' : '' }}" href="{{ route('user.sms.send.schedule.wise') }}">{{ __('messages.sms') }} {{ __('messages.shedule') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Route::is('user.sms.schedule.sms.report') ? 'active' : '' }}" href="{{ route('user.sms.schedule.sms.report') }}">{{ __('messages.shedule') }} {{ __('messages.report') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'staff-visibility'])
                @if (config('sidebar.staff') == 1)
                    <li class="slide {{ ($queryString !== 'user' && Request::is('user/staff*')) || $queryString == 'staff-payment' || $queryString == 'create-staff-payment' ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/Stuff.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.staff') }}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item {{ Request::is('user/staff/create') ? 'active' : '' }}" href="{{ route('user.staff.create') }}">{{ __('messages.staff') }} {{ __('messages.create') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Request::is('user/staff') ? 'active' : '' }}" href="{{ route('user.staff.index') }}">{{ __('messages.staff') }} {{ __('messages.list') }}</a></li>
                            @can('access-all', 'staff-payment-visibility')
                                <li class="sub-slide {{ $queryString == 'staff-payment' || $queryString == 'create-staff-payment' ? 'is-expanded bg-custom' : '' }}">
                                    <a class="slide-item {{ $queryString == 'staff-payment' || $queryString == 'create-staff-payment' ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.staff') }} {{ __('messages.payment') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu">
                                        <li class="sub-slide2">
                                            @can('access-all', 'staff-payment-create')
                                                <a class="sub-side-menu__item {{ $queryString == 'create-staff-payment' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?create-staff-payment">{{ __('messages.payment') }} {{ __('messages.create') }} </a>
                                            @endcan
                                            @can('access-all', 'staff-payment-view', 'staff-payment-visibility')
                                                <a class="sub-side-menu__item {{ $queryString == 'staff-payment' ? 'active' : '' }}" href="{{ route('user.expense.index') }}?staff-payment">{{ __('messages.staff') }} {{ __('messages.payment') }} {{ __('messages.report') }}</a>
                                            @endcan
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('access-all', 'staff-salary-visibility')
                                <li class="sub-slide {{ Request::is('user/staff/salary*') ? 'is-expanded bg-custom' : '' }}">
                                    <a class="slide-item {{ Request::is('user/staff/salary*') ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.staff') }} {{ __('messages.sallary') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu">
                                        <li class="sub-slide2">
                                            @can('access-all', 'staff-salary-create')
                                                <a class="sub-side-menu__item {{ Request::is('user/staff/salary/create') ? 'active' : '' }}" href="{{ route('user.staff.salary.create') }}">{{ __('messages.add') }} {{ __('messages.sallary') }}</a>
                                            @endcan
                                            @can('access-all', 'staff-salary-view')
                                                <a class="sub-side-menu__item {{ Request::is('user/staff/salary') ? 'active' : '' }}" href="{{ route('user.staff.salary.index') }}">{{ __('messages.sallary') }} {{ __('messages.report') }}</a>
                                            @endcan
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('access-all', 'staff-attendance-visibility')
                                <li class="sub-slide {{ Request::is('user/staff/attendance*') ? 'is-expanded bg-custom' : '' }}">
                                    <a class="slide-item {{ Request::is('user/staff/attendance*') ? 'is-expanded' : '' }}" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label ">{{ __('messages.staff') }} {{ __('messages.attendance') }} </span><i class="sub-angle fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu">
                                        <li class="sub-slide2">
                                            @can('access-all', 'staff-attendance-create')
                                                <a class="sub-side-menu__item {{ Request::is('user/staff/attendance/create') ? 'active' : '' }}" href="{{ route('user.staff.attendance.create') }}">{{ __('messages.attendance') }} {{ __('messages.create') }}</a>
                                            @endcan
                                            @can('access-all', 'staff-attendance-view')
                                                <a class="sub-side-menu__item {{ Request::is('user/staff/attendance') ? 'active' : '' }}" href="{{ route('user.staff.attendance.index') }}">{{ __('messages.attendance') }} {{ __('messages.report') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/staff/attendance/monthly') ? 'active' : '' }}" href="{{ route('user.staff.attendance.monthly') }}">{{ __('messages.monthly') }} {{ __('messages.attendance') }} {{ __('messages.report') }}</a>
                                            @endcan
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('access-all', 'staff-department-visibility')
                                <li><a class="sub-side-menu__item {{ Request::is('user/staff/department*') ? 'active' : '' }}" href="{{ route('user.department.index') }}">{{ __('messages.staff') }} {{ __('messages.department') }}</a></li>
                            @endcan
                            @can('access-all', 'staff-designation-visibility')
                                <li><a class="sub-side-menu__item {{ Request::is('user/staff/designation*') ? 'active' : '' }}" href="{{ route('user.designation.index') }}">{{ __('messages.staff') }} {{ __('messages.designation') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'branch-visibility'])
                @if (config('sidebar.branch') == 1)
                    <li class="slide {{ Request::is('user/branch') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/due-report.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.branch') }}</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item {{ Request::is('user/branch') ? 'active' : '' }}" href="{{ route('user.branch.index') }}">{{ __('messages.branch') }} {{ __('messages.list') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all'])
                @if (config('sidebar.office_purchase') == 1)
                    <li class="slide">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            {{-- <i class="side-menu__icon far fa-money-bill-alt"></i> --}}
                            <img class="side-menu__icon" src="{{ asset('icon/cart2.svg') }}" type="">
                            <span class="side-menu__label">{{ __('messages.office') }} {{ __('messages.purchase') }}</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="sub-side-menu__item" href="#" onclick="comingSoon()">{{ __('messages.purchase') }} {{ __('messages.report') }}</a></li>
                            <li><a class="sub-side-menu__item" href="#" onclick="comingSoon()">{{ __('messages.purchase') }} {{ __('messages.supplier') }} {{ __('messages.report') }}</a></li>
                            <li><a class="sub-side-menu__item" href="#">{{ __('messages.due') }} {{ __('messages.list') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'due-report'])
                <li class="slide {{ Request::is('user/report/due-report') || Request::is('user/report/due-report/customerwise/report') || Request::is('user/report/due-report/groupwise/report') || Request::is('user/report/sales*') || Request::is('user/report/deposit*') || (Request::is('user/report/expense*') && !$queryString == 'create-staff-payment') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                        <img height="25" class="side-menu__icon" src="{{ asset('icon/new/due-report.svg') }}" alt="">
                        <span class="side-menu__label">{{ __('messages.report') }}</span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @if (config('sidebar.sales_report') == 1)
                            @if (config('sidebar.sales_report_all') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/sales*') ? 'active' : '' }}" href="{{ route('user.report.sales.sales') }}">{{ __('messages.sales_report') }}</a></li>
                            @endif
                        @endif
                        @if (config('sidebar.deposit_report') == 1)
                            <li><a class="sub-side-menu__item {{ Request::is('user/report/deposit*') ? 'active' : '' }}" href="{{ route('user.report.deposit.all') }}">{{ __('messages.deposit_report') }}</a></li>
                        @endif
                        @if (config('sidebar.expense_report') == 1)
                            <li><a class="sub-side-menu__item {{ Request::is('user/report/expense*') ? 'active' : '' }} " href="{{ route('user.report.expense.all') }}">{{ __('messages.expense_report') }}</a></li>
                        @endif
                        @if (config('sidebar.due_report') == 1)
                            <li><a class="sub-side-menu__item {{ Request::is('user/report/due-report*') ? 'active' : '' }}" href="{{ route('user.report.due-report.index') }}">{{ __('messages.due_report') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endcanany

            {{-- @canany(['access-all', 'sales-report'])
                @if (config('sidebar.sales_report') == 1)
                    <li class="slide {{ Request::is('user/report/sales*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/sales-report.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.sales') }} {{ __('messages.report') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @php
                                $salesQueryCondition = $queryString == 'daily-search' || 'customer-search' || 'group-search' || 'product-search';
                            @endphp

                            @if (config('sidebar.sales_report_daily') == 1)
                                <li><a class="sub-side-menu__item {{ $queryString == 'daily-search' ? 'active' : '' }}" href="{{ route('user.report.sales.sales') }}?daily-search">{{ __('messages.daily') }}</a></li>
                            @endif
                            <hr class="my-0">
                            @if (config('sidebar.sales_report_customer_wise') == 1)
                                <li><a class="sub-side-menu__item {{ $queryString == 'customer-search' ? 'active' : '' }}" href="{{ route('user.report.sales.sales.customer.wise') }}?customer-search">{{ __('messages.customer') }} {{ __('messages.wise') }}</a></li>
                            @endif
                            @if (config('sidebar.sales_report_group_wise') == 1)
                                <li><a class="sub-side-menu__item {{ $queryString == 'group-search' ? 'active' : '' }}" href="{{ route('user.report.sales.sales') }}?group-search">{{ __('messages.client') }} {{ __('messages.group') }} {{ __('messages.wise') }}</a></li>
                            @endif
                            <hr class="my-0">
                            @if (config('sidebar.sales_report_product_wise') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/sales/product-wise') ? 'active' : '' }}" href="{{ route('user.report.sales.product.wise') }}">{{ __('messages.product') }} {{ __('messages.wise') }}</a></li>
                            @endif
                            @if (config('sidebar.sales_report_product_group_wise') == 1)
                                <li><a class="sub-side-menu__item {{ $queryString == 'product-group-search' ? 'active' : '' }}" href="{{ route('user.report.sales.sales') }}?product-group-search">{{ __('messages.product') }} {{ __('messages.group') }} {{ __('messages.wise') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'receive-report'])
                @if (config('sidebar.deposit_report') == 1)
                    <li class="slide {{ Request::is('user/report/deposit*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/report.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.deposit') }} {{ __('messages.report') }}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">

                            @if (config('sidebar.deposit_report_category_wise') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/deposit/category/wise') ? 'active' : '' }}" href="{{ route('user.report.deposit.category.wise') }}">{{ __('messages.category') }} {{ __('messages.wise') }}</a></li>
                            @endif
                            @if (config('sidebar.deposit_report_customer_wise') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/deposit/customer/wise') ? 'active' : '' }}" href="{{ route('user.report.deposit.customer.wise') }}">{{ __('messages.customer') }} {{ __('messages.wise') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all', 'expense-report'])
                @if (config('sidebar.expense_report') == 1)
                    <li class="slide {{ Request::is('user/report/expense*') && !$queryString == 'create-staff-payment' ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/report.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.expense') }} {{ __('messages.report') }}</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">

                            @if (config('sidebar.expense_report_category_wise') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/expense/category/wise') ? 'active' : '' }} " href="{{ route('user.report.expense.category.wise') }}">{{ __('messages.category') }} {{ __('messages.wise') }}</a></li>
                            @endif
                            @if (config('sidebar.expense_report_subcategory_wise') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/expense/subcategory/wise') ? 'active' : '' }} " href="{{ route('user.report.expense.subcategory.wise') }}">{{ __('messages.subcategory') }} {{ __('messages.wise') }}</a></li>
                            @endif
                            @if (config('sidebar.expense_report_supplier_payment') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/report/expense/supplier/payment') ? 'active' : '' }} " href="{{ route('user.report.expense.supplier.payment.report') }}">{{ __('messages.supplier') }} {{ __('messages.purchase') }} {{ __('messages.payment') }}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endcanany --}}

            <li class="slide {{ Request::is('user/activity/logs*') ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="javascript:;">
                    <img height="25" class="side-menu__icon" src="{{ asset('dashboard/svg/log.svg') }}" alt="">
                    <span class="side-menu__label">{{ __('messages.activity_logs') }}</span><i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="sub-side-menu__item {{ Request::is('user/activity/logs/deleted') ? 'active' : '' }} " href="{{ route('user.log.deleted') }}">{{ __('messages.deleted_logs') }}</a></li>
                </ul>
            </li>

            @canany(['access-all', 'settings', 'receive-cateogry-visibility', 'expense-cateogry-visibility'])
                @if (config('sidebar.configuration') == 1)
                    <li class="slide {{ Request::is('user/configuration*') || Request::is('user/settings*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="">
                            <img height="25" class="side-menu__icon" src="{{ asset('icon/new/setting.svg') }}" alt="">
                            <span class="side-menu__label">{{ __('messages.configuration') }}</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @if (config('sidebar.income_category') == 1)
                                @canany(['access-all', 'receive-cateogry-visibility'])
                                    <li class="sub-slide {{ Request::is('user/configuration/receive*') ? 'is-expanded' : '' }}">
                                        <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.income') }} {{ __('messages.category') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu">
                                            <li class="sub-slide2">
                                                <a class="sub-side-menu__item {{ Request::is('user/configuration/receive-category') ? 'active' : '' }}" href="{{ route('user.receive-category.index') }}">{{ __('messages.category') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/configuration/receive-subcategory*') ? 'active' : '' }}" href="{{ route('user.configuration.receive-subcategory.index') }}">{{ __('messages.subcategory') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcanany
                            @endif

                            @if (config('sidebar.expense_category') == 1)
                                @canany(['access-all', 'expense-cateogry-visibility'])
                                    <li class="sub-slide {{ Request::is('user/configuration/expense*') ? 'is-expanded' : '' }}">
                                        <a class="slide-item" data-bs-toggle="sub-slide" href="javascript:;"><span class="sub-side-menu__label">{{ __('messages.expense') }} {{ __('messages.category') }}</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu">
                                            <li class="sub-slide2">
                                                <a class="sub-side-menu__item {{ Request::is('user/configuration/expense-category') ? 'active' : '' }}" href="{{ route('user.configuration.expense-category.index') }}">{{ __('messages.category') }}</a>
                                                <a class="sub-side-menu__item {{ Request::is('user/configuration/expense-subcategory') ? 'active' : '' }}" href="{{ route('user.configuration.expense-subcategory.index') }}">{{ __('messages.subcategory') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcanany
                            @endif

                            @if (config('sidebar.shortcut_menu') == 1)
                                @canany(['access-all', 'shortcut-menu-visibility'])
                                    <li><a class="sub-side-menu__item {{ Request::is('user/configuration/shortcut-menu*') ? 'active' : '' }}" href="{{ route('user.configuration.shortcut-menu.index') }}">{{ __('messages.shortcut_menu') }}</a></li>
                                @endcanany
                            @endif
                            @if (config('sidebar.payment_method') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/configuration/payment-method*') ? 'active' : '' }}" href="{{ route('user.configuration.payment-method.index') }}">{{ __('messages.payment') }} {{ __('messages.method') }}</a></li>
                            @endif
                            @if (config('sidebar.company_information') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/configuration/company-information*') ? 'active' : '' }}" href="{{ route('user.configuration.company-information.index') }}">{{ __('messages.company_information') }}</a></li>
                            @endif
                            @if (config('sidebar.bank') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/configuration/bank*') ? 'active' : '' }}" href="{{ route('user.configuration.bank.index') }}">{{ __('messages.bank') }}</a></li>
                            @endif
                            @if (config('sidebar.settings') == 1)
                                <li><a class="sub-side-menu__item" href="{{ route('user.settings.index') }}">{{ __('messages.settings') }}</a></li>
                            @endif
                            @if (config('dashboard.backup') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/settings/backup-log') ? 'active' : '' }}" href="{{ route('user.settings.backup.log') }}">{{ __('messages.backup_logs') }}</a></li>
                            @endif
                            @if (config('dashboard.server_info') == 1)
                                <li><a class="sub-side-menu__item {{ Request::is('user/settings/server/info') ? 'active' : '' }}" href="{{ route('user.settings.server.info.index') }}">{{ __('messages.server_info') }}</a></li>
                            @endif
                            <li><a class="sub-side-menu__item {{ Request::is('user/slider') ? 'active' : '' }}" href="{{ route('user.slider.index') }}">{{ __('messages.slider') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Request::is('user/banner') ? 'active' : '' }}" href="{{ route('user.banner.index') }}">{{ __('messages.banner') }}</a></li>
                            <li><a class="sub-side-menu__item {{ Request::is('user/brand') ? 'active' : '' }}" href="{{ route('user.brand.index') }}">{{ __('messages.brand') }}</a></li>
                        </ul>
                    </li>
                @endif
            @endcanany

            @canany(['access-all'])
                <li class="slide">
                    <a class="side-menu__item goto-support-btn" href="javascript:;">
                        <img height="25" class="side-menu__icon" src="{{ asset('icon/new/support.svg') }}" alt="">
                        <span class="side-menu__label">{{ __('messages.softhost_it_service') }}</span>
                    </a>
                </li>
            @endcanany

            @canany(['access-all'])
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img height="25" class="side-menu__icon" src="{{ asset('icon/new/logout.svg') }}" alt="">
                        <span class="side-menu__label">{{ __('messages.signout') }}</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endcanany


            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </aside>
</div>
