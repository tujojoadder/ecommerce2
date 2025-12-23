<div class="container-fluid sticky-top bg-white border-bottom payment_status d-none rounded-lg mt-4 shadow-lg" id="countdown" style="height: auto; top: 60px;">
    <div class="row">
        <div class="col-md-12">
            <div class="row align-items-center mx-auto">
                <div class="col-md-4" style="background-color:#fff;">
                    <a href="{{ route('payment') }}">
                        <img class="my-3 p-1 rounded-lg border" src="{{ asset('upload/getway2.png') }}" alt="">
                    </a>
                </div>
                <div class="col-md-4 text-center mt-2">
                    <h1 class="text-danger font-weight-bold my-2" style="border-bottom: 2px dashed maroon;">নোটিশ!</h1>
                    <div class="notice_board">
                        <h4 style="display: block; font-weight: bolder;" id="notice_text">আপনার সফ্টওয়ার ব্যাবহারের সময়সীমা</h4>
                        <span id="notice_timer">
                            <div class="countdown-container">
                                <div id="countdown">
                                    <ul class="d-flex justify-content-center mb-0 px-0">
                                        <li class="list-group-item border-0 px-2 pt-0 pb-1">
                                            <span class="btn btn-info font-weight-bolder px-3 py-0 mb-1 days" style="font-size: 20px">00</span>
                                            <p class="mb-0" style="font-size: 15px; font-weight: bolder;">দিন</p>
                                        </li>
                                        <li class="list-group-item border-0 px-2 pt-0 pb-1">
                                            <span class="btn btn-info font-weight-bolder px-3 py-0 mb-1 hours" style="font-size: 20px">00</span>
                                            <p class="mb-0" style="font-size: 15px; font-weight: bolder;">ঘন্টা</p>
                                        </li>
                                        <li class="list-group-item border-0 px-2 pt-0 pb-1">
                                            <span class="btn btn-info font-weight-bolder px-3 py-0 mb-1 minutes" style="font-size: 20px">00</span>
                                            <p class="mb-0" style="font-size: 15px; font-weight: bolder;">মিনিট</p>
                                        </li>
                                        <li class="list-group-item border-0 px-2 pt-0 pb-1">
                                            <span class="btn btn-info font-weight-bolder px-3 py-0 mb-1 seconds" style="font-size: 20px">00</span>
                                            <p class="mb-0" style="font-size: 15px; font-weight: bolder;">সেকেন্ড</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="mb-3 mt-1" style="font-weight: bolder; display: flex !important; justify-content: center;">
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="javascript:;" class="text-info" id="youtubeModalBtn">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span style="font-size: 15px; line-height: normal !important; margin-right: 10px">যেভাবে পেমেন্ট দিবেন <i class="fas fa-arrow-right"></i></span>
                                    <img style="width: 120px" src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-lg-12 col-5">
                            <a href="{{ route('payment') }}">
                                <img class="my-3 rounded-lg border" src="{{ asset('upload/click-topay.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- youtube modal --}}
<div class="modal" id="youtubeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title">How To Pay</h5>
            </div>
            <div class="modal-body p-0">
                <div style="margin: 10px !important;">
                    <div id="videoContainer"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger closeVedio" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- youtube modal --}}


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    @if (env('APP_STATUS') == 'on')
        <script>
            $(document).ready(function() {
                var status = "{{ checkSoftwareValidity()['status'] }}";
                var remainingDays = "{{ checkSoftwareValidity()['remaining_days'] }}";
                var last_updated_date = "{{ checkSoftwareValidity()['last_updated_at'] }}";
                console.log("Status :", status);
                console.log("Remaining Days :", remainingDays);
                var formattedDate = moment(last_updated_date).format('DD/MM/YYYY');
                console.log("Renew At :", formattedDate);

                // Countdown timer
                if (remainingDays <= 7) {
                    $('#countdown').removeClass('d-none');
                    if (remainingDays <= 0) {
                        window.location.href = "{{ route('payment') }}";
                    }
                    $(".countdown").removeClass('d-none');

                    // Calculate endDate based on current date + remainingDays
                    var endDate = moment().add(remainingDays, 'days');
                    var interval = 1000;

                    function countdownWatch() {
                        var now = moment();
                        var duration = moment.duration(endDate.diff(now));
                        $(".days").text((duration.days()).toString().padStart(2, '0'));
                        $(".hours").text((duration.hours()).toString().padStart(2, '0'));
                        $(".minutes").text((duration.minutes()).toString().padStart(2, '0'));
                        $(".seconds").text((duration.seconds()).toString().padStart(2, '0'));
                    }

                    countdownWatch();
                    setInterval(function() {
                        countdownWatch();
                    }, interval);
                }
            });
        </script>
    @endif
@endpush
