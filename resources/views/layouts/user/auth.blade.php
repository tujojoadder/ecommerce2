<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Online Accounting Billing Inventory Management System - Purchase, Sales, Stock">
    <meta name="description" content="Manage your business efficiently with our Online Accounting, Billing, and Inventory Management System. Track purchases, sales, and stock effortlessly. Streamline your operations and stay organized.">
    <meta name="Keywords" content="bhisab,b-hisab,b_hisab,bhishab,vhisab,bhisab,bhisab,accounting,accounting-software,accounting_software,billing,inventory,inventory-software,billing-software" />

    <!-- Title -->
    <title>{{ config('company.name') }}</title>

    <!--- Favicon --->
    <link rel="icon" href="{{ config('company.logo') ?? asset('dashboard/img/brand/favicon.png') }}" type="image/x-icon" />

    <!-- Bootstrap css -->
    <link href="{{ asset('dashboard/plugin/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style" />

    <!--- Icons css --->
    <link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet">

    <!--- Style css --->
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/plugins.css') }}" rel="stylesheet">

    <!--- Animations css --->
    <link href="{{ asset('dashboard/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/custom-animated.css') }}" rel="stylesheet">

</head>

<body class="main-body bg-light  login-img">

    <!-- Loader -->
    @include('layouts.user.preloader')
    <!-- /Loader -->

    <!-- page -->
    <div class="page">
        <div class="my-auto page page-h">
            <div class="main-signin-wrapper">
                <div class="row mx-auto justify-content-center">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- page closed -->
    <!-- /main-signin-wrapper -->

    <!--- JQuery min js --->
    <script src="{{ asset('dashboard/plugin/jquery/jquery.min.js') }}"></script>

    <!--- Bootstrap Bundle js --->
    <script src="{{ asset('dashboard/plugin/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--- Ionicons js --->
    <script src="{{ asset('dashboard/plugin/ionicons/ionicons.js') }}"></script>

    <!--- Moment js --->
    <script src="{{ asset('dashboard/plugin/moment/moment.js') }}"></script>

    <!--- Eva-icons js --->
    <script src="{{ asset('dashboard/js/eva-icons.min.js') }}"></script>

    <!--themecolor js-->
    <script src="{{ asset('dashboard/js/themecolor.js') }}"></script>

    <!--- Custom js --->
    <script src="{{ asset('dashboard/js/custom.js') }}"></script>
    @stack('scripts')
</body>

</html>
