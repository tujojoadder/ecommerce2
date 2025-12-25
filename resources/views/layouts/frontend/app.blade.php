<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ config('company.favicon') }}" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/common.css') }}" />

    <!-- Font-Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Flat Icon CDN -->
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />

    <!-- OWL Carousel CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="./css/swiper-bundle.min.css" />

    <!-- Flip-clock CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/flip-clock.css') }}" />




    <style>
        #time .container {
            background-image: url("{{ asset('frontend/images/time.jpeg') }}") !important;
            ;
            background-repeat: no-repeat;
            background-position: center;
            padding: 50px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #subscribe .subscribe-body .join-newsletter {
            background-image: url("{{ asset('frontend/images/subscribe1.jpeg') }}") !important;
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .short-banner.profile-banner,
        .profile-banner.profile-banner {
            background-image: url("{{ asset('frontend/images/checkout.png') }}") !important;
        }
    </style>

    <!-- jQuery CDN -->
    <script src="./js/vendor/jquery-3.6.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Flip-clock JS -->
    <script src="{{ asset('frontend/assets/js/flip-clock.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Moment Js CDN -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />

    <title>SolPlant</title>
    @stack('styles')
</head>


<body>


    @include('layouts.frontend.header')

    @yield('content')

    @include('layouts.frontend.footer')


    {{-- js script --}}
    <script>
        function strLimit(text, limit = 30) {
            return text.length > limit ? text.slice(0, limit) + '...' : text;
        }

        function addCartData() {
            var url = "{{ route('frontend.addCart.get.data') }}";
            var currency = '৳';
            var base_url = "{{ asset('storage/product/') }}/";

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $('.cartCount').text(data.length);

                    var html = '';
                    var total = 0;

                    if (data.length != 0) {
                        $.each(data, function(index, value) {
                            // Add to total
                            total += (parseFloat(value.price) * parseInt(value.quantity));

                            html += '<li>';
                            html += '<a href="javascript:void(0)">';

                            // Product Image
                            html += '<div class="part-img">';
                            html += '<img src="' + base_url + value.product.image + '" alt="' + value
                                .product.name + '" />';
                            html += '</div>';

                            // Product Text Info
                            html += '<div class="part-txt">';
                            html += '<span class="heading5">' + strLimit(value.product.name, 30) +
                                '</span>';

                            // Quantity and Price with Controls
                            html += '<div style="display: flex; align-items: center; gap: 8px;">';

                            // Minus Button
                            html += '<button class="qty-btn" onclick="updateQuantity(' + value.product
                                .id +
                                ', -1)" style="width: 20px; height: 20px; border: 1px solid #ddd; background: #fff; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center;">-</button>';

                            // Quantity Input Field
                            html += '<input type="number" id="quantity_' + value.product.id +
                                '" value="' + value.quantity +
                                '" min="1" max="15" style="width: 40px; text-align: center; border: 1px solid #ddd; border-radius: 4px;" onchange="updateQuantityInput(' +
                                value.product.id + ', this.value)" />';

                            // Plus Button
                            html += '<button class="qty-btn" onclick="updateQuantity(' + value.product
                                .id +
                                ', 1)" style="width: 20px; height: 20px; border: 1px solid #ddd; background: #fff; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center;">+</button>';

                            html += (value.quantity) +
                                '<i class="fa-solid fa-xmark"></i> {{ config('company.currency_symbol') }}' +
                                (value
                                    .price * value
                                    .quantity).toFixed(2);
                            html += '</div>';

                            html += '</div>';

                            html += '</a>';

                            // Delete Button
                            html += '<button class="delete-btn" onclick="removeCartData(' + value
                                .product.id + ')">';
                            html += '<i class="fa-solid fa-trash-can"></i>';
                            html += '</button>';

                            html += '</li>';
                        });

                        $('.minicart-items').html(html);
                        $('.cartTotalAmount').text(total.toFixed(2) + ' ' + currency);

                        //  Top items number এবং dollar update
                        $('.top-items-number p').text(data.length + ' Items');
                        $('.top-item-dollar p').text(currency + total.toFixed(2));
                        //qty (header)
                        $('.qty').text(data.length);

                    } else {
                        $('.minicart-items').html('<li>No items in cart</li>');
                        $('.cartTotalAmount').text('0.00 ' + currency);
                        //  Empty cart এর জন্য
                        $('.top-items-number p').text('0 Items');
                        $('.top-item-dollar p').text(currency + '0.00');
                    }
                }
            });
        }


        function removeCartData(product_id) {
            url = "{{ route('frontend.addCart.destroy', ':product_id') }}";
            url = url.replace(':product_id', product_id);
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    addCartData();
                }
            });
        }
        $(document).ready(function() {
            addCartData();
        });

        function addToCart(product_id) {
            openCart();
            var qty = $("#qty1").val() || 1;
            var url = "{{ route('frontend.addCart.store') }}";
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    product_id: product_id,
                    qty: qty,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                success: function(data) {
                    if (data[0] == 'success') {
                        // Swal.fire({
                        //     title: '<strong>Added to Cart</strong>',
                        //     html: `
                    //         <div style="position: relative; margin: 20px 0;">
                    //             <img src="{{ asset('frontend/assets/img/grocery.gif') }}" 
                    //                 style="width: 120px; height: 120px;"
                    //                 alt="Cart animation">
                    //             <div style="margin-top: 15px; font-size: 16px; color: #28a745;font-weight:900">
                    //                 ✓ Product added successfully!
                    //             </div>
                    //         </div>
                    //     `,
                        //     showConfirmButton: false,
                        //     position: 'center',
                        //     timer: 2000,
                        //     backdrop: true,
                        //     customClass: {
                        //         popup: 'swal-custom-popup'
                        //     }
                        // });
                        addCartData();
                    } else if (data[0] == 'increase') {
                        // Swal.fire({
                        //     title: '<strong>Added to Cart</strong>',
                        //     html: `
                    //         <div style="position: relative; margin: 20px 0;">
                    //             <img src="{{ asset('frontend/assets/img/grocery.gif') }}" 
                    //                 style="width: 120px; height: 120px;"
                    //                 alt="Cart animation">
                    //             <div style="margin-top: 15px; font-size: 16px; color: #28a745;font-weight:900">
                    //                 ✓ Product Quantity Increased!
                    //             </div>
                    //         </div>
                    //     `,
                        //     showConfirmButton: false,
                        //     position: 'center',
                        //     timer: 2000,
                        //     backdrop: true,
                        //     customClass: {
                        //         popup: 'swal-custom-popup'
                        //     }
                        // });
                        addCartData();
                    } else {
                        Swal.fire({
                            title: 'Sorry',
                            text: "Something Wrong.",
                            icon: 'warning',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                }
            });
        }

        function buyNow(product_id) {

            var qty = $("#qty1").val() || 1;
            var url = "{{ route('frontend.addCart.store') }}";
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    product_id: product_id,
                    qty: qty,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                success: function(data) {
                    if (data[0] == 'success') {
                        Swal.fire({
                            title: '<strong>Added to Cart</strong>',
                            html: `
                                <div style="position: relative; margin: 20px 0;">
                                    <img src="{{ asset('frontend/assets/img/grocery.gif') }}" 
                                        style="width: 120px; height: 120px;"
                                        alt="Cart animation">
                                    <div style="margin-top: 15px; font-size: 16px; color: #28a745;font-weight:900">
                                        ✓ Product added successfully!
                                    </div>
                                </div>
                            `,
                            showConfirmButton: false,
                            position: 'center',
                            timer: 2000,
                            backdrop: true,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                        addCartData();
                        window.location.href = "{{ route('frontend.checkout.index') }}";
                    } else if (data[0] == 'increase') {
                        Swal.fire({
                            title: '<strong>Added to Cart</strong>',
                            html: `
                                <div style="position: relative; margin: 20px 0;">
                                    <img src="{{ asset('frontend/assets/img/grocery.gif') }}" 
                                        style="width: 120px; height: 120px;"
                                        alt="Cart animation">
                                    <div style="margin-top: 15px; font-size: 16px; color: #28a745;font-weight:900">
                                        ✓ Product Quantity Increased!
                                    </div>
                                </div>
                            `,
                            showConfirmButton: false,
                            position: 'center',
                            timer: 2000,
                            backdrop: true,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                        addCartData();
                        window.location.href = "{{ route('frontend.checkout.index') }}";
                    } else {
                        Swal.fire({
                            title: 'Sorry',
                            text: "Something Wrong.",
                            icon: 'warning',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                }
            });
        }


        /* update */
        // Quantity বাড়ানো/কমানোর জন্য
        function updateQuantity(product_id, change) {
            var input = document.getElementById('quantity_' + product_id);
            var currentQty = parseInt(input.value);
            var newQty = currentQty + change;

            if (newQty < 1) {
                newQty = 1; // Minimum quantity 1
            }
            if (newQty > 15) {
                newQty = 15; // Maximum quantity 15
                Swal.fire({
                    title: 'Limit Reached',
                    text: "Maximum 15 quantity allowed.",
                    icon: 'warning',
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                });
                return;
            }
            input.value = newQty;
            updateCartQuantity(product_id, newQty);
        }

        // Input field থেকে quantity update
        function updateQuantityInput(product_id, quantity) {
            var qty = parseInt(quantity);

            if (qty < 1 || isNaN(qty)) {
                qty = 1;
                document.getElementById('quantity_' + product_id).value = 1;
            }
            if (qty > 15) {
                qty = 15;
                Swal.fire({
                    title: 'Limit Reached',
                    text: "Maximum 15 quantity allowed.",
                    icon: 'warning',
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                });
            }


            updateCartQuantity(product_id, qty);
        }

        // 🔄 Server-এ quantity update করা
        function updateCartQuantity(product_id, quantity) {
            var url = "{{ route('frontend.addCart.update') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data == 'success') {
                        addCartData(); // Cart data refresh করা
                        // Swal.fire({
                        //     title: 'Updated',
                        //     text: "Quantity updated successfully.",
                        //     icon: 'success',
                        //     toast: true,
                        //     position: "top-end",
                        //     showConfirmButton: false,
                        //     timer: 2000,
                        //     timerProgressBar: true,
                        // });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Failed to update quantity.",
                            icon: 'error',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    }
                }
            });
        }
    </script>
    <script>
        function quickView(id) {
            var currency = "{{ config('company.currency_symbol') }}";
            var base_url = "{{ asset('storage/product') }}/";

            $("#popup-overlay").addClass("active");
            var url = "{{ route('get.product2', ':id') }}";

            url = url.replace(':id', id);

            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    var product = data.product;
                    var cart = data.cartData;
                    console.log('quantity' + cart);
                    var name = product?.name || '';
                    var main_price = product?.main_price || 0;
                    var selling = product?.selling_price || 0;
                    var description = product?.description || '';
                    var category = product?.category?.name || 'N/A';
                    var quantity = cart?.quantity || 1;

                    var image = product?.image;

                    // Populate the popup
                    var $popup = $("#popup-overlay");

                    $popup.find(".content .heading3").text(name);
                    $popup.find(".content .price .line-through").text(`${main_price}`);
                    $popup.find(".content .price span:not(.line-through)").text(`${selling}`);
                    $popup.find(".content .paragraph").text(description);
                    $popup.find(".content .heading4").text(`Category: ${category}`);
                    $popup.find(".quantity-wrapper .quantity input").val(quantity);
                    $popup.find(".img-wrapper img").attr("src", base_url + image);

                    // Show popup
                    $popup.addClass("active");

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
