<style>
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
        background: linear-gradient(45deg, var(--layout-gradient-left, #f54266), var(--layout-gradient-right, #3858f9)) !important;
    }

    .app-sidebar,
    .main-sidebar-header {
        background: linear-gradient(90deg, var(--sidebar-bg-color-left, #f54266), var(--sidebar-bg-color-right, #3858f9)) !important;
        color: var(--sidebar-text-color) !important;
    }

    .side-menu__label,
    .sub-side-menu__label,
    .sub-side-menu__item {
        color: var(--sidebar-text-color, black) !important;
    }

    .is-expanded .side-menu__item {
        background: var(--sidebar-menu-hover-color, #f54266) !important;
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

    .card {
        border-bottom-color: var(--card-border-color, skyblue) !important;
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
        background: var(--primary-btn-color) !important;
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
</style>
<div class="col-md-12">
    <p class="card-title mb-0 mt-4">Layout Color</p>
</div>
<div class="col-md-12">
    <label class="mb-0">{{ __('messages.layout_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-50">
            <input name="layout_gradient_left" data-value-id="value-layout-gradient-left" type="color" class="p-0 color-input" id="layout-gradient-left" value="{{ siteColor()->layout_gradient_left }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-left"></span>
        </div>
        <div class="container-color overflow-hidden w-50">
            <input name="layout_gradient_right" data-value-id="value-layout-gradient-right" type="color" class="p-0 color-input" id="layout-gradient-right" value="{{ siteColor()->layout_gradient_right }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-right"></span>
        </div>
    </div>
</div>
<div class="col-md-12">
    <p class="card-title mb-0 mt-4">Sidebar Color</p>
</div>
<div class="col-md-6">
    <label class="mb-0">{{ __('messages.sidebar_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-50">
            <input name="sidebar_bg_color_left" data-value-id="value-sidebar-bg-color-left" type="color" class="p-0 color-input" id="sidebar-bg-color-left" value="{{ siteColor()->sidebar_bg_color_left }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-sidebar-bg-color-left"></span>
        </div>
        <div class="container-color overflow-hidden w-50">
            <input name="sidebar_bg_color_right" data-value-id="value-sidebar-bg-color-right" type="color" class="p-0 color-input" id="sidebar-bg-color-right" value="{{ siteColor()->sidebar_bg_color_right }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-sidebar-bg-color-right"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.sidebar_menu_hover_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="sidebar_menu_hover_color" data-value-id="value-sidebar-menu-hover-color" type="color" class="p-0 color-input" id="sidebar-menu-hover-color" value="{{ siteColor()->sidebar_menu_hover_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-sidebar-menu-hover-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.sidebar_text_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="sidebar_text_color" data-value-id="value-sidebar-text-color" type="color" class="p-0 color-input" id="sidebar-text-color" value="{{ siteColor()->sidebar_text_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-sidebar-text-color"></span>
        </div>
    </div>
</div>
<div class="col-md-12">
    <p class="card-title mb-0 mt-4">Card Color</p>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.card_border_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="card_border_color" data-value-id="value-card-border-color" type="color" class="p-0 color-input" id="card-border-color" value="{{ siteColor()->card_border_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-card-border-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.card_header_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="card_header_color" data-value-id="value-card-header-color" type="color" class="p-0 color-input" id="card-header-color" value="{{ siteColor()->card_header_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-card-header-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.card_body_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="card_body_color" data-value-id="value-card-body-color" type="color" class="p-0 color-input" id="card-body-color" value="{{ siteColor()->card_body_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-card-body-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.card_text_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="card_text_color" data-value-id="value-card-text-color" type="color" class="p-0 color-input" id="card-text-color" value="{{ siteColor()->card_text_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-card-text-color"></span>
        </div>
    </div>
</div>
<div class="col-md-12">
    <p class="card-title mb-0 mt-4">Input Color</p>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.input_bg_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="input_bg_color" data-value-id="value-input-bg-color" type="color" class="p-0 color-input" id="input-bg-color" value="{{ siteColor()->input_bg_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-input-bg-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.label_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="label_color" data-value-id="value-label-color" type="color" class="p-0 color-input" id="label-color" value="{{ siteColor()->label_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-label-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.input_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="input_color" data-value-id="value-input-color" type="color" class="p-0 color-input" id="input-color" value="{{ siteColor()->input_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-input-color"></span>
        </div>
    </div>
</div>
<div class="col-md-12">
    <p class="card-title mb-0 mt-4">Table Color</p>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.table_header_bg_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="table_header_bg_color" data-value-id="value-table-header-bg-color" type="color" class="p-0 color-input" id="table-header-bg-color" value="{{ siteColor()->table_header_bg_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-table-header-bg-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.table_header_text_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="table_header_text_color" data-value-id="value-table-header-text-color" type="color" class="p-0 color-input" id="table-header-text-color" value="{{ siteColor()->table_header_text_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-table-header-text-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.table_text_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="table_text_color" data-value-id="value-table-text-color" type="color" class="p-0 color-input" id="table-text-color" value="{{ siteColor()->table_text_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-table-text-color"></span>
        </div>
    </div>
</div>
<div class="col-md-3">
    <label class="mb-0">{{ __('messages.table_border_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="table_border_color" data-value-id="value-table-border-color" type="color" class="p-0 color-input" id="table-border-color" value="{{ siteColor()->table_border_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-table-border-color"></span>
        </div>
    </div>
</div>
<div class="col-md-12">
    <p class="card-title mb-0 mt-4">Button Color</p>
</div>
<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.success_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="success_btn_color" data-value-id="value-success-btn-color" type="color" class="p-0 color-input" id="success-btn-color" value="{{ siteColor()->success_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-success-btn-color"></span>
        </div>
    </div>
</div>

<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.danger_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="danger_btn_color" data-value-id="value-danger-btn-color" type="color" class="p-0 color-input" id="danger-btn-color" value="{{ siteColor()->danger_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-danger-btn-color"></span>
        </div>
    </div>
</div>

<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.info_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="info_btn_color" data-value-id="value-info-btn-color" type="color" class="p-0 color-input" id="info-btn-color" value="{{ siteColor()->info_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-info-btn-color"></span>
        </div>
    </div>
</div>

<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.warning_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="warning_btn_color" data-value-id="value-warning-btn-color" type="color" class="p-0 color-input" id="warning-btn-color" value="{{ siteColor()->warning_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-warning-btn-color"></span>
        </div>
    </div>
</div>

<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.primary_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="primary_btn_color" data-value-id="value-primary-btn-color" type="color" class="p-0 color-input" id="primary-btn-color" value="{{ siteColor()->primary_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-primary-btn-color"></span>
        </div>
    </div>
</div>

<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.secondary_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="secondary_btn_color" data-value-id="value-secondary-btn-color" type="color" class="p-0 color-input" id="secondary-btn-color" value="{{ siteColor()->secondary_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-secondary-btn-color"></span>
        </div>
    </div>
</div>

<div class="col-md-3 mt-2">
    <label class="mb-0">{{ __('messages.dark_btn_color') }}</label>
    <div class="input-group">
        <div class="container-color overflow-hidden w-100">
            <input name="dark_btn_color" data-value-id="value-dark-btn-color" type="color" class="p-0 color-input" id="dark-btn-color" value="{{ siteColor()->dark_btn_color }}" oninput="updateGradientColor()" />
            <span style="margin-left: 15px; font-size: 18px !important;" id="value-dark-btn-color"></span>
        </div>
    </div>
</div>
<div class="col-md-12 d-flex justify-content-center mt-4 mb-2">
    <a href="javascript:;" id="updateColors" onclick="updateColors()" class="btn btn-success w-25 me-2" style="color: white !important;">{{ __('messages.update') }}</a>
    <a href="{{ route('user.settings.reset.colors') }}" class="btn btn-danger w-25" style="color: white !important;">{{ __('messages.reset_color') }}</a>
</div>

<script>
    function updateGradientColor() {
        var leftColor = document.getElementById("layout-gradient-left").value;
        document.documentElement.style.setProperty("--layout-gradient-left", leftColor);
        document.getElementById("value-left").innerHTML = leftColor;
        document.getElementById("value-left").style.color = leftColor;

        var rightColor = document.getElementById("layout-gradient-right").value;
        document.documentElement.style.setProperty("--layout-gradient-right", rightColor);
        document.getElementById("value-right").innerHTML = rightColor;
        document.getElementById("value-right").style.color = rightColor;

        var sidebarBgColorRight = document.getElementById("sidebar-bg-color-right").value;
        document.documentElement.style.setProperty("--sidebar-bg-color-right", sidebarBgColorRight);
        document.getElementById("value-sidebar-bg-color-right").innerHTML = sidebarBgColorRight;
        document.getElementById("value-sidebar-bg-color-right").style.color = sidebarBgColorRight;

        var sidebarBgColorLeft = document.getElementById("sidebar-bg-color-left").value;
        document.documentElement.style.setProperty("--sidebar-bg-color-left", sidebarBgColorLeft);
        document.getElementById("value-sidebar-bg-color-left").innerHTML = sidebarBgColorLeft;
        document.getElementById("value-sidebar-bg-color-left").style.color = sidebarBgColorLeft;

        var sidebarMenuHoverColor = document.getElementById("sidebar-menu-hover-color").value;
        document.documentElement.style.setProperty("--sidebar-menu-hover-color", sidebarMenuHoverColor);
        document.getElementById("value-sidebar-menu-hover-color").innerHTML = sidebarMenuHoverColor;
        document.getElementById("value-sidebar-menu-hover-color").style.color = sidebarMenuHoverColor;

        var sidebarTextColor = document.getElementById("sidebar-text-color").value;
        document.documentElement.style.setProperty("--sidebar-text-color", sidebarTextColor);
        document.getElementById("value-sidebar-text-color").innerHTML = sidebarTextColor;
        document.getElementById("value-sidebar-text-color").style.color = sidebarTextColor;

        var cardBorderColor = document.getElementById("card-border-color").value;
        document.documentElement.style.setProperty("--card-border-color", cardBorderColor);
        document.getElementById("value-card-border-color").innerHTML = cardBorderColor;
        document.getElementById("value-card-border-color").style.color = cardBorderColor;

        var cardHeaderColor = document.getElementById("card-header-color").value;
        document.documentElement.style.setProperty("--card-header-color", cardHeaderColor);
        document.getElementById("value-card-header-color").innerHTML = cardHeaderColor;
        document.getElementById("value-card-header-color").style.color = cardHeaderColor;

        var cardBodyColor = document.getElementById("card-body-color").value;
        document.documentElement.style.setProperty("--card-body-color", cardBodyColor);
        document.getElementById("value-card-body-color").innerHTML = cardBodyColor;
        document.getElementById("value-card-body-color").style.color = cardBodyColor;

        var cardTextColor = document.getElementById("card-text-color").value;
        document.documentElement.style.setProperty("--card-text-color", cardTextColor);
        document.getElementById("value-card-text-color").innerHTML = cardTextColor;
        document.getElementById("value-card-text-color").style.color = cardTextColor;

        var labelColor = document.getElementById("label-color").value;
        document.documentElement.style.setProperty("--label-color", labelColor);
        document.getElementById("value-label-color").innerHTML = labelColor;
        document.getElementById("value-label-color").style.color = labelColor;

        var inputBgColor = document.getElementById("input-bg-color").value;
        document.documentElement.style.setProperty("--input-bg-color", inputBgColor);
        document.getElementById("value-input-bg-color").innerHTML = inputBgColor;
        document.getElementById("value-input-bg-color").style.color = inputBgColor;

        var inputColor = document.getElementById("input-color").value;
        document.documentElement.style.setProperty("--input-color", inputColor);
        document.getElementById("value-input-color").innerHTML = inputColor;
        document.getElementById("value-input-color").style.color = inputColor;

        var tableHeaderBgColor = document.getElementById("table-header-bg-color").value;
        document.documentElement.style.setProperty("--table-header-bg-color", tableHeaderBgColor);
        document.getElementById("value-table-header-bg-color").innerHTML = tableHeaderBgColor;
        document.getElementById("value-table-header-bg-color").style.color = tableHeaderBgColor;

        var tableHeaderTextColor = document.getElementById("table-header-text-color").value;
        document.documentElement.style.setProperty("--table-header-text-color", tableHeaderTextColor);
        document.getElementById("value-table-header-text-color").innerHTML = tableHeaderTextColor;
        document.getElementById("value-table-header-text-color").style.color = tableHeaderTextColor;

        var tableTextColor = document.getElementById("table-text-color").value;
        document.documentElement.style.setProperty("--table-text-color", tableTextColor);
        document.getElementById("value-table-text-color").innerHTML = tableTextColor;
        document.getElementById("value-table-text-color").style.color = tableTextColor;

        var tableBorderColor = document.getElementById("table-border-color").value;
        document.documentElement.style.setProperty("--table-border-color", tableBorderColor);
        document.getElementById("value-table-border-color").innerHTML = tableBorderColor;
        document.getElementById("value-table-border-color").style.color = tableBorderColor;

        var successBtnColor = document.getElementById("success-btn-color").value;
        document.documentElement.style.setProperty("--success-btn-color", successBtnColor);
        document.getElementById("value-success-btn-color").innerHTML = successBtnColor;
        document.getElementById("value-success-btn-color").style.color = successBtnColor;

        var dangerBtnColor = document.getElementById("danger-btn-color").value;
        document.documentElement.style.setProperty("--danger-btn-color", dangerBtnColor);
        document.getElementById("value-danger-btn-color").innerHTML = dangerBtnColor;
        document.getElementById("value-danger-btn-color").style.color = dangerBtnColor;

        var infoBtnColor = document.getElementById("info-btn-color").value;
        document.documentElement.style.setProperty("--info-btn-color", infoBtnColor);
        document.getElementById("value-info-btn-color").innerHTML = infoBtnColor;
        document.getElementById("value-info-btn-color").style.color = infoBtnColor;

        var warningBtnColor = document.getElementById("warning-btn-color").value;
        document.documentElement.style.setProperty("--warning-btn-color", warningBtnColor);
        document.getElementById("value-warning-btn-color").innerHTML = warningBtnColor;
        document.getElementById("value-warning-btn-color").style.color = warningBtnColor;

        var primaryBtnColor = document.getElementById("primary-btn-color").value;
        document.documentElement.style.setProperty("--primary-btn-color", primaryBtnColor);
        document.getElementById("value-primary-btn-color").innerHTML = primaryBtnColor;
        document.getElementById("value-primary-btn-color").style.color = primaryBtnColor;

        var secondaryBtnColor = document.getElementById("secondary-btn-color").value;
        document.documentElement.style.setProperty("--secondary-btn-color", secondaryBtnColor);
        document.getElementById("value-secondary-btn-color").innerHTML = secondaryBtnColor;
        document.getElementById("value-secondary-btn-color").style.color = secondaryBtnColor;

        var darkBtnColor = document.getElementById("dark-btn-color").value;
        document.documentElement.style.setProperty("--dark-btn-color", darkBtnColor);
        document.getElementById("value-dark-btn-color").innerHTML = darkBtnColor;
        document.getElementById("value-dark-btn-color").style.color = darkBtnColor;
    }

    // Initial update on page load
    updateGradientColor();
</script>
@push('scripts')
    <script>
        function updateColors() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
                }
            });

            var layout_gradient_left = $("#layout-gradient-left").val();
            var layout_gradient_right = $("#layout-gradient-right").val();
            var sidebar_bg_color_left = $("#sidebar-bg-color-left").val();
            var sidebar_bg_color_right = $("#sidebar-bg-color-right").val();
            var sidebar_menu_hover_color = $("#sidebar-menu-hover-color").val();
            var sidebar_text_color = $("#sidebar-text-color").val();
            var card_border_color = $("#card-border-color").val();
            var card_header_color = $("#card-header-color").val();
            var card_body_color = $("#card-body-color").val();
            var card_text_color = $("#card-text-color").val();
            var label_color = $("#label-color").val();
            var input_bg_color = $("#input-bg-color").val();
            var input_color = $("#input-color").val();
            var table_header_bg_color = $("#table-header-bg-color").val();
            var table_header_text_color = $("#table-header-text-color").val();
            var table_text_color = $("#table-text-color").val();
            var table_border_color = $("#table-border-color").val();
            var success_btn_color = $("#success-btn-color").val();
            var danger_btn_color = $("#danger-btn-color").val();
            var info_btn_color = $("#info-btn-color").val();
            var warning_btn_color = $("#warning-btn-color").val();
            var primary_btn_color = $("#primary-btn-color").val();
            var secondary_btn_color = $("#secondary-btn-color").val();
            var dark_btn_color = $("#dark-btn-color").val();
            $.ajax({
                type: 'get',
                url: '{{ route('user.settings.update.colors') }}', // Replace with your actual endpoint
                data: {
                    layout_gradient_left: layout_gradient_left,
                    layout_gradient_right: layout_gradient_right,
                    sidebar_bg_color_left: sidebar_bg_color_left,
                    sidebar_bg_color_right: sidebar_bg_color_right,
                    sidebar_menu_hover_color: sidebar_menu_hover_color,
                    sidebar_text_color: sidebar_text_color,
                    card_border_color: card_border_color,
                    card_header_color: card_header_color,
                    card_body_color: card_body_color,
                    card_text_color: card_text_color,
                    label_color: label_color,
                    input_bg_color: input_bg_color,
                    input_color: input_color,
                    table_header_bg_color: table_header_bg_color,
                    table_header_text_color: table_header_text_color,
                    table_text_color: table_text_color,
                    table_border_color: table_border_color,
                    success_btn_color: success_btn_color,
                    danger_btn_color: danger_btn_color,
                    info_btn_color: info_btn_color,
                    warning_btn_color: warning_btn_color,
                    primary_btn_color: primary_btn_color,
                    secondary_btn_color: secondary_btn_color,
                    dark_btn_color: dark_btn_color,
                },
                success: function(response) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: true,
                        timer: 30000
                    });
                },
                error: function(error) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: error.message,
                        showConfirmButton: true,
                        timer: 30000
                    });
                }
            });
        }
    </script>
@endpush
