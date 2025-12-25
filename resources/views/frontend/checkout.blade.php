@extends('layouts.frontend.app')
@section('title', 'checkout - Groci')

@section('content')
    <div class="profile-cart">
        <!-- Header Short Banner Start -->
        <div class="profile-banner primary7">
            <h2 class="heading2 text-center">Cart Page</h2>
        </div>
        <!-- Header Short Banner End -->

        <!-- Cart Section Start -->
        <div class="container">
            <!-- Section padding -->
            <div class="square"></div>
            <h4 class="heading3 mb-40">Selected Item : 0</h4>

            <div class="mb-20 row cart-page">
                <div class="col-md-8">
                    <div class="cart_table">

                    </div>

                    <div class="more">
                        Do you want to add more?
                        <a href="/">Click Here</a>
                    </div>
                </div>
                <div class="cart-info col-md-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="heading4 primary">Total</h4>
                        <h4 class="heading5 mr-10">
                        </h4>
                    </div>
                    <div class="d-flex mb-10 align-items-center justify-content-between">
                        <h4 class="heading4 primary">Delivery Charge</h4>
                        <h4 class="heading5 mr-10"></h4>
                    </div>

                    <div class="divider"></div>

                    <div class="d-flex mt-20 align-items-center justify-content-between">
                        <h4 class="heading4 primary">Payable Amount</h4>
                        <h4 class="heading5 mr-10"></h4>
                    </div>

                    <div class="mt-50 preferred">Preferred Delivery Timings</div>

                    <!-- Delivery Time -->
                    <div class="delivery-time mt-30">
                        <div class="heading6 mb-20">
                            When would you like your delivery?
                        </div>

                        <div class="d-flex gap-3 flex-wrap mt20 justify-content-between">
                            <div class="left d-flex justify-content-center align-items-center">
                                <div class="date">
                                    <input type="date" data-date="" data-date-format="DD MMMM YYYY"
                                        value="2023-02-25" />
                                </div>
                            </div>
                            <div class="right d-flex justify-content-center align-items-center">
                                <div class="date">
                                    <input type="text" name="daterange" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delivery Time -->

                    <div class="confirmation pt-40">
                        <h5 class="heading6 text-center">
                            Are you sure you want to order?
                        </h5>

                        <a href="payment.html">
                            <button class="button-1 mt-20">Place Order</button>
                        </a>

                        <div class="paragraph mt-20">
                            By clicking/tapping Place Order, I agree to SolPlant
                            <a href="#">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Section End -->

        <!-- Section padding -->
        <div class="square"></div>
    </div>

@endsection


@push('scripts')
    <script>
        function addCheckoutCartData() {
            var url = "{{ route('frontend.addCart.get.data') }}";
            var currency = "{{ config('company.currency_symbol') }}";
            var base_url = "{{ asset('storage/product') }}/";

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data) {
                    $('.cartCount').text(data.length);

                    var html = '';
                    var total = 0;
                    var total_shipping = 0;

                    // Update item count
                    $('h4.heading3.mb-40').text('Selected Item : ' + data.length);

                    if (data.length != 0) {
                        $.each(data, function(index, value) {
                            total += (parseFloat(value.price) * parseInt(value.quantity));

                            var shipping_charge = 0;
                            var district_id = $("#district_id").val();

                            if (district_id == 47) {
                                shipping_charge = value.product.shipping_in_dhaka || 0;
                            } else {
                                shipping_charge = value.product.shipping_out_dhaka || 0;
                            }

                            total_shipping += (shipping_charge * parseInt(value.quantity));

                            // Build cart row HTML matching the Blade template structure
                            html +=
                                '<div class="d-flex justify-content-between align-items-center cart-row">';

                            // Item 1: Product Image and Info
                            html += '<div class="item1">';
                            html += '<div class="d-flex">';
                            html += '<img style="width:67px;height:77px;" src="' + base_url + value
                                .product.image +
                                '" alt="" class="img-fluid" />';
                            html += '<div class="ml-20">';
                            html += '<h4 class="heading4 mb-20">' + value.product.name + '</h4>';
                            html += '<h3 class="heading3">' + value.price +
                                ' {{ config('company.currency_symbol') }}' + '</h3>';

                            html += '</div>';
                            html += '</div>';
                            html += '</div>';

                            // Item 2: Quantity Controls
                            html += '<div class="item2">';
                            html += '<div class="d-flex">';
                            html += '<div class="d-flex quantity-wrapper align-items-center">';
                            html += '<div class="d-flex quantity">';
                            html += '<span class="quantity-down" data-id="' + value.product.id +
                                '"><i class="fa-solid fa-minus"></i></span>';
                            html += '<input type="number" class="cart-qty" data-id="' + value.product
                                .id + '" min="1" max="100" step="1" value="' + value.quantity +
                                '" readonly />';
                            html += '<span class="quantity-up" data-id="' + value.product.id +
                                '"><i class="fa-solid fa-plus"></i></span>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';

                            // Item 3: Total Price
                            html += '<div class="item3">';
                            html += '<h3 class="heading3 main-price">' +
                                ' {{ config('company.currency_symbol') }}' + (value.price * value
                                    .quantity) + '</h3>';
                            html += '</div>';

                            // Item 4: Remove Button
                            html += '<div class="item4">';
                            html +=
                                '<i class="fa-regular fa-circle-xmark" onclick="removeCartDataCheckout(' +
                                value.product.id + ');" style="cursor: pointer;"></i>';
                            html += '</div>';

                            html += '</div>';
                        });

                        $('.cart_table').html(html);

                        // Update cart summary
                        $('.total-price').text(total);
                        $('.cart-info .heading5').eq(0).html('<span class="total-price">' + total + '</span>');
                        $('.cart-info .heading5').eq(1).text(total_shipping +
                            ' {{ config('company.currency_symbol') }}');
                        $('.cart-info .heading5').eq(2).text((total + total_shipping) +
                            ' {{ config('company.currency_symbol') }}');
                    } else {
                        $('.cart_table').html('<div class="text-center p-4"><p>Your cart is empty</p></div>');
                        $('.total-price').text('0');
                    }
                }
            });
        }

        // Quantity increase button
        $(document).on('click', '.quantity-up', function() {
            var product_id = $(this).data('id');
            var input = $('.cart-qty[data-id="' + product_id + '"]');
            var qty = parseInt(input.val());

            if (qty < 100) {
                qty++;
                input.val(qty);

                // Update cart via AJAX
                updateCartQuantity(product_id, qty);
            }
        });

        // Quantity decrease button
        $(document).on('click', '.quantity-down', function() {
            var product_id = $(this).data('id');
            var input = $('.cart-qty[data-id="' + product_id + '"]');
            var qty = parseInt(input.val());

            if (qty > 1) {
                qty--;
                input.val(qty);

                // Update cart via AJAX
                updateCartQuantity(product_id, qty);
            }
        });

        // Function to update cart quantity
        function updateCartQuantity(product_id, qty) {
            $.ajax({
                type: "POST",
                url: "{{ route('frontend.addCart.update') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: product_id,
                    quantity: qty
                },
                success: function(res) {
                    if (res == 'success') {
                        addCheckoutCartData(); // Refresh cart
                        addCartData();
                    }
                }
            });
        }

        // Remove item from cart
        function removeCartDataCheckout(product_id) {
            url = "{{ route('frontend.addCart.destroy', ':product_id') }}";
            url = url.replace(':product_id', product_id);
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    addCheckoutCartData();
                }
            });
        }

        // Division change handler
        $("#division_id").on('change', function() {
            var division_id = $(this).val();
            url = "/get/district/" + division_id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    var html = '';
                    html += '<option>Select District</option>';
                    $.each(data, function(index, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $("#district_id").html(html);
                }
            })
        });

        // Division and District change handler
        $("#division_id, #district_id").on('change', function() {
            addCheckoutCartData();
            var district_id = $("#district_id").val();
            url = "/get/upazila/" + district_id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    var html = '';
                    html += '<option>Select Thana/Upazila</option>';
                    $.each(data, function(index, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $("#upazila_id").html(html);
                }
            })
        });

        // Initialize cart on page load
        $(document).ready(function() {
            addCheckoutCartData();
        });
    </script>
@endpush
