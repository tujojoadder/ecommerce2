<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Online Accounting Billing Inventory Management System - Purchase, Sales, Stock">
    <meta name="description"
        content="Manage your business efficiently with our Online Accounting, Billing, and Inventory Management System. Track purchases, sales, and stock effortlessly. Streamline your operations and stay organized.">
    <meta name="Keywords"
        content="bhisab,b-hisab,b_hisab,bhishab,vhisab,bhisab,bhisab,accounting,accounting-software,accounting_software,billing,inventory,inventory-software,billing-software" />
    @stack('head')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ config('company.name') }} | {{ $pageTitle ?? 'Dashboard' }}</title>
    <!--- Favicon --->
    <link rel="icon" href="{{ config('company.logo') ?? asset('dashboard/img/brand/favicon.png') }}"
        type="image/x-icon" />
    <!-- Bootstrap css -->
    <link id="style" href="{{ asset('dashboard/plugin/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <!--- Style css --->
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/plugins.css') }}" rel="stylesheet">
    <!--- Icons css --->
    <link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet">
    <!--- Animations css --->
    <!--- Chart bundle min js --->
    <script src="{{ asset('dashboard/js/apexcharts.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/chart.js/Chart.min.js') }}"></script>
    <!--- Internal Sampledata js --->
    <script src="{{ asset('dashboard/js/chart.flot.sampledata.js') }}"></script>
    {{-- <link href="{{ asset('dashboard/css/animate.css') }}" rel="stylesheet"> --}}
    <!--- Select2.min css --->
    <link rel="stylesheet" href="{{ asset('dashboard/scss/plugins/select2/css/_select2.min.scss') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@500&family=Open+Sans:wght@300&display=swap"
        rel="stylesheet">
    @if (session()->get('locale') == 'bn')
        <style>
            .side-menu__label,
            .sub-side-menu__label,
            .sub-side-menu__item,
            #file-export-datatable th {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
                font-weight: 300 !important;
                font-size: 16px !important;
            }

            * {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
                font-size: 15px !important;
            }

            /* sidebar */
            .slide.is-expanded a {
                font-size: 1rem !important;
            }

            .angle {
                font-size: 18px;
            }

            .slide.is-expanded a,
            .side-menu__label {
                color: black;
            }

            ul li .sub-side-menu__item {
                font-size: 1rem !important;
            }

            /* sidebar */

            #file-export-datatable td {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
                font-size: 16px !important;
            }

            #file-export-datatable td i {
                font-size: small !important;
            }
        </style>
    @else
        <style>
            .slide.is-expanded a {
                font-size: 15px !important;
            }

            .side-menu__label,
            .sub-side-menu__label,
            .sub-side-menu__item {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
                font-weight: 600 !important;
                font-size: 15px !important;
            }

            a:hover .side-menu__label,
            a:hover .sub-side-menu__label:hover,
            a:hover .sub-side-menu__item:hover {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
                font-weight: 600 !important;
                font-size: 15px !important;
            }
        </style>
    @endif
    <style>
        .angle,
        .sub-angle {
            font-size: 15px !important;
        }

        .select2-search__field:focus-visible {
            outline: 1px solid;
        }

        .toast {
            opacity: 1 !important;
            border-radius: 10px !important;
            padding-top: 20px !important;
            padding-bottom: 20px !important;
        }

        .small {
            font-size: 14px !important;
            font-weight: 600;
        }

        .main-sidebar-header {
            height: auto !important;
        }

        .ui-datepicker-calendar thead {
            background-color: white !important;
        }

        .header {
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

        table thead {
            background-color: gray !important;
        }



        /* for invoice and purchase table */
        #button-group {
            position: fixed !important;
            margin-left: 240px;
            width: calc(100% - 240px);
        }

        .btn:focus {
            box-shadow: 0px 0px 0px 3px #ffa9a9 !important;
        }

        @media (max-width: 600px) {
            #button-group {
                margin-left: 0;
                width: 100%;
                justify-content: space-between !important;
            }

            .table {
                width: max-content !important;
            }
        }

        .form-control {
            color: black !important;
        }

        .select2-selection__clear {
            position: absolute !important;
            right: 25px !important;
            font-size: 20px !important;
        }

        .select2-selection__clear:hover {
            color: red;
        }

        .dataTables_processing {
            z-index: 99999 !important;
        }

        @media print {
            * {
                color: black !important;
            }
        }

        .buttons-columnVisibility {
            border-bottom: 1px solid !important;
        }

        .buttons-columnVisibility span {
            color: #d6d6d6 !important;
        }

        .slide.is-expanded .side-menu__item .side-menu__icon,
        .side-menu__item.active .side-menu__icon,
        .side-menu__item:hover .side-menu__icon {
            filter: brightness(1) !important;
        }

        .side-menu__icon {
            filter: brightness(0) !important;
        }

        .app-sidebar .slide-menu a.active:before {
            color: #fff !important;
        }

        a,
        button {
            border-radius: 10px 10px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('dashboard/css/sorted.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/custom-animated.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('dashboard/css/custom.css') }}"> --}}
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
    @include('layouts.user.site-color')
</head>

<body class="main-body app sidebar-mini ltr {{ smallMenu() == 'small' ? 'sidenav-toggled' : '' }}"
    style="background-color: white !important;">
    @include('sweetalert::alert')
    <!-- Loader -->
    @include('layouts.user.preloader')
    <!-- /Loader -->

    <!-- page -->
    <div class="page custom-index">

        <!-- main-header -->
        @include('layouts.user.navbar')
        <!-- /main-header -->

        <!-- main-sidebar -->
        @include('layouts.user.sidebar-left')
        <!-- main-sidebar -->

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid pt-5 mt-3">
                @include('layouts.user.software-status')

                <!-- breadcrumb -->
                @include('layouts.user.breadcrumb')
                <!-- /breadcrumb -->

                <!-- main-content-body -->
                @include('layouts.table-css')
                @yield('content')
                @include('layouts.user.youtube-modal')
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-content -->

        <!-- Footer opened -->
        @include('layouts.user.footer')
        <div
            style="{{ Route::is('user.purchase.create') || Request::is('user/invoice*') ? 'display: none' : '' }} position: fixed; top: 90%; right: 0; bottom: 0; margin-right: 20px; z-index: 100;">
            <div class="btn-group dropup">
                <button data-bs-toggle="dropdown" aria-expanded="false" type="button"
                    class="btn btn-success p-2 rounded-circle"><i class="fas fa-plus"></i></button>
                <div class="dropdown-menu tx-13 shadow p-2" style="inset: auto !important;">
                    <a href="{{ route('user.configuration.shortcut-menu.index') }}"
                        class="dropdown-item rounded py-1"><i class="fas fa-plus-circle d-inline me-1"></i>
                        {{ __('messages.add_shortcut_menu') }}</a>
                    @foreach (config('shortcutManu') as $menu)
                        <a href="{{ $menu->address }}" class="dropdown-item rounded py-1">
                            @if ($menu->icon != null)
                                <i class="{{ $menu->icon }} d-inline me-1"></i>
                            @elseif ($menu->img != null)
                                <img style="width: 20px; margin-top: -2px;"
                                    src="{{ asset('storage/shortcut-manu-icon/' . $menu->img) }}" alt="">
                            @else
                                <i class="fas fa-plus-circle d-inline me-1 "></i>
                            @endif {{ $menu->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div
            style="{{ Route::is('user.purchase.create') || Request::is('user/invoice*') ? 'display: none' : '' }} position: fixed; top: 90%; right: 0; bottom: 0; margin-right: 70px; z-index: 100;">
            <div class="btn-group dropup rounded-pill support-shortcut-btn-box">
                <a href="javascript:;" class="btn btn-success p-1 border border-success rounded-pill goto-support-btn">
                    <img class="rounded-circle" style="width: 30px" src="{{ asset('support.gif') }}" alt="">
                    <span class="pe-1">GoTo Support Panel</span>
                </a>
            </div>
        </div>
        <!-- Footer closed -->
    </div>
    <!-- page closed -->
    @include('user.bulk-upload-modal')

    <!--- Back-to-top --->
    {{-- <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a> --}}
    <!--- JQuery min js --->
    <script src="{{ asset('dashboard/plugin/jquery/jquery.min.js') }}"></script>
    <!--- Datepicker js --->
    <script src="{{ asset('dashboard/plugin/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script>
        $('.fc-datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'dd/mm/yy',
            // minDate: "{{ Auth::user()->type == 1 ? 0 : 'null' }}" // disable accessing previous date
        });
        @php
            $queryString = $_SERVER['QUERY_STRING'] ?? '';
        @endphp
        $(document).ready(function() {
            $(".clear-input").on('focus', function() {
                var value = $(this).val();
                @if (Route::is('user.invoice.sales.return') || $queryString == 'sales-return')
                @else
                    if (value == 0) {
                        $(this).val('');
                    }
                @endif
            });

            // active animated label when focus on input
            $('.form-group input').focus(function() {
                $(this).siblings('.animated-label').addClass('active-label');
            });
        });
    </script>
    <script src="{{ asset('dashboard/plugin/jquery-simple-datetimepicker/jquery.simple-dtpicker.js ') }}"></script>
    <script src="{{ asset('dashboard/plugin/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugin/bootstrap/js/bootstrap.min.js') }}"></script>
    @if (
        !Request::is('user') ||
            !Request::is('user/client') ||
            !Request::is('user/product-barcode') ||
            !Request::is('user/client-group'))
        <script src="{{ asset('dashboard/plugin/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/select2/js/select2.full.min.js') }}"></script>
    @endif

    @if (
        !Request::is('user') ||
            !Request::is('user/client') ||
            !Request::is('user/product-barcode') ||
            !Request::is('user/client/create') ||
            !Request::is('user/client-group') ||
            !Request::is('user/product-barcode'))
        <!-- Datatable js -->
        <script src="{{ asset('dashboard/plugin/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/js/dataTables.bootstrap5.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/js/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/datatable/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
        @stack('datatable-js')

        <script src="{{ asset('dashboard/js/datatable/3.10.1-jszip.min.js') }}"></script>
        {{-- <script src="{{ asset('dashboard/js/datatable/0.1.53-pdfmake.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('dashboard/js/datatable/0.1.53-vfs_fonts.js') }}"></script> --}}
        <script src="{{ asset('dashboard/js/datatable/2.4.2-buttons.html5.min.js') }}"></script>
        {{-- deactive all default search --}}
        <script>
            $.extend(true, $.fn.dataTable.defaults, {
                searching: false
            });
        </script>
    @endif

    {{-- <script src="{{ asset('dashboard/plugin/moment/moment.js') }}"></script> --}}
    @if (
        !Request::is('user') ||
            !Request::is('user/client') ||
            !Request::is('user/product-barcode') ||
            !Request::is('user/product-barcode'))
        <script src="{{ asset('dashboard/plugin/summernote-editor/summernote1.js') }}"></script>
        <script src="{{ asset('dashboard/js/summernote.js') }}"></script>
        <script>
            jQuery(function(e) {
                'use strict';
                $(document).ready(function() {
                    $('#summernote').summernote();
                    $('.summernote').summernote();
                });
            });
        </script>
    @endif
    <script src="{{ asset('dashboard/plugin/side-menu/sidemenu.js') }}"></script>

    @if (Request::is('user'))
        <script src="{{ asset('dashboard/plugin/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('dashboard/plugin/morris.js/morris.min.js') }}"></script>
    @endif

    @if (
        !Request::is('user/client') ||
            !Request::is('user/product-barcode') ||
            !Request::is('user/client-group') ||
            !Request::is('user/product-barcode'))
        <script src="{{ asset('dashboard/js/script.js') }}"></script>
        <script src="{{ asset('dashboard/js/index.js') }}"></script>
        <script src="{{ asset('dashboard/js/themecolor.js') }}"></script>
        <script src="{{ asset('dashboard/js/custom.js') }}"></script>
    @endif

    <script src="{{ asset('dashboard/js/tooltip.js') }}"></script>
    <script>
        // ___________TOOLTIP
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    @if (!Request::is('user') || !Request::is('user/client') || !Request::is('user/product-barcode'))
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
        {{-- @if ($errors->any())
            @foreach ($errors as $error)
                <script>
                    toastr.error("{{ $error->message }}");
                </script>
            @endforeach
        @endif --}}
        <script>
            function comingSoon() {
                Swal.fire({
                    icon: 'info',
                    title: 'Access denied!',
                    text: 'This feature is not for demo.',
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
                    const searchField = document.querySelector('.select2-search__field');
                });

                $('.modal').on('select2:open', () => {
                    const searchField = document.querySelector('.select2-search__field');
                });

            });
        </script>
        {{-- datatable examples --}}

        {{-- fro youtube instruction --}}
        <script>
            $(document).ready(function() {
                $("#youtubeModalInstructionBtn").click(function() {
                    var link = $(this).data("link");
                    var iframe = $("<iframe>")
                        .attr("src", link)
                        .attr("allow",
                            "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        )
                        .attr("allowfullscreen", true)
                        .attr("height", "400")
                        .attr("width", "100%");
                    $("#video").append(iframe);
                    $("#youtube-modal").toggle();
                });

                $(".closeVedio").click(function() {
                    $("#youtube-modal").toggle();
                    $("#video").html("");
                });
                $("#youtube-modal").on('hide.bs.modal', function() {
                    $("#video").html("");
                });
            });
        </script>
        {{-- fro youtube instruction --}}

        @stack('scripts')
        <script src="{{ asset('dashboard/js/get-client-info.js') }}"></script>
        <script src="{{ asset('dashboard/js/append.js') }}"></script>
        <script>
            // for custom reset button
            $.fn.dataTable.ext.buttons.reset = {
                text: '<i class="fas fa-undo d-inline"></i> Reset',
                action: function(e, dt, node, config) {
                    dt.clear().draw();
                    dt.ajax.reload();
                }
            };

            $(document).ready(function() {
                // for client add modal
                $("#clientAddModalBtn").click(function() {
                    $("#clientAddModal").modal("show");
                });

                $(document).on('keydown', function(event) {
                    if (event.ctrlKey && event.key === 'j') {
                        event.preventDefault();
                        return false;
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ route('user.settings.check.sms.balance') }}",
                    success: function(balance) {
                        $("#sms-balance").text(balance + ' ৳');
                    }
                });

                $(".goto-support-btn").on('click', function() {
                    let token = 'n-e-w-s-u-p-p-o-r-t';
                    $.ajax({
                        url: '{{ env('API_BASE_PATH') }}/{{ API_PATH_V1 }}/client/get-client-info',
                        type: 'GET',
                        data: {
                            'token': token,
                            'ca_key': "{{ softwareStatus()->key }}",
                        },
                        success: function(data) {
                            if (data.email == null) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Your information is not in our database!',
                                    text: 'Please contact with your software provider.',
                                });
                                return;
                            }
                            window.open('{{ env('API_BASE_PATH') }}/client/login?email=' + data
                                .email + '&token=' + data.token, '_blank');
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Your information is not in our database!',
                                text: response.responseJSON.message,
                            });
                        }
                    });
                });
            });
        </script>
        {{-- modals parent --}}
    @endif
    {{-- @include('layouts.user.status-script') --}}
    <script src="{{ asset('dashboard/js/preset.js') }}"></script>
    @if (presets() != null)
        <script>
            preset('client_id', '/get-client-info', "{{ presets()->client_id }}");
            preset('supplier_id', '/get-supplier-info', "{{ presets()->supplier_id }}");
            preset('client_group_id', '/get-client-group', "{{ presets()->client_group_id }}");
            preset('supplier_group_id', '/get-supplier-group', "{{ presets()->supplier_group_id }}");
            preset('expense_category_id', '/get-expense-category', "{{ presets()->expense_category_id }}");
            preset('receive_category_id', '/get-receive-category', "{{ presets()->receive_category_id }}");
            preset('account_id', '/get-account', "{{ presets()->account_id }}");
        </script>
    @endif
</body>

</html>
