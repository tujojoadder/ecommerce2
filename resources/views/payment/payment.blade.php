<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhisab Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.cdnfonts.com/css/solaimanlipi" rel="stylesheet">


    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgb(0, 0, 34);
            font-size: 0.8rem;
            font-family: 'SolaimanLipi', sans-serif;

        }

        .card {
            /* max-width: 1000px;
      margin: 2vh; */
        }

        .card-top {
            padding: 0.7rem 5rem;
        }

        .card-top a {
            float: left;
            margin-top: 0.7rem;
        }

        #logo {
            font-family: 'Dancing Script';
            font-weight: bold;
            font-size: 35px;
        }

        .card-body {
            padding: 0 5rem 5rem 5rem;
            background-image: url("https://i.imgur.com/4bg1e6u.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        @media(max-width:768px) {
            .card-body {
                padding: 0 0;
                background-image: url("https://i.imgur.com/4bg1e6u.jpg");
                background-size: cover;
                background-repeat: no-repeat;
            }

            .card-top {
                padding: 0.7rem 1rem;
            }
        }

        @media(max-width:576px) {
            .container {
                padding: 0px;
            }

            .floatingButton img {
                width: 57px !important;
                margin-right: -70px;
            }
        }

        .row {
            margin: 0;
        }

        .upper {
            padding: 1rem 0;
            justify-content: space-evenly;
        }

        #three {
            border-radius: 1rem;
            width: 22px;
            height: 22px;
            margin-right: 3px;
            border: 1px solid blue;
            text-align: center;
            display: inline-block;
        }

        #payment {
            margin: 0;
            color: blue;
        }

        .icons {
            margin-left: auto;
        }

        form span {
            color: rgb(179, 179, 179);
        }

        form {
            padding: 2vh 0;
        }

        input {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1vh;
            margin-bottom: 4vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247);
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        .header {
            font-size: 1.3rem;
            color: #12a00a;
            font-weight: 600;
        }

        .left {
            background-color: #ffffff;
            padding: 2vh;
        }

        .left img {
            width: 2rem;
        }

        .left .col-4 {
            padding-left: 0;
        }

        .right .item {
            padding: 0.3rem 0;
        }

        .right {
            background-color: #ffffff;
            padding: 2vh;
        }

        .col-8 {
            padding: 0 1vh;
        }

        .lower {
            line-height: 2;
        }

        a {
            color: black;
        }

        a:hover {
            color: black;
            text-decoration: none;
        }

        input[type=checkbox] {
            width: unset;
            margin-bottom: unset;
        }

        #cvv {
            background-image: linear-gradient(to left, rgba(255, 255, 255, 0.575), rgba(255, 255, 255, 0.541)), url("https://img.icons8.com/material-outlined/24/000000/help.png");
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: center;
        }

        .btn {
            width: 100%;
            padding: 10px;
            font-weight: 700;
            font-size: 20px;
        }

        #cvv:hover {}

        .payment-method {
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 4px;
            transition: 0.3s;
        }

        .payment-method1.selected {
            border: 2px solid #fdeec1;
            background: #fdeec1;
        }

        .payment-method2.selected {
            border: 2px solid #295cab;
            background: #295cab;
        }

        .payment-method:hover {
            border: 2px solid #12a00a;
        }

        .col-12.method-top-margin {
            padding: 0px;
            margin-top: 12px;
        }

        .btn-success {
            background-color: #7a0282;
            border-color: #7a0282;
            transition: 0.3s;
        }

        .check-icon,
        .check-icon2 {
            display: none;
        }

        .check-icon.selected,
        .check-icon2.selected {
            display: initial;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 px-0">
                <div class="card">
                    <div class="card-top border-bottom text-center">
                        <span id="logo" style="color: #12a00a;"></span> <br>
                        <span style="font-size: 24px; color: #1565c0;">আপনার সার্ভিস টি নিরবিচ্ছিন্ন ভাবে ব্যবহার করতে আপনার মাসিক সার্ভার বিল পরিশোধ করুন </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7 pt-3">

                                <div class="left border">
                                    <div class="row">
                                        <div class="col-12 px-0 text-left">
                                            <span class="header text-center">কিভাবে পেমেন্ট করবেন</span>
                                        </div>
                                    </div>
                                    <form>
                                        <iframe style=" height: 300px;width: 100%;border-radius: 10px;" src="https://www.youtube.com/embed/-1pOQks5gDg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 pt-3 mb-5">
                                <div class="right border">
                                    <form action="{{ route('payment.manage') }}" method="POST">
                                        @csrf
                                        <div class="header" style="border-bottom: 1px solid #dee2e6; text-align: center; padding-bottom: 12px;">পেমেন্ট অপশন সিলেক্ট করুন</div>
                                        <div class="row item">
                                            <div class="col-12 align-self-center method-top-margin">
                                                <div class="form-group">
                                                    <input disabled type="radio" name="pm" id="img1" class="d-none method imgbgchk" value="bkash" />
                                                    <label class="payment-method payment-method1" for="img1">
                                                        <img style="width: 34%; text-align: center; margin: 10px;" src="https://freelogopng.com/images/all_img/1656227518bkash-logo-png.png" alt="Soft Host IT bKash Payment" />
                                                        <i style="position: absolute; right: 10px; margin-top: 18px; font-size: 40px; color: #e2136e;" class="check-icon fa fa-check-circle" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="radio" name="pm" id="img2" class="d-none method1 imgbgchk" value="ssl" />
                                                    <label class="payment-method payment-method2" for="img2">
                                                        <img style="width: 80%; text-align: center; margin: 10px;" src="https://sslcommerz.com/wp-content/uploads/2021/11/logo.png" alt="Soft Host IT SSL Payment" />
                                                        <i style="position: absolute; right: 10px; margin-top: 18px; font-size: 40px; color: #fff;" class="check-icon2 fa fa-check-circle" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="submit" name="payment" class="btn btn-success">পেমেন্ট করুন</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
            <script src="https://support.softhostit.com/public/assets/chat.plugin.minified.js"></script>
            <script>
                $('.method').on('change', function() {
                    $('.payment-method2').removeClass('selected');
                    $('.check-icon2').removeClass('selected');
                    $('.payment-method1').addClass('selected');
                    $('.check-icon').addClass('selected');
                });
                $('.method1').on('change', function() {
                    $('.payment-method1').removeClass('selected');
                    $('.check-icon').removeClass('selected');
                    $('.payment-method2').addClass('selected');
                    $('.check-icon2').addClass('selected');
                });
                $(document).ready(function() {
                    $("#img2").trigger('click');
                })
            </script>
        </div>
    </div>
</body>

</html>
