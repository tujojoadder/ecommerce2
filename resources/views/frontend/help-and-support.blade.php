<style>
    .typing-cursor::after {
        content: "|";
        font-size: 150%;
        line-height: 10px;
        animation: step-end infinite;
    }

    .accordion-button::after {
        filter: brightness(100) !important;
        display: none;
    }

    .accordion-button::before {
        filter: brightness(100) !important;
        display: none;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0px 0px 0px 0px #00c251;
        }

        100% {
            box-shadow: 0px 0px 1px 50px #68ff9a00;
        }
    }

    @keyframes textJump {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(2deg);
        }

        0% {
            transform: rotate(-2deg);
        }
    }

    .accordion-button {
        -webkit-animation: pulse 1.5s ease-in-out infinite;
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* .help-text {
        -webkit-animation: textJump 1s alternate infinite;
        animation: textJump 1s alternate infinite;
    } */

    @media (max-width: 800px) {
        .accordion {
            width: 100% !important;
        }

        /* #chatBox {
            width: 100% !important;
        } */
    }
</style>

<div class="accordion accordion-flush position-fixed border-0" style="bottom: 0; right: 0; width: 20%; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important; z-index: 100000 !important;" id="accordionExample">
    <div class="accordion-item bg-success" style="border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
        <h2 class="accordion-header bg-success" style="border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;">
            <button class="accordion-button bg-success text-white" style="background-color: #0ba360 !important; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#helpAndSupport" aria-expanded="false" aria-controls="helpAndSupport">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h4 mb-0 help-text typing-cursor" id="help-text"></span>
                    <img width="10%" class="rounded-circle" src="https://dev.bhisab.oxhostbd.com/public/support.gif" alt="">
                </div>
            </button>
        </h2>
        <div id="helpAndSupport" class="accordion-collapse collapse bg-white text-dark rounded-0" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-12" id="help-and-support-col">
                        <h5 class="help-title" style="text-align: center;">Please fillup your information</h5>
                        <form>
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control" id="support_name" name="name" required placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control" id="support_phone" name="phone" required placeholder="Phone">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="support_email" name="email" required placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control text-dark" id="support_message" name="message" rows="5" required placeholder="Message"></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-lg submit-button btn-block" style="background-color: #0ba360 !important;">Submit a Support Ticket</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="position-absolute care-box px-0" id="chatBox" style="width: 20%; bottom: 0; right: 0; border-top-left-radius: 20px !important; border-top-right-radius: 20px !important; z-index: 100000 !important;">
    <iframe id="myIframe" class="w-100" style="height: 450px;" src="https://softhostit.com/help"></iframe>
</div> --}}

@push('scripts')
    <script>
        $(document).ready(function() {
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function isValidPhone(phone) {
                const phoneRegex = /^\d{10,15}$/; // Customize based on your requirements
                return phoneRegex.test(phone);
            }

            $('.submit-button').on('click', function() {
                let name = $('#support_name').val();
                let phone = $('#support_phone').val();
                let email = $('#support_email').val();
                let subject = "Support";
                let message = $('#support_message').val();
                let token = 'n-e-w-s-u-p-p-o-r-t';

                if (name === '' || phone === '' || email === '' || message === '' || subject === '') {
                    $(".help-title").addClass('text-danger').text('Please fill up all the fields');
                    ['name', 'phone', 'email', 'message', 'subject'].forEach(function(field) {
                        if ($('#' + field).val() === '') {
                            $('#' + field).addClass('border border-danger');
                        } else {
                            $('#' + field).removeClass('border border-danger');
                        }
                    });
                } else if (!isValidEmail(email)) {
                    $(".help-title").addClass('text-danger').text('Invalid email format');
                    $('#email').addClass('border border-danger');
                } else {
                    $(".submit-button").prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Sending...');
                    $.ajax({
                        url: 'https://softhostit.com/base/path/v1/api/client/store',
                        type: 'GET',
                        data: {
                            'token': token,
                            'name': name,
                            'phone': phone,
                            'email': email,
                            'subject': subject,
                            'message': message,
                            'requested_from': "{{ url()->current() }}",
                        },
                        success: function(data) {
                            window.open('https://softhostit.com/client/login?email=' + data.email + '&token=' + data.token, '_blank');

                            $('#support_name').val('');
                            $('#support_phone').val('');
                            $('#support_email').val('');
                            $('#support_message').val('');
                            $(".help-title").removeClass('text-success').text('Successfully submitted!');
                            $(".submit-button").prop('disabled', false).text('Submit');
                        },
                        error: function(response) {
                            $(".help-title").addClass('text-danger').text('Something went wrong. Please try again later.');
                            $(".submit-button").prop('disabled', false).text('Submit');
                        }
                    });
                }
            });
            $('.accordion-button').on('click', function() {
                if ($(this).hasClass('animation-paused')) {
                    $(this).removeClass('animation-paused shadow-none');
                    $(this).css('animation-play-state', 'running');
                } else {
                    $(this).addClass('animation-paused shadow-none');
                    $(this).css('animation-play-state', 'paused');
                }
            });

            // Typing animation
            let helpTextLength = 0;
            let helptext = 'Online Help & support.';
            let reverseTyping = function() {
                let pgraph = $("#help-text");
                let text = pgraph.text();
                let newText = text.slice(0, text.length - 1);
                pgraph.text(newText);
                if (newText.length > 0) {
                    setTimeout(reverseTyping, 100);
                } else {
                    setTimeout(resetAndWrite, 1000); // Delay before restarting the typing animation
                }
            }

            function typing() {
                let tChar = helptext.charAt(helpTextLength++);
                let pgraph = $("#help-text");
                let charElement = document.createTextNode(tChar);
                pgraph.append(charElement);
                if (helpTextLength < helptext.length + 1) {
                    setTimeout(typing, 100);
                } else {
                    setTimeout(function() {
                        helpTextLength = 0;
                        reverseTyping();
                    }, 1000); // Delay before starting the reverse animation
                }
            }

            function resetAndWrite() {
                let paragraph = $("#help-text");
                paragraph.text(''); // Clear the paragraph
                helpTextLength = 0; // Reset helpTextLength
                typing(); // Restart the typing animation
            }

            $(document).ready(function() {
                typing();
            });
        });
    </script>
@endpush
