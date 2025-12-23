@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/client/edit*');
        $queryString = $_SERVER['QUERY_STRING'];
    @endphp
    <div class="main-content-body">
        <!-- Col -->
        <div class="card">
            <div class="card-header border-bottom d-lg-flex justify-content-lg-between align-items-center">
                <p class="card-title my-0">{{ $pageTitle }}</p>
                <div class="d-flex align-items-center">
                    <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                    @if ($queryString == 'loan')
                        <a href="{{ route('user.client.loan.client') }}?loan" class="btn btn-secondary me-2">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.client') }} {{ __('messages.list') }}
                        </a>
                    @else
                        <a href="{{ route('user.client.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-list d-inline"></i> {{ __('messages.client') }} {{ __('messages.list') }}
                        </a>
                    @endif
                    @if ($queryString != 'loan')
                        <a href="{{ route('user.client-group.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-layer-group d-inline"></i> {{ __('messages.client') }} {{ __('messages.group') }}
                        </a>
                    @endif
                    <div class="d-flex">
                        <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/vGrV7oYp93s?si=LXxUqSMaWlRzNZL5">
                            <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ $route ? route('user.client.update', $client->id) : route('user.client.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($route)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_id_no') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="id_no" type="text" class="form-control @error('id_no') is-invalid @enderror" name="id_no" value="{{ $route ? $client->id_no : old('id_no') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="id_no"><i class="fas fa-id-card"></i> {{ __('messages.id_no') }}</label>
                                @error('id_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_client_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="client_name" type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name" value="{{ $route ? $client->client_name : old('client_name') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="client_name"><i class="fas fa-user"></i> {{ __('messages.client') }} {{ __('messages.name') }}</label>
                                @error('client_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_fathers_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="fathers_name" type="text" class="form-control @error('fathers_name') is-invalid @enderror" name="fathers_name" value="{{ $route ? $client->fathers_name : old('fathers_name') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="fathers_name"><i class="fas fa-user"></i> {{ __('messages.fathers_name') }}</label>
                                @error('fathers_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_mothers_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="mothers_name" type="text" class="form-control @error('mothers_name') is-invalid @enderror" name="mothers_name" value="{{ $route ? $client->mothers_name : old('mothers_name') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="mothers_name"><i class="fas fa-female"></i> {{ __('messages.mothers_name') }}</label>
                                @error('mothers_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_company_name') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $route ? $client->company_name : old('company_name') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="company_name"><i class="fas fa-building"></i> {{ __('messages.company_name') }}</label>
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_address') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $route ? $client->address : old('address') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="address"><i class="fas fa-map-marked-alt"></i> {{ __('messages.address') }}</label>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_phone') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $route ? $client->phone : old('phone') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="phone"><i class="fas fa-mobile-alt"></i> {{ __('messages.phone_number') }}</label>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_phone_optional') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="phone_optional" type="number" class="form-control @error('phone_optional') is-invalid @enderror" name="phone_optional" value="{{ $route ? $client->phone_optional : old('phone_optional') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="phone_optional"><i class="fas fa-mobile-alt"></i> {{ __('messages.phone') }} {{ __('messages.optional') }}</label>
                                @error('phone_optional')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_previous_due') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="previous_due" type="number" class="form-control @error('previous_due') is-invalid @enderror" name="previous_due" value="{{ $route ? $client->previous_due : old('previous_due') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="previous_due"><i class="fas fa-funnel-dollar"></i> {{ __('messages.previous_due') }}</label>
                                @error('previous_due')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_max_due_limit') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="max_due_limit" type="number" class="form-control @error('max_due_limit') is-invalid @enderror" name="max_due_limit" value="{{ $route ? $client->max_due_limit : old('max_due_limit', 0) }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="max_due_limit"><i class="fas fa-sort-amount-down-alt"></i> {{ __('messages.max_due_limit') }}</label>
                                @error('max_due_limit')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_email') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $route ? $client->email : old('email') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="email"><i class="far fa-envelope"></i> {{ __('messages.email') }}</label>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_date_of_birth') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="date_of_birth" type="text" class="form-control @error('date_of_birth') is-invalid @enderror fc-datepicker" name="date_of_birth" value="{{ $route ? $client->date_of_birth : old('date_of_birth') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="date_of_birth"><i class="fas fa-calendar-alt"></i> {{ __('messages.date_of_birth') }}</label>
                                @error('date_of_birth')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_upazilla_thana') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="upazilla_thana" type="text" class="form-control @error('upazilla_thana') is-invalid @enderror" name="upazilla_thana" value="{{ $route ? $client->upazilla_thana : old('upazilla_thana') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="upazilla_thana"><i class="fas fa-city"></i> {{ __('messages.upzilla') }}</label>
                                @error('upazilla_thana')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_zip_code') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ $route ? $client->zip_code : old('zip_code') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="zip_code"><i class="fas fa-map-marked-alt"></i> {{ __('messages.zip_code') }}</label>
                                @error('zip_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_street_road') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="street_road" type="text" class="form-control @error('street_road') is-invalid @enderror" name="street_road" value="{{ $route ? $client->street_road : old('street_road') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="street_road"><i class="fas fa-map-marked-alt"></i> {{ __('messages.street_road') }}</label>
                                @error('street_road')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_reference') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <input id="reference" type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" value="{{ $route ? $client->reference : old('reference') }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="reference"><i class="fas fa-users"></i> {{ __('messages.reference') }}</label>
                                @error('reference')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 col-md-6 {{ config('clients_group_id') == 1 ? '' : 'd-none' }}">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.group') }}">
                                    <select name="group_id" id="client_group_id" class="form-control @error('group_id') is-invalid border-danger @enderror select2">
                                    </select>
                                </div>
                                <a data-bs-target="#clientGroupModal" data-bs-toggle="modal" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>


                        <input type="hidden" name="client_type" value="{{ request()->has('loan') ? 1 : 0 }}">
                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_status') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.status') }}">
                                    <select name="status" class="form-control @error('status') is-invalid border-danger @enderror">
                                        <option value="1">{{ __('messages.active') }}</option>
                                        <option value="0">{{ __('messages.deactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 {{ config('clients_image') == 1 ? '' : 'd-none' }}">
                            <div class="form-group">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.image') }}">
                                    <input type="file" accept="image/*" name="image" class="form-control @error('image') is-invalid border-danger @enderror image" placeholder="" id="image">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div id="image-show" class="{{ $route ? 'mt-2 p-1' : '' }}">
                                        @if ($route)
                                            <img src="{{ asset('storage/profile/' . $client->image) }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                            <button type="submit" class="add-to-cart btn btn-success btn-block"><i class="fas fa-plus"></i> {{ __('messages.client') }} {{ $route ? __('messages.update') : __('messages.add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Col -->
    </div>

    @include('user.client.group.client-group-modal')
    @include('user.client.form-setting-modal')
@endsection

@push('scripts')
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
            fetchClientGroups();
            @if ($route)
                setTimeout(() => {
                    getClientGroupInfo('/get-client-group', {{ $client->group_id }});
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
