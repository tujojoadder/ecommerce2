<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/common.css') }}" />
    <link rel="icon" href="{{ asset('frontend/assets/images/logo/logo icon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />

    <!-- OWL Slider CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- OWL Slider CSS -->

    <!-- Flip-clock CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/flip-clock.css') }}" />
    <!-- Flip-clock CSS -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- flip-clock cdn -->
    <script src="{{ asset('frontend/assets/js/flip-clock.js') }}"></script>
    <!-- flip-clock cdn -->

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
                            // ✅ Add to total
                            total += (parseFloat(value.price) * parseInt(value.quantity));
                            html += '<div class="cart-list-product">';

                            html +=
                                '<a class="float-right remove-cart" href="javascript:void(0)" ' +
                                'onclick="removeCartData(' + value.product.id + ')">' +
                                '<i class="fas fa-trash remove-icon" style="color:red"></i></a>';

                            html +=
                                '<img class="img-fluid" style="height:80px; object-fit:contain" ' +
                                'src="' + base_url + value.product.image + '" ' +
                                'alt="' + value.product.name + '">';

                            // 🔖 Optional discount badge
                            if (value.product.discount) {
                                html += '<span class="badge badge-success">' + value.product.discount +
                                    '% OFF</span>';
                            }

                            html += '<h5><a href="#">' + strLimit(value.product.name, 30) + '</a></h5>';
                            html += '<h6><strong>Quantity:</strong> ' + value.quantity + '</h6>';
                            html += '<p class="offer-price mb-0">' + (value.price * value.quantity)
                                .toFixed(2) + ' ' + currency + '</p>';


                            // Quantity Update Section
                            html +=
                                '<div class="quantity-control" style="display: flex; align-items: center; gap: 10px; margin: 10px 0;">';
                            html +=
                                '<button class="btn btn-sm btn-secondary" onclick="updateQuantity(' +
                                value.product.id + ', -1)">-</button>';
                            html +=
                                '<input type="number"  class="form-control text-center" id="quantity_' +
                                value.product.id + '" value="' + value.quantity +
                                '" min="1" max="15" style="width: 60px;" onchange="updateQuantityInput(' +
                                value
                                .product.id + ', this.value)">';
                            html +=
                                '<button class="btn btn-sm btn-secondary" onclick="updateQuantity(' +
                                value.product.id + ', 1)">+</button>';
                            html += '</div>';



                            html += '</div>';

                        });

                        $('.minicart-items').html(html);

                        $('.cartTotalAmount').text(total.toFixed(2) + ' ' + currency);
                    } else {
                        $('.minicart-items').html('<li>No items in cart</li>');
                        $('.cartTotalAmount').text('0.00 ' + currency);
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

    @stack('scripts')
</body>

</html>
