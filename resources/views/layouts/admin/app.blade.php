<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ config('company.name') }} | {{ $pageTitle ?? 'Dashboard' }}</title>
    <!--- Favicon --->
    <link rel="icon" href="{{ asset('dashboard/img/brand/favicon.png') }}" type="image/x-icon" />
    <!-- Bootstrap css -->
    <link id="style" href="{{ asset('dashboard/plugin/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />
    <!--- Style css --->
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/plugins.css') }}" rel="stylesheet">
    <!--- Icons css --->
    <link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet">
    <!--- Animations css --->
    <link href="{{ asset('dashboard/css/animate.css') }}" rel="stylesheet">
    <!--- Select2.min css --->
    <link rel="stylesheet" href="{{ asset('dashboard/scss/plugins/select2/css/_select2.min.scss') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

</head>

<body class="main-body app sidebar-mini ltr">
    @include('sweetalert::alert')
    <!-- Loader -->
    @include('layouts.admin.preloader')
    <!-- /Loader -->

    <!-- page -->
    <div class="page custom-index">

        <!-- main-header -->
        @include('layouts.admin.navbar')
        <!-- /main-header -->

        <!-- main-sidebar -->
        @include('layouts.admin.sidebar-left')
        <!-- main-sidebar -->

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid pt-5 mt-3">

                <!-- breadcrumb -->
                @include('layouts.admin.breadcrumb')
                <!-- /breadcrumb -->

                <!-- main-content-body -->
                @yield('content')
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-content -->

        <!--Sidebar-right-->
        @include('layouts.admin.sidebar-right')
        <!--/Sidebar-right-->

        <!-- Footer opened -->
        @include('layouts.admin.footer')
        <!-- Footer closed -->
    </div>
    <!-- page closed -->

    <!--- Back-to-top --->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
    <!--- JQuery min js --->
    <script src="{{ asset('dashboard/plugin/jquery/jquery.min.js') }}"></script>
    <!--- Datepicker js --->
    <script src="{{ asset('dashboard/plugin/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script>
        $('.fc-datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });
    </script>
    <script src="{{ asset('dashboard/plugin/jquery-simple-datetimepicker/jquery.simple-dtpicker.js ') }}"></script>
    <script src="{{ asset('dashboard/plugin/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/select2/js/select2.full.min.js') }}"></script>

    <!-- Datatable js -->
    <script src="{{ asset('dashboard/plugin/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/datatable/js/buttons.print.min.js') }}"></script>

    @stack('datatable-js')

    <script src="{{ asset('dashboard/js/datatable/3.10.1-jszip.min.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/js/datatable/0.1.53-pdfmake.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('dashboard/js/datatable/0.1.53-vfs_fonts.js') }}"></script> --}}
    <script src="{{ asset('dashboard/js/datatable/2.4.2-buttons.html5.min.js') }}"></script>

    <script src="{{ asset('dashboard/plugin/moment/moment.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/summernote-editor/summernote1.js') }}"></script>
    <script src="{{ asset('dashboard/js/summernote.js') }}"></script>
    <script>
        jQuery(function(e) {
            'use strict';
            $(document).ready(function() {
                $('#summernote').summernote();
            });
        });
    </script>
    <script src="{{ asset('dashboard/plugin/side-menu/sidemenu.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/morris.js/morris.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/script.js') }}"></script>
    <script src="{{ asset('dashboard/js/index.js') }}"></script>
    <script src="{{ asset('dashboard/js/themecolor.js') }}"></script>
    <script src="{{ asset('dashboard/js/custom.js') }}"></script>

    <script src="{{ asset('dashboard/js/tooltip.js') }}"></script>
    <script>
        // ___________TOOLTIP
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
    </script>
    {!! Toastr::message() !!}
    <script>
        function comingSoon() {
            Swal.fire({
                icon: 'info',
                title: 'Working on it!',
                text: 'Please be patient.',
            });
        }
    </script>

    {{-- datatable examples --}}
    <script>
        $(function(e) {
            $('#button').click(function() {
                table.row('.selected').remove().draw(false);
            });

            $('.modal').modal({
                dropdownParent: function() {
                    return $(this).closest('.modal');
                }
            });
        });

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Choose one',
                searchInputPlaceholder: 'Search'
            });
            $('.select2-no-search').select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose one'
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $(document).on('select2:open', () => {
                console.log('Select2 opened');
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    console.log('Search field found');
                    searchField.focus();
                } else {
                    console.log('Search field not found');
                }
            });

        });
    </script>
    {{-- datatable examples --}}

    @stack('scripts')

    {{-- modals parent --}}
    <script>
        $(document).ready(function() {
            // for client add modal
            $("#clientAddModalBtn").click(function() {
                $("#clientAddModal").modal("show");
            });
        });

        // stop redirect when scanning
        $(document).ready(function() {
            $(document).on('keydown', function(event) {
                if (event.ctrlKey && event.key === 'j') {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
</body>

</html>
