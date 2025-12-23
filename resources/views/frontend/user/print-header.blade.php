@if (config('settings_custom_header') == 1)
    <div class="header my-0">
        <img class="mb-4" src="{{ config('company.invoice_header') }}" alt="" width="100%">
        <p class="h3 text-center text-dark mt-1" style="font-family: 'Courier New', Courier, monospace; font-weight: bold;">{{ $pageTitle }}</p>
        <div class="d-none col-12 px-0 mb-3" id="client_Infobox">
            <div class="col-12 row justify-content-between">
                <div class="col-6">
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex">
                            <b class="me-1">{{ __('messages.name') }} : </b> <span style="font-weight: normal !important;" class="client_name"></span>
                        </div>
                    </h6>
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex">
                            <b class="me-1">{{ __('messages.address') }} : </b> <span style="font-weight: normal !important;" class="address"></span>
                        </div>
                    </h6>
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex">
                            <b class="me-1">{{ __('messages.contact_no') }} : </b> <span style="font-weight: normal !important;" class="contact_no"></span>
                        </div>
                    </h6>
                </div>
                <div class="col-6 text-start">
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex justify-content-end">
                            <b class="me-1">{{ __('messages.date') }} : </b> <span style="font-weight: normal !important;" class="date">{{ date('d M Y') }}</span>
                        </div>
                    </h6>
                    <div class="text-end" id="clientLegderDate"></div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="header row px-0 py-3 justify-content-center" style="padding-bottom: 2px !important;">
        <div class="col-12">
            <h4 style="font-weight: 600;" class="text-center">{{ config('company.invoice-greetings') }}</h4>
        </div>
        <div class="col-2 d-flex justify-content-center">
            {{-- <img class="w-50" src="{{ config('company.logo') }}" alt=""> --}}
        </div>
        <div class="col-8">
            <h1 style="margin: 0px !important; font-size: 35px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">{{ config('company.name') }}</h1>
        </div>
        <div class="col-2 d-flex justify-content-center">
            {{-- <img class="w-50" src="{{ config('company.logo') }}" alt=""> --}}
        </div>
        <div class="col-12">
            <h4 style="margin-bottom: 0px !important; font-size: 18px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal !important;">{{ config('company.description') }}</h4>
            <h4 style="margin-bottom: 0px !important; font-size: 18px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal !important;">{{ config('company.address_optional') }}</h4>
            <h4 style="margin-bottom: 0px !important; font-size: 18px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal !important;">{{ __('messages.contact_no') }} - {{ config('company.phone') }}</h4>
            <h4 style="margin-bottom: 0px !important; font-size: 18px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal !important;">{{ __('messages.email') }} - {{ config('company.email') }}</h4>
            <h4 style="margin-bottom: 0px !important; font-size: 18px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal !important;">{{ __('messages.website') }} - {{ config('company.website') }}</h4>
            <h4 style="margin: 10px 0px !important; font-size: 24px !important; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: normal !important;">{{ $pageTitle ?? '' }}</h4>
        </div>
        <div class="d-none col-12 mb-3" id="client_Infobox">
            <div class="col-12 row justify-content-between">
                <div class="col-6">
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex">
                            <b class="me-1">{{ __('messages.name') }} : </b> <span style="font-weight: normal !important;" class="client_name"></span>
                        </div>
                    </h6>
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex">
                            <b class="me-1">{{ __('messages.address') }} : </b> <span style="font-weight: normal !important;" class="address"></span>
                        </div>
                    </h6>
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex">
                            <b class="me-1">{{ __('messages.contact_no') }} : </b> <span style="font-weight: normal !important;" class="contact_no"></span>
                        </div>
                    </h6>
                </div>
                <div class="col-6 text-start">
                    <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                        <div class="d-flex justify-content-end">
                            <b class="me-1">{{ __('messages.date') }} : </b> <span style="font-weight: normal !important;" class="date">{{ date('d M Y') }}</span>
                        </div>
                    </h6>
                    <div class="text-end" id="clientLegderDate"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="supplier_Infobox"></div>
@endif
{{-- <div class="d-none col-12 mb-3" id="supplier_Infobox">
    <div class="col-12 row justify-content-between">
        <h6 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
            <div style="display: flex !important; justify-content: space-between !important;">
                <span style="margin-right: 10px !important;"><b class="me-1">{{ __('messages.name') }} : </b> <span style="font-weight: normal !important;" class="supplier_name"></span></span>
                <span style="margin-right: 10px !important;"><b class="me-1">{{ __('messages.company_name') }} : </b> <span style="font-weight: normal !important;" class="company_name"></span></span>
                <span style="margin-right: 10px !important;"><b class="me-1">{{ __('messages.address') }} : </b> <span style="font-weight: normal !important;" class="address"></span></span>
                <span style="margin-right: 10px !important;"><b class="me-1">{{ __('messages.contact_no') }} : </b> <span style="font-weight: normal !important;" class="contact_no"></span></span>
                <span style="margin-right: 10px !important;"><b class="me-1">{{ __('messages.date') }} : </b> <span style="font-weight: normal !important;" class="date">{{ date('d M Y') }}</span></span>
            </div>
        </h6>
        <div class="text-end" id="supplierLegderDate"></div>
    </div>
</div> --}}
