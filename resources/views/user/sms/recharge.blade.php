@extends('layouts.user.app')
@section('content')
    <div class="main-content-body">
        <div class="row row-sm">
            <div class="card px-0">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <p class="card-title my-0">{{ $pageTitle }}</p>
                    <div class="d-flex align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">{{ __('messages.go_back') }}</a>
                        <div class="d-flex">
                            <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/936WX3EYwJk?si=KsO6JmLPCBwaedI9">
                                <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="">
                            <div class="row justify-content-center mt-5">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <input id="amount" type="text" class="form-control" name="amount">
                                        <label class="animated-label" for="amount"><i class="fas fa-user"></i> {{ __('messages.amount') }}</label>
                                        @error('amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-lg-2 pb-5 text-center">
                                    <button type="submit" id="submitButton" class="btn btn-lg btn-success mt-5">{{ __('messages.recharge_now') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
