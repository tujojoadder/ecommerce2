@if (config('settings_custom_header') == 1)
    <img class="mb-0" src="{{ config('company.invoice_header') }}" alt="" width="100%">
    <p class="h3 text-center text-dark mt-2" style="font-family: 'Courier New', Courier, monospace; font-weight: bold;">{{ $pageTitle }}</p>
@else
    <div class="row px-0 py-3" style="padding-bottom: 2px !important;">
        <div class="col-12">
            <h4 style="font-weight: 600;" class="text-center">{{ config('company.invoice-greetings') }}</h4>
        </div>
        <div class="col-2 d-flex justify-content-center">
            {{-- <img class="w-50" src="{{ config('company.logo') }}" alt=""> --}}
        </div>
        <div class="col-8">
            <h1 style="font-size: 35px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">{{ config('company.name') }}</h1>
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
            <h4 style="font-size: 18px; text-align: center; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">{{ __('messages.invoice_no') }} : {{ $invoice->id }}</h4>
        </div>
        <p class="h3 text-center text-danger" style="font-family: Arial, Helvetica, sans-serif; font-weight: bold;">{{ $pageTitle }}</p>
        <div class="col-12 row justify-content-between mx-auto">
            <div class="col-8 ps-0">
                <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                    <div class="d-flex">
                        <b>{{ __('messages.name') }} : <span style="font-weight: normal !important;">{{ $invoice->client->client_name ?? '' }}</span> </b>
                    </div>
                </h5>
                <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                    <div class="d-flex">
                        <b>{{ __('messages.address') }} : <span style="font-weight: normal !important;">{{ $invoice->client->address ?? '' }}</span> </b>
                    </div>
                </h5>
                <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                    <div class="d-flex">
                        <b>{{ __('messages.company_name') }} : <span style="font-weight: normal !important;">{{ $invoice->client->company_name ?? '' }}</span> </b>
                    </div>
                </h5>
            </div>
            <div class="col-4 pe-0">
                <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                    <div class="d-flex justify-content-end">
                        <b>{{ __('messages.date') }} : <span style="font-weight: normal !important;">{{ bnDateFormat($invoice->issued_date) }}</span> </b>
                    </div>
                </h5>
                <h5 style="margin-bottom: 0px !important; font-family: Arial, Helvetica, sans-serif; color: black !important;">
                    <div class="d-flex justify-content-end">
                        <b>{{ __('messages.contact_no') }} : <span style="font-weight: normal !important;">{{ $invoice->client->phone ?? '' }} {{ $invoice->client->phone_optional ?? '' }}</span> </b>
                    </div>
                </h5>
            </div>
        </div>
    </div>
@endif
