@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/supplier/edit/*');
    @endphp
    <link rel="stylesheet" href="{{ asset('dashboard/css/country-select.css') }}">
    <div class="main-content-body">

        <!-- Col -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <p class="card-title my-0">{{ $pageTitle }}</p>
                <div class="d-flex align-items-center">
                    <a href="javascript:;" data-bs-target="#supplierFormSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                    <a href="{{ route('user.supplier.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-list d-inline"></i> {{ __('messages.supplier') }} {{ __('messages.list') }}
                    </a>
                    <a href="{{ route('user.supplier-group.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-layer-group d-inline"></i> {{ __('messages.supplier') }} {{ __('messages.group') }}
                    </a>
                    <div class="d-flex">
                        <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/leY6s7skQgg?si=80TGmPfL-gC0i8CR">
                            <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ $route ? route('user.supplier.update', $supplier->id) : route('user.supplier.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($route)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_supplier_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="supplier_name" type="text" class="form-control @error('supplier_name') is-invalid @enderror" name="supplier_name" value="{{ $route ? $supplier->supplier_name : old('supplier_name') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="supplier_name"><i class="fas fa-user"></i> {{ __('messages.supplier') }} {{ __('messages.name') }}</label>
                                @error('supplier_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_company_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $route ? $supplier->company_name : old('company_name') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="company_name"><i class="fas fa-sitemap"></i> {{ __('messages.company') }} {{ __('messages.name') }}</label>
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_phone') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $route ? $supplier->phone : old('phone') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="phone"><i class="fas fa-mobile"></i> {{ __('messages.phone') }}</label>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_phone_optional') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="phone_optional" type="number" class="form-control @error('phone_optional') is-invalid @enderror" name="phone_optional" value="{{ $route ? $supplier->phone_optional : old('phone_optional') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="phone_optional"><i class="fas fa-mobile"></i> {{ __('messages.phone_number') }} ({{ __('messages.optional') }})</label>
                                @error('phone_optional')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_email') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $route ? $supplier->email : old('email') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="email"><i class="fas fa-envelope"></i> {{ __('messages.email') }}</label>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_previous_due') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="previous_due" type="number" class="form-control @error('previous_due') is-invalid @enderror" name="previous_due" value="{{ $route ? $supplier->previous_due : old('previous_due') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="previous_due"><i class="fas fa-money-check"></i> {{ __('messages.previous_due') }}</label>
                                @error('previous_due')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_address') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $route ? $supplier->address : old('address') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="address"><i class="fas fa-map"></i> {{ __('messages.address') }}</label>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_city_state') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="city_state" type="text" class="form-control @error('city_state') is-invalid @enderror" name="city_state" value="{{ $route ? $supplier->city_state : old('city_state') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="city_state"><i class="fas fa-city"></i> {{ __('messages.city') }}</label>
                                @error('city_state')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_zip_code') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="zip_code" type="number" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ $route ? $supplier->zip_code : old('zip_code') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="zip_code"><i class="fas fa-map-marker-alt"></i> {{ __('messages.zip_code') }}</label>
                                @error('zip_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_country_name') == 1 ? '' : 'd-none' }}">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.country') }}">
                                <style>
                                    .country-select {
                                        width: 100%;
                                    }
                                </style>
                                <input type="text" value="{{ $route ? $supplier->country_name : old('country_name') }}" class="@error('country_name') is-invalid border-danger @enderror form-control" id="country_name" name="country_name" placeholder="{{ __('messages.country') }}" style="width: 100% !important;">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_domain') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="domain" type="text" class="form-control @error('domain') is-invalid @enderror" name="domain" value="{{ $route ? $supplier->domain : old('domain') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="domain"><i class="fas fa-globe"></i> {{ __('messages.domain') }}</label>
                                @error('domain')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_group_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.group') }}">
                                    <select name="group_id" id="supplier_group_id" class="@error('group_id') is-invalid border-danger @enderror form-control select2">
                                    </select>
                                </div>
                                <a data-bs-target="#supplierGroupModal" data-bs-toggle="modal" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_status') == 1 ? '' : 'd-none' }}">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.status') }}">
                                <select name="status" class="@error('status') is-invalid border-danger @enderror form-control">
                                    <option {{ $route ? $supplier->status == '1' : '' }} value="1">{{ __('messages.active') }}</option>
                                    <option {{ $route ? $supplier->status == '0' : '' }} value="0">{{ __('messages.deactive') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_image') == 1 ? '' : 'd-none' }}">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.image') }}">
                                <input type="file" accept="image/*" name="image" class="@error('image') is-invalid border-danger @enderror form-control image" placeholder="" id="image">
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div id="image-show" class="{{ $route ? 'mt-2 p-1' : '' }}">
                                        @if ($route)
                                            <img src="{{ asset('storage/profile/' . $supplier->image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('suppliers_bank_account') == 1 ? '' : 'd-none' }}">
                            {{-- <label class="animated-label {{ $route ? 'active-label' : '' }}" for="bank_account"><i class="fas fa-university"></i> {{ __('messages.bank') }} {{ __('messages.account') }}</label> --}}
                            <div class="form-group">
                                <textarea id="bank_account" rows="2" type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" placeholder="{{ __('messages.bank') }} {{ __('messages.account') }}">{{ $route ? $supplier->bank_account : old('bank_account') }}</textarea>
                                @error('bank_account')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                            <button type="submit" class="add-to-cart btn btn-success btn-block"><i class="fas fa-plus"></i> {{ $route ? __('messages.update') : __('messages.add') }} {{ __('messages.supplier') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Col -->
    </div>

    @include('user.supplier.group.supplier-group-modal')
    @include('user.supplier.form-setting-modal')
@endsection
@push('scripts')
    <script src="{{ asset('dashboard/js/country-select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#country_name").countrySelect({
                defaultCountry: "bd",
                preferredCountries: ['ca', 'gb', 'us']
            });
        });
    </script>
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchSupplierGroups();
            @if ($route)
                setTimeout(() => {
                    getSupplierGroupInfo('/get-supplier-group', {{ $supplier->group_id }});
                }, 500);
            @endif
        });

        $(document).ready(function() {
            $('#image').change(function() {
                $('#image-show').html('');
                setTimeout(() => {
                    var file = this.files[0];
                    if (file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#image-show').append("<img class='rounded-pill' src=" + e.target.result + ">");
                            $('#image-show').addClass('card card-body mt-2 p-1');
                            $('#image-show').show();
                        };
                        reader.readAsDataURL(file);
                    }
                }, 200);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.image').change(function(event) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.showImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(event.target.files['0']);
            });
            // select2 form input
        });
    </script>
@endpush
