@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Route::is('user.account.edit');
    @endphp
    <div class="main-content-body">
        <div class="container">
            <form action="{{ $route ? route('user.account.update', $account->id) : route('user.account.store') }}" method="post">
                @csrf
                @if ($route)
                    @method('PUT')
                @endif
                <!-- Col -->
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <p class="card-title my-0">{{ $pageTitle }}</p>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.account.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-list d-inline"></i> {{ __('messages.account') }} {{ __('messages.list') }}
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left d-inline"></i> {{ __('messages.go_back') }}
                            </a>
                            <div class="d-flex">
                                <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/DH9YbBFvQUM?si=KO5UuK4XD1l4Kshi">
                                    <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card-body mb-5 mt-3">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $route ? $account->title : old('title') }}" @error('title') autofocus @enderror>
                                            <label class="animated-label {{ $route ? 'active-label' : '' }}" for="title"><i class="fas fa-wallet"></i> {{ __('messages.account') }} {{ __('messages.title') }}</label>
                                            @error('title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input id="initial_balance" type="number" class="form-control @error('initial_balance') is-invalid @enderror" name="initial_balance" value="{{ $route ? $account->initial_balance : old('initial_balance') }}" @error('initial_balance') autofocus @enderror>
                                            <label class="animated-label {{ $route ? 'active-label' : '' }}" for="initial_balance">{{ config('company.currency_symbol') }} {{ __('messages.initial') }} {{ __('messages.balance') }}</label>
                                            @error('initial_balance')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input id="account_number" type="number" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ $route ? $account->account_number : old('account_number') }}" @error('account_number') autofocus @enderror>
                                            <label class="animated-label {{ $route ? 'active-label' : '' }}" for="account_number"><i class="fas fa-university"></i> {{ __('messages.account') }} {{ __('messages.number') }}</label>
                                            @error('account_number')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input id="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ $route ? $account->contact_person : old('contact_person') }}" @error('contact_person') autofocus @enderror>
                                            <label class="animated-label {{ $route ? 'active-label' : '' }}" for="contact_person"><i class="fas fa-user"></i> {{ __('messages.contact_person') }}</label>
                                            @error('contact_person')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $route ? $account->phone : old('phone') }}" @error('phone') autofocus @enderror>
                                            <label class="animated-label {{ $route ? 'active-label' : '' }}" for="phone"><i class="fas fa-phone"></i> {{ __('messages.phone') }} {{ __('messages.number') }}</label>
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-xl-12 col-lg-12 col-md-12">
                                        <label for="" class="form-label">{{ __('messages.description') }}</label>

                                        <div class="d-block">
                                            <textarea name="description" value="{{ old('description', $route ? $account->description : '') }}" class="form-control  @error('description') is-invalid border-danger @enderror" cols="5" rows="5" placeholder="{{ __('messages.account') }} {{ __('messages.description') }}">{{ $route ? $account->description : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                                        <button type="submit" class="add-to-cart btn btn-success btn-block"><i class="fas fa-plus"></i> {{ $route ? 'Update' : 'Add' }} {{ __('messages.account') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Col -->
            </form>
        </div>
    </div>
@endsection
