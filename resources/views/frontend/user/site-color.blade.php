<style>
    :root {
        --layout-gradient-left: {{ siteColor()->layout_gradient_left }};
        --layout-gradient-right: {{ siteColor()->layout_gradient_right }};
        --sidebar-bg-color-left: {{ siteColor()->sidebar_bg_color_left }};
        --sidebar-bg-color-right: {{ siteColor()->sidebar_bg_color_right }};
        --sidebar-menu-hover-color: {{ siteColor()->sidebar_menu_hover_color }};
        --sidebar-text-color: {{ siteColor()->sidebar_text_color }};
        --card-border-color: {{ siteColor()->card_border_color }};
        --card-header-color: {{ siteColor()->card_header_color }};
        --card-body-color: {{ siteColor()->card_body_color }};
        --card-text-color: {{ siteColor()->card_text_color }};
        --label-color: {{ siteColor()->label_color }};
        --input-bg-color: {{ siteColor()->input_bg_color }};
        --input-color: {{ siteColor()->input_color }};
        --table-header-bg-color: {{ siteColor()->table_header_bg_color }};
        --table-header-text-color: {{ siteColor()->table_header_text_color }};
        --table-text-color: {{ siteColor()->table_text_color }};
        --table-border-color: {{ siteColor()->table_border_color }};
        --success-btn-color: {{ siteColor()->success_btn_color }};
        --danger-btn-color: {{ siteColor()->danger_btn_color }};
        --info-btn-color: {{ siteColor()->info_btn_color }};
        --warning-btn-color: {{ siteColor()->warning_btn_color }};
        --primary-btn-color: {{ siteColor()->primary_btn_color }};
        --secondary-btn-color: {{ siteColor()->secondary_btn_color }};
        --dark-btn-color: {{ siteColor()->dark_btn_color }};
    }

    .main-header-profile {
        background: var(--dark-btn-color) !important;
        color: white !important;
    }

    .fa-calculator,
    .fa-language {
        color: var(--dark-btn-color) !important;
    }

    .main-header-right .dropdown-menu:after {
        border-bottom: 9px solid var(--dark-btn-color) !important;
    }

    .container-color {
        display: flex;
        align-items: center;
        font-size: 2rem;
        border: 1px solid black;
        border-radius: 5px;
        height: 30px !important;
    }

    input[type="color"] {
        border: none !important;
        width: 1em;
        height: 2em;
        outline: none !important;
        width: 100px;
        margin-left: -1px !important;
    }

    .main-content:after,
    .main-header.side-header.fixed-header {
        background: unset !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
    }

    @media (min-width: 992px) {
        .main-content {
            margin-left: 280px !important;
        }

        .app.sidenav-toggled .app-sidebar {
            left: 0;
            width: 80px !important;
            overflow: hidden;
        }

        .app.sidenav-toggled .main-sidebar-header {
            width: 80px !important;
        }

        .app.sidebar-mini.sidenav-toggled-open .app-sidebar {
            left: 0;
            width: 280px !important;
        }

        .app.sidenav-toggled .app-content {
            margin-left: 80px !important;
        }

        .app.sidebar-mini.sidenav-toggled-open .main-sidebar-header {
            width: 280px !important;
        }

        .sidebar-mini.sidenav-toggled.sidenav-toggled-open .side-menu .slide .side-menu__item {
            margin: 3px 0.5rem !important;
        }
    }

    @media (max-width: 991px) {
        .app .app-sidebar {
            left: -280px;
        }

        .app.sidebar-gone.sidenav-toggled .app-sidebar {
            left: 0 !important;
        }
    }

    .app-sidebar,
    .main-sidebar-header {
        color: var(--sidebar-text-color) !important;
    }

    #navbar-part {
        backdrop-filter: blur(20px);
        color: black !important;
    }

    .main-header {
        border-bottom: 1px solid #d1d1d1 !important;
    }

    .side-header {
        padding-left: 280px !important;
    }

    .navbar-toggler.nav-link {
        color: black !important;
    }

    @media (max-width: 767px) {
        .side-header {
            padding-left: 0px !important;
            backdrop-filter: blur(20px);
            color: black !important;
        }

        .main-header {
            background: unset !important;
        }

        .responsive-navbar.navbar .navbar-collapse {
            background: white !important;
        }
    }

    .app-sidebar,
    .main-sidebar-header {
        width: 280px !important;
    }

    .side-menu__item {
        border-radius: 15px !important;
        border: 1px solid lightgray !important;
        margin: 3px 0.5rem !important;
    }

    .side-menu__item img {
        height: 1.2rem !important;
    }


    .main-header-left {
        padding-left: 0.5rem !important;
    }

    .side-menu__label,
    .sub-side-menu__label,
    .sub-side-menu__item {
        color: var(--sidebar-text-color, black) !important;
    }

    .is-expanded .side-menu__item {
        background: var(--sidebar-menu-hover-color, #f54266) !important;
    }

    .slide-menu {
        /* background: #0ba3613b !important; */
        padding: 5px;
        border-radius: 0.5rem;
        margin: 3px 0.5rem !important;
    }

    /* .app-sidebar .slide-menu a:before {
        content: "\25CF";
        font-family: "feather" !important;
        position: absolute;
        top: 3px !important;
        left: 21px;
        font-size: 18px !important;
        color: #000;
        opacity: 0.8 !important;
    } */

    .slide.is-expanded .sub-side-menu__item:before {
        content: "\1F862" !important;
        top: 9px !important;
        font-size: 12px !important;
    }

    .sub-side-menu__item.active::before,
    .sub-side-menu__item:hover::before,
    .sub-side-menu__item:focus::before {
        color: white !important;
    }


    .bg-custom {
        backdrop-filter: contrast(80%) !important;
    }

    .sub-slide,
    .sub-slide.is-expanded {
        border-radius: 1rem !important;
    }

    .sub-slide {
        padding-bottom: 0.4rem !important;
    }

    .sub-slide.is-expanded {
        backdrop-filter: contrast(80%) !important;
    }

    .app-sidebar__user .user-info h6,
    .app-sidebar__user .user-info .text-muted {
        color: var(--sidebar-text-color) !important;
    }

    .side-menu__item.active,
    .side-menu__item:hover,
    .side-menu__item:focus,
    .side-menu .slide.active .side-menu__item,
    .side-menu .slide:hover .side-menu__item,
    .side-menu .slide:focus .side-menu__item {
        color: var(--sidebar-text-color) !important;
        background: var(--sidebar-menu-hover-color, #f54266) !important;
    }

    .sub-side-menu__item:hover {
        color: white !important;
        background: var(--sidebar-menu-hover-color, #f54266) !important;
    }

    .sub-side-menu__item.active {
        color: #ffffffe5 !important;
        background: var(--sidebar-menu-hover-color, #f54266) !important;
        filter: brightness(150%);
    }

    .card {
        border: 1px solid lightgray !important;
        /* border-bottom-color: var(--card-border-color, skyblue) !important; */
    }

    .card-header {
        background: var(--card-header-color, white) !important;
    }

    .card-body {
        background: var(--card-body-color, white) !important;
    }

    .card * {
        color: var(--card-text-color, black) !important;
    }

    .card {
        color: var(--card-text-color, opacity(50%)) !important;
    }

    label,
    .card label {
        color: var(--label-color, black) !important;
    }

    .card .active {
        color: white !important;
    }

    .card input,
    .card select,
    input,
    select,
    .form-switch-description,
    .checkbox-input {
        color: var(--input-color, black) !important;
        background: var(--input-bg-color) !important;
    }

    .table thead,
    .datatable thead,
    table thead,
    .ui-datepicker-calendar thead,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc,
    thead th {
        background: var(--table-header-bg-color) !important;
    }

    .table tbody tr td,
    .datatable tbody tr td,
    table tbody tr td,
    .table thead tr th,
    .datatable thead tr th,
    table thead tr th,
    tfoot tr td,
    tfoot tr th {
        color: var(--table-text-color) !important;
        border-color: var(--table-border-color) !important;
    }

    .bg-info,
    .bg-success,
    .bg-danger,
    .bg-primary {
        color: white !important;
    }

    .table thead tr th:last-child,
    .datatable thead tr th:last-child,
    table thead tr th:last-child {
        border: 0px !important;
    }

    .table.dataTable.no-footer {
        border-bottom: 1px solid var(--table-border-color) !important;
    }

    .table thead tr th,
    .datatable thead tr th,
    table thead tr th,
    .ui-datepicker-calendar thead tr th span {
        border-top: 0px !important;
        color: var(--table-header-text-color) !important;
    }

    tfoot tr th {
        border: 1px solid var(--table-border-color) !important;
        border-left: 0px !important;
        border-right: 0px !important;
    }

    .table tbody tr td:last-child,
    .datatable tbody tr td:last-child,
    table tbody tr td:last-child,
    tfoot tr td:last-child,
    tfoot tr th:last-child {
        border-right: 0px !important;
    }

    .ui-datepicker-calendar tbody tr td {
        padding: 0 !important;
    }

    .ui-datepicker-calendar tbody tr td a {
        border-radius: 0px !important;
        border: 0px !important;
        padding: 5px 12px !important;
    }

    .ui-datepicker-calendar tbody tr td .ui-state-highlight {
        background-color: var(--info-btn-color) !important;
    }

    .ui-datepicker-calendar tbody tr td .ui-state-active {
        background-color: #cfcfcf !important;
        color: black !important;
    }


    .ui-datepicker-calendar tbody tr td:last-child {
        border-right: 1px solid var(--table-border-color) !important;
    }

    .table,
    table,
    .datatable {
        border-color: var(--table-border-color) !important;
        border-radius: 0.5rem !important;
        overflow: hidden !important;
    }

    .btn-success {
        background: var(--success-btn-color) !important;
        color: white !important;
    }

    .btn-info {
        background: var(--info-btn-color) !important;
        color: white !important;
    }

    .btn-primary,
    .nav-link.active,
    .btn-primary span {
        background: #7987a1 !important;
        color: white !important;
    }

    .btn i {
        color: white !important;
    }

    .animated-label.active-label,
    .animated-label.active-label i {
        color: white !important;
    }

    .btn-warning {
        background: var(--warning-btn-color) !important;
        color: white !important;
    }

    .btn-dark {
        background: var(--dark-btn-color) !important;
        color: white !important;
    }

    .btn-secondary {
        background: var(--secondary-btn-color) !important;
        color: white !important;
    }

    .btn-danger {
        background: var(--danger-btn-color) !important;
        color: white !important;
    }

    .bg-dark {
        color: white !important;
    }

    .bg-secondary {
        color: white !important;
    }

    .bg-danger {
        color: white !important;
    }
</style>
