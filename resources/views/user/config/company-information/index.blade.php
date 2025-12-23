@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    <link rel="stylesheet" href="{{ asset('dashboard/css/country-select.css') }}">
    <div class="main-content-body">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-center h3 font-weight-light mb-0">{{ $pageTitle }}</p>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('user.configuration.company-information.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row" id="company-information-form">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->company_name }}" name="company_name" id="company_name" placeholder="{{ __('messages.company') }} {{ __('messages.name') }}">
                                <label for="name" class="animated-label active-label"><i class="fas fa-building"></i> {{ __('messages.company') }} {{ __('messages.name') }}</label>
                            </div>
                            <span class="text-danger small" id="company_name_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->proprietor }}" name="proprietor" placeholder="{{ __('messages.proprietor') }} " id="proprietor">
                                <label for="" class="animated-label active-label"><i class="fas fa-coins"></i> {{ __('messages.proprietor') }}</label>
                            </div>
                            <span class="text-danger small" id="proprietor_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" data-bs-toggle="tooltip-primary" value="{{ $company->company_type }}" name="company_type" title="Company type" id="company_type" placeholder="{{ __('messages.company') }} {{ __('messages.type') }}">
                                <label for="" class="animated-label active-label"><i class="fas fa-newspaper"></i> {{ __('messages.company') }} {{ __('messages.type') }}</label>
                            </div>
                            <span class="text-danger small" id="company_type_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="d-flex">
                                <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.country') }}">
                                    <style>
                                        .country-select {
                                            width: 100% !important;
                                        }
                                    </style>
                                    <input type="text" id="country" value="{{ $company->country }}" name="country" class="form-control">
                                </div>
                            </div>
                            <span class="text-danger small" id="country_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->address }}" name="address">
                                <label for="" class="animated-label active-label"><i class="fas fa-map-marker"></i> {{ __('messages.present') }} {{ __('messages.address') }}</label>
                            </div>
                            <span class="text-danger small" id="address_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->address_optional }}" name="address_optional" placeholder="{{ __('messages.address') }} {{ __('messages.optional') }}" id="address_optional">
                                <label for="" class="animated-label active-label"><i class="fas fa-map-marker"></i> {{ __('messages.address') }}</label>
                            </div>
                            <span class="text-danger small" id="address_optional_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control" value="{{ $company->email }}" name="email" placeholder="{{ __('messages.email') }}" id="email">
                                <label for="" class="animated-label active-label"><i class="fas fa-envelope-open"></i> {{ __('messages.email') }}</label>
                            </div>
                            <span class="text-danger small" id="email_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" value="{{ $company->phone }}" name="phone" placeholder="{{ __('messages.phone_number') }}" id="phone">
                                <label for="" class="animated-label active-label"><i class="fas fa-mobile-alt"></i> {{ __('messages.phone_number') }}</label>
                            </div>
                            <span class="text-danger small" id="phone_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->city }}" name="city" placeholder="{{ __('messages.city') }}" id="city">
                                <label for="" class="animated-label active-label"><i class="fas fa-city"></i> {{ __('messages.city') }}</label>
                            </div>
                            <span class="text-danger small" id="city_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->state }}" name="state" placeholder="{{ __('messages.state') }}" id="state">
                                <label for="" class="animated-label active-label"><i class="fas fa-building"></i> {{ __('messages.state') }}</label>
                            </div>
                            <span class="text-danger small" id="state_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" value="{{ $company->post_code }}" name="post_code" placeholder="{{ __('messages.zip_code') }}" id="post_code">
                                <label for="" class="animated-label active-label"><i class="fas fa-university"></i> {{ __('messages.zip_code') }}</label>
                            </div>
                            <span class="text-danger small" id="post_code_Error"></span>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" value="{{ $company->stock_warning }}" name="stock_warning" placeholder="{{ __('messages.stock_warning') }}" id="stock_warning">
                                <label for="" class="animated-label active-label"><i class="fas fa-cart-plus"></i> {{ __('messages.stock_warning') }}</label>
                            </div>
                            <span class="text-danger small" id="stock_warning_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->currency_symbol }}" name="currency_symbol" placeholder="{{ __('messages.currency_symbol') }} " id="currency_symbol">
                                <label for="" class="animated-label active-label"><i class="fas fa-coins"></i> {{ __('messages.currency_symbol') }}</label>
                            </div>
                            <span class="text-danger small" id="currency_symbol_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->invoice_greetings }}" name="invoice_greetings" placeholder="{{ __('messages.invoice_greetings') }} " id="invoice_greetings">
                                <label for="" class="animated-label active-label"><i class="fas fa-coins"></i> {{ __('messages.invoice_greetings') }}</label>
                            </div>
                            <span class="text-danger small" id="invoice_greetings_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{ $company->invoice_footer }}" name="invoice_footer" placeholder="{{ __('messages.invoice_footer') }} " id="invoice_footer">
                                <label for="" class="animated-label active-label"><i class="fas fa-coins"></i> {{ __('messages.invoice_footer') }}</label>
                            </div>
                            <span class="text-danger small" id="invoice_footer_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" value="{{ $company->sms_api_code }}" name="sms_api_code" placeholder="SMS Api Code smsapibd.com" id="sms_api_code">
                                <label for="" class="animated-label active-label"><i class="fas fa-building"></i> {{ __('messages.sms_api_code') }} </label>
                            </div>
                            <span class="text-danger small" id="sms_api_code_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control" value="{{ $company->sms_sender_id }}" name="sms_sender_id" placeholder="SMS Sender ID smsapibd.com" id="sms_sender_id">
                                <label for="" class="animated-label active-label"><i class="fas fa-building"></i> {{ __('messages.sms_api_sender') }}</label>
                            </div>
                            <span class="text-danger small" id="sms_sender_id_Error"></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="d-flex" data-bs-toggle="tooltip-primary" title="{{ __('messages.sms_api_code_provider') }}">
                                <div class="input-group">
                                    <select name="sms_provider" id="sms_provider" title="" class="form-control select2">
                                        <option label="smsapibd">smsapibd.com</option>
                                        <option value="bd_sms">BD SMS</option>
                                    </select>
                                </div>
                                <span class="text-danger small" id="sms_provider_Error"></span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="d-flex">
                                <div class="input-group" data-bs-toggle="tooltip-primary" title="{{ __('messages.sms_setting') }}">
                                    <select name="sms_setting" class="form-control select2" id="sms_setting" title="{{ __('messages.sms_setting') }}">
                                        <option label="active">{{ __('messages.active') }}</option>
                                        <option value="deactive">{{ __('messages.deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <span class="text-danger small" id="sms_setting_Error"></span>
                        </div>

                        @if (request()->getHost() != 'erp.bsoftbd.com')
                            <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                <div class="form-group">
                                    <input type="file" accept="image/*" name="logo" class="form-control logo" data-bs-toggle="tooltip-primary" placeholder="" id="logo" title="{{ __('messages.logo') }}">
                                    <span class="text-danger" style="color: red !important">Logo Size (Width: 264px & height: 64px )</span>
                                </div>

                                <span class="text-danger small" id="logo_Error"></span>
                                <div class="d-flex justify-content-center mt-3">
                                    <img src="{{ asset('storage/company/' . $company->logo) }}" id="logo-image-preview" alt="" height="150">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                <div class="form-group">
                                    <input type="file" accept="image/*" name="banner" class="form-control banner" data-bs-toggle="tooltip-primary" placeholder="" id="banner" title="{{ __('messages.banner') }}">
                                </div>
                                <span class="text-danger small" id="banner_Error"></span>
                                <div class="d-flex justify-content-center mt-3">
                                    <img src="{{ asset('storage/company/' . $company->banner) }}" id="banner-image-preview" alt="" height="150">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                <div class="form-group">
                                    <input type="file" accept="image/*" name="invoice_header" class="form-control invoice_header" data-bs-toggle="tooltip-primary" placeholder="" id="invoice_header" title="{{ __('messages.invoice_header') }}">
                                </div>
                                <span class="text-danger small" id="invoice_header_Error"></span>
                                <div class="d-flex justify-content-center mt-3">
                                    <img src="{{ asset('storage/company/' . $company->invoice_header) }}" id="header-image-preview" alt="" height="150">
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 mt-4">
                                <div class="form-group">
                                    <input type="file" accept="image/*" name="favicon" class="form-control favicon" data-bs-toggle="tooltip-primary" placeholder="" id="favicon" title="{{ __('messages.favicon') }}">
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <img src="{{ asset('storage/company/' . $company->favicon) }}" id="favicon-image-preview" alt="" height="150">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-start mt-5">
                        <button class="btn btn-info">{{ __('messages.update') }} {{ __('messages.company') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('dashboard/js/country-select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#country").countrySelect({
                defaultCountry: "bd",
                preferredCountries: ['ca', 'gb', 'us']
            });
        });
    </script>
    <script>
        // Function to handle file input change
        $("#logo").change(function() {
            // Get the selected file
            var file = this.files[0];
            if (file) {
                // Display the image preview (optional)
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#logo-image-preview").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                // Clear the image preview if no file is selected
                $("#logo-image-preview").attr("src", "").hide();
            }
        });

        $("#favicon").change(function() {
            // Get the selected file
            var file = this.files[0];
            if (file) {
                // Display the image preview (optional)
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#favicon-image-preview").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                // Clear the image preview if no file is selected
                $("#favicon-image-preview").attr("src", "").hide();
            }
        });
        // Function to handle file input change
        $("#banner").change(function() {
            // Get the selected file
            var file = this.files[0];
            if (file) {
                // Display the image preview (optional)
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#banner-image-preview").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                // Clear the image preview if no file is selected
                $("#banner-image-preview").attr("src", "").hide();
            }
        });

        // Function to handle file input change
        $("#invoice_header").change(function() {
            // Get the selected file
            var file = this.files[0];
            if (file) {
                // Display the image preview (optional)
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#header-image-preview").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                // Clear the image preview if no file is selected
                $("#header-image-preview").attr("src", "").hide();
            }
        });


        $(document).ready(function() {
            $('#logo').change(function(event) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.showImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(event.target.files['0']);
            });
            // select2 form input
        });
        $(document).ready(function() {
            $('#banner').change(function(event) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.showImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(event.target.files['0']);
            });
            // select2 form input
        });
        $(document).ready(function() {
            $('#invoice_header').change(function(event) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.showImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(event.target.files['0']);
            });
            // select2 form input
        });

        $('#company-information-form').find('input, textarea, select').each(function() {
            var id = this.id;
            $("#" + id + "").on('keyup', function() {
                var length = $("#" + id + "").val().length;
                if (length < 1) {
                    $('#' + id + '').addClass('border-danger');
                    $('#' + id + '_Error').text('Fill the input');
                } else {
                    $('#' + id + '').removeClass('border-danger');
                    $('#' + id + '_Error').text('');
                }
            });
        });
    </script>
@endpush
