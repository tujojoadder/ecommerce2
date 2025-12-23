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
                            <div class="row justify-content-center mt-3">
                                <div class="col-md-12 mb-3">
                                    <label for="messageBody">{{ __('messages.message_body') }}</label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="message_body" id="messageBody" cols="30" rows="10" placeholder="{{ __('messages.message_body_placeholder') }}"></textarea>
                                    </div>
                                    <p class="mt-1">{{ __('messages.remaining_characters') }}: <span id="characterCount">160</span></p>
                                </div>
                                @if (Route::is('user.sms.send.schedule.wise'))
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input name="schedule_at" id="schedule_at" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ date('d/m/Y') }}" type="text">
                                            <label class="animated-label active-label" for="schedule_at"><i class="typcn typcn-calendar-outline"></i> {{ __('messages.date') }}</label>
                                        </div>
                                        <span class="text-danger small" id="schedule_at_Error"></span>
                                    </div>
                                @endif
                                @if (Route::is('user.sms.send.to.client') || Route::is('user.sms.send.schedule.wise'))
                                    <div class="col-md-12">
                                        <label for="client_id">{{ __('messages.client') }}</label>
                                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client') }}">
                                            <div class="input-group">
                                                <select name="client_id" id="client_id" class="form-control client_id"></select>
                                            </div>
                                            <a id="clientAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                        <span class="text-danger font-weight-bolder small ms-2" id="client_id_Error"></span>
                                    </div>
                                @endif
                                @if (Route::is('user.sms.send.to.client.group'))
                                    <div class="col-md-12">
                                        <label for="client_group_id">{{ __('messages.client_group') }}</label>
                                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.client_group') }}">
                                            <div class="input-group">
                                                <select name="client_group_id" id="client_group_id" class="form-control client_group_id"></select>
                                            </div>
                                            <a id="clientGroupModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                        <span class="text-danger font-weight-bolder small ms-2" id="client_group_id_Error"></span>
                                    </div>
                                @endif
                                @if (Route::is('user.sms.send.to.supplier'))
                                    <div class="col-md-12">
                                        <label for="supplier_id">{{ __('messages.supplier') }}</label>
                                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier') }}">
                                            <div class="input-group">
                                                <select name="supplier_id" id="supplier_id" class="form-control supplier_id"></select>
                                            </div>
                                            <a id="supplierAddModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                        <span class="text-danger font-weight-bolder small ms-2" id="supplier_id_Error"></span>
                                    </div>
                                @endif
                                @if (Route::is('user.sms.send.to.supplier.group'))
                                    <div class="col-md-12">
                                        <label for="supplier_group_id">{{ __('messages.supplier_group') }}</label>
                                        <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary" title="{{ __('messages.supplier_group') }}">
                                            <div class="input-group">
                                                <select name="supplier_group_id" id="supplier_group_id" class="form-control supplier_group_id"></select>
                                            </div>
                                            <a id="supplierGroupModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i class="fas fa-plus"></i></a>
                                        </div>
                                        <span class="text-danger font-weight-bolder small ms-2" id="supplier_group_id_Error"></span>
                                    </div>
                                @endif
                                <div class="col-md-3 mb-lg-2 pb-5">
                                    <label for="button">&nbsp;</label>
                                    <button type="submit" id="submitButton" class="btn btn-block btn-lg btn-success">{{ __('messages.send_message') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.client.client-add-modal')
    @include('user.client.group.client-group-modal')
    @include('user.supplier.supplier-add-modal')
    @include('user.supplier.group.supplier-group-modal')
@endsection
@push('scripts')
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script>
        $(document).ready(function() {
            fetchClients(1);
            fetchClientGroups(1);
            fetchSuppliers(1);
            fetchSupplierGroups(1);

            $("#clientGroupModalBtn").click(function() {
                $("#clientGroupModal").modal("show");
            });

            $("#supplierAddModalBtn").on('click', function() {
                $("#supplierAddModal").modal('show');
            });

            $("#supplierGroupModalBtn").click(function() {
                $("#supplierGroupModal").modal("show");
            });

            function countBengaliCharacters(text) {
                var characterCount = 0;
                var firstBengaliEncountered = false;
                for (var i = 0; i < text.length; i++) {
                    // Check if the character is a Bengali character
                    var isBengaliChar = text[i].match(/[\u0980-\u09FF\u09E6-\u09EF]/);
                    if (isBengaliChar) {
                        // If it's the first Bengali character encountered, add 91 to the count
                        if (!firstBengaliEncountered) {
                            characterCount += 91;
                            firstBengaliEncountered = true;
                        } else {
                            // If it's not the first Bengali character, add 0 to the count
                            ++characterCount;
                        }
                    } else {
                        // If it's not a Bengali character, add 1 to the count
                        characterCount++;
                    }
                }
                return characterCount;
            }

            $(document).ready(function() {
                $("#messageBody").on("input", function() {
                    var text = $(this).val();
                    var characterCount = countBengaliCharacters(text);
                    var remainingCharacters = 160 - characterCount; // Reverse count
                    $("#characterCount").text(remainingCharacters);
                    if (remainingCharacters <= -1) {
                        $("#submitButton").prop('disabled', true);
                    } else {
                        $("#submitButton").prop('disabled', false);
                    }
                    if (remainingCharacters <= 0) {
                        $("#characterCount").addClass('bg-danger px-1 rounded');
                    } else {
                        $("#characterCount").removeClass('bg-danger px-1 rounded');
                    }
                });
            });

        });
    </script>
@endpush
