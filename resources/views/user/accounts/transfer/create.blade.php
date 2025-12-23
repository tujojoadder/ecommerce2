@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/transfer/edit*');
    @endphp
    <div class="main-content-body container">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <p class="card-title my-0">{{ $pageTitle }}</p>
                <div class="d-flex">
                    <a href="{{ route('user.transfer.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-list d-inline"></i> {{ __('messages.transfer') }} {{ __('messages.list') }}
                    </a>
                    <div class="d-flex">
                        <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal" id="youtubeModalInstructionBtn" data-link="https://www.youtube.com/embed/qEvvnplupHA?si=VjTrkln3SkGBONkM">
                            <img width="100" class="border p-2 rounded-lg bg-white" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session()->has('error'))
                    <div class="alert bg-danger rounded-lg alert-dismissible fade show" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">{{ session('error') }}</h5>
                            <button type="button" class="btn btn-light" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">X</span>
                            </button>
                        </div>
                    </div>
                @endif

                <form action="{{ $route ? route('user.transfer.update', $sender->transfer_id) : route('user.transfer.store') }}" method="POST">
                    @csrf
                    @if ($route)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.from_account') }}">
                                    <select name="from_account_id" id="from_account_id" class="form-control account_id @error('group_id') is-invalid border-danger @enderror select2">
                                    </select>
                                </div>
                                <a id="accountAddModalBtnFrom" data-bs-toggle="modal" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span id="from_account_id_Error" class="font-weight-bold"></span>
                        </div>
                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.to_account') }}">
                                    <select name="to_account_id" id="to_account_id" class="form-control account_id @error('group_id') is-invalid border-danger @enderror select2">
                                    </select>
                                </div>
                                <a id="accountAddModalBtnTo" data-bs-toggle="modal" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span id="to_account_id_Error" class="font-weight-bold"></span>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="date" class="form-control @error('date') is-invalid border-danger @enderror fc-datepicker" value="{{ $route ? $sender->date : date('d/m/Y') }}" placeholder="DD/MM/YYYY" id="date">
                                <label class="animated-label active-label" for="date"><i class="far fa-sticky-note"></i> {{ __('messages.date') }}</label>
                            </div>
                            <span class="text-danger small" id="date_Error"></span>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $route ? $sender->description : '' }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="description"><i class="far fa-sticky-note"></i> {{ __('messages.description') }}</label>
                            </div>
                            <span class="text-danger small" id="description_Error"></span>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $route ? $sender->amount : '' }}">
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="amount"><i class="far fa-sticky-note"></i> {{ __('messages.amount') }}</label>
                            </div>
                            <span class="text-danger small" id="amount_Error"></span>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input id="tags" type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" {{ $route ? $sender->tags : '' }}>
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="tags"><i class="fas fa-tags"></i> {{ __('messages.tags') }}</label>
                            </div>
                            <span class="text-danger small" id="tags_Error"></span>
                        </div>

                        <div class="form-group col-xl-4 col-lg-6 col-md-6">
                            <div class="d-flex">
                                <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.payment') }} {{ __('messages.method') }}">
                                    <select name="payment_id" id="payment_id" class="form-control payment_id @error('payment_id') is-invalid border-danger @enderror">
                                    </select>
                                </div>
                                <a data-bs-target="#paymentMethodModal" data-bs-toggle="modal" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="form-group">
                                <input id="reference" type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" {{ $route ? $sender->reference : '' }}>
                                <label class="animated-label {{ $route ? 'active-label' : '' }}" for="reference"><i class="fas fa-asterisk"></i> {{ __('messages.reference') }}</label>
                            </div>
                            <span class="text-danger small" id="reference_Error"></span>
                        </div>

                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                            <button type="submit" class="add-to-cart btn btn-success btn-block">{{ $route ? 'Update' : 'Add' }} {{ __('messages.transfer') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Col -->
    </div>
    @include('user.accounts.account.account-modal')
    @include('user.config.payment-method.payment-method-modal')
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
    <script>
        $(document).ready(function() {
            @if ($route)
                setTimeout(() => {
                    $("#from_account_id").val("{{ $sender->account_id }}").trigger('change');
                    $("#to_account_id").val("{{ $receiver->account_id }}").trigger('change');

                    $("#payment_id").val("{{ $sender->payment_id }}").trigger('change');
                }, 500);
            @endif
            $("#accountAddModalBtnFrom, #accountAddModalBtnTo").on('click', function() {
                $("#accountAddModal").modal('show');
            });
            fetchAccounts();
            fetchPaymentMethods();

            function handleAccountChange(fromSelector, toSelector) {
                var from_account_id = $(fromSelector).val();
                var to_account_id = $(toSelector).val();

                if (from_account_id === to_account_id) {
                    $(toSelector).addClass('border-danger').val('').trigger('change');
                    setTimeout(() => {
                        $("#to_account_id_Error").addClass('text-danger');
                        $("#to_account_id_Error").text("Sender account and Receiver account cannot be the same!");
                    }, 300);

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Sender account and Receiver account cannot be the same!',
                        showConfirmButton: false,
                        timer: 2500
                    });
                } else {
                    $(toSelector).removeClass('border-danger');
                    $("#to_account_id_Error").text("");
                }
            }

            $("#to_account_id").on('change', function() {
                handleAccountChange("#from_account_id", "#to_account_id");
            });

            $("#from_account_id").on('change', function() {
                handleAccountChange("#to_account_id", "#from_account_id");
            });


            $("form").on('submit', function(e) {
                var from_account_id = $("#from_account_id").val();
                var to_account_id = $("#to_account_id").val();
                if (from_account_id === to_account_id) {
                    e.preventDefault();
                    $("#to_account_id").addClass('border-danger');
                    $("#to_account_id_Error").addClass('text-danger');
                    setTimeout(() => {
                        $("#to_account_id_Error").text("Sender account and Receiver account cannot be the same!");
                    }, 300);
                }
            });
            @if ($route)
                $('.account_id').val({{ $route ? $sender->transfer_id : '0' }}).trigger('change');
            @endif
        });
    </script>
@endpush
