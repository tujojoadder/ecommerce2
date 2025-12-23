@extends('layouts.frontend.app')
@section('title', 'checkout - Groci')

@section('content')
<style>
    .qty-wrapper{
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    border-radius: 6px;
    width: 110px;
    overflow: hidden;
}

.qty-input{
    width: 40px;
    text-align: center;
    border: none;
    outline: none;
    font-weight: 600;
}

.qty-btn{
    width: 35px;
    height: 35px;
    border: none;
    background: #f5f5f5;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: all 0.2s ease;
}

.qty-btn:hover{
    background: #e0e0e0;
}

.qty-btn.plus{
    color: #28a745;
}

.qty-btn.minus{
    color: #dc3545;
}

</style>

    <section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> <span
                        class="mdi mdi-chevron-right"></span> <a href="#">Checkout</a>
                </div>
            </div>
        </div>
    </section>
    <section class="checkout-page section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('frontend.checkout.store') }}" method="post">
                                @csrf
                                <div class="page-content checkout-page">

                                    <h3 class="checkout-sep">1. Billing Infomations & Shipping Information</h3>
                                    <div class="box-border">
                                        <ul>
                                            <li class="row">
                                                <div class="col-sm-6">
                                                    <label for="first_name" class="required" >First Name <span class="text-danger">*</span></label>
                                                    <input class="input form-control" name="first_name" id="first_name" type="text" placeholder="Enter First Name">
                                                    @error('first_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="last_name" class="required" required>Last Name <span class="text-danger">*</span></label>
                                                    <input name="last_name" class="input form-control" id="last_name" type="text" placeholder="Enter Last Name">
                                                    @error('last_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li class="row " style="margin-top: 10px">
                                                <div class="col-sm-6">
                                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                                    <input name="phone" class="input form-control" id="phone" type="text" placeholder="Enter Phone Number" required>
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="email" class="">Email Address</label>
                                                    <input class="input form-control" name="email" id="email" placeholder="Enter Email Address" type="email">
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </li>


                                            <li class="row" style="margin-top: 10px">
                                                <div class="col-sm-6">
                                                    <label for="city" class="required">Division <span class="text-danger">*</span></label>
                                                    <select name="division_id" id="division_id" class="form-control" required>
                                                        <option value="">Select Division</option>
                                                        @foreach ($division as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('division_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="required">District <span class="text-danger">*</span></label>
                                                    <select class="input form-control" name="district_id" id="district_id" required>
                                                        <option value="">Select District</option>
                                                    </select>
                                                    @error('district_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </li>

                                            <li class="row" style="margin-top: 10px">
                                                <div class="col-sm-6">
                                                    <label class="required">Thana/Upazila <span class="text-danger">*</span></label>
                                                    <select class="input form-control" name="upazila_id" id="upazila_id" required>
                                                        <option value="">Select Thana/Upazila</option>
                                                    </select>
                                                    @error('upazila_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="postal_code" class="required">Zip/Postal Code </label>
                                                    <input class="input form-control" name="postal_code" id="postal_code" placeholder="Enter Zip/Postal Code" type="text">
                                                    @error('postal_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li class="row" style="margin-top: 10px">
                                                <div class="col-sm-12">
                                                    <label for="address" class="required" required>Address <span class="text-danger">*</span></label>
                                                    <input class="input form-control" name="address" id="address" placeholder="Enter Address" type="text">
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </li>
                                        </ul>
                                    </div>

                                    <h3 class="checkout-sep mt-4">2. Order Review</h3>
                                    <div class="box-border">
                                        <div class="table-responsive">
                                            <table class="table table-bordered  cart_summary">
                                                <thead>
                                                    <tr>
                                                        <th class="cart_product">Product</th>
                                                        <th>Description</th>
                                                        <th>Avail.</th>
                                                        <th>Unit price</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th class="action"><i class="fa fa-trash-o"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5"><strong>Sub Total</strong></td>
                                                        <td colspan="2"><strong class="cartTotal">0{{ config('company.currency_symbol') }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"><strong>Shipping Charge</strong></td>
                                                        <td colspan="2"><strong class="cartShipping">0{{ config('company.currency_symbol') }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"><strong>Grand Total</strong></td>
                                                        <td colspan="2"><strong class="cartGrandTotal">0{{ config('company.currency_symbol') }}</strong></td>
                                                    </tr>
                                                    <input type="hidden" name="sub_total" class="cartTotal_input" value="0">
                                                    <input type="hidden" name="total_discount" class="" value="0">
                                                    <input type="hidden" name="total_shipping_charge" class="cartShipping_input" value="0">
                                                    <input type="hidden" name="grand_total" class="cartGrandTotal_input" value="0">
                                                </tfoot>
                                            </table>
                                            <button type="submit" class="btn btn-secondary btn-lg">Place Order</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

                                html += '<tr>'
                                html += '<td class="cart_product">'
                                html += '<input type="hidden" name="shipping_charge" value="'+ shipping_charge +'">'
                                html += '<input type="hidden" name="product_id[]" value="'+ value.product_id +'">'
                                html += '<input type="hidden" name="qty[]" value="'+ value.quantity +'">'
                                html += '<input type="hidden" name="price[]" value="'+ value.price +'">'
                                html += '<a href="#"><img src="' + base_url + value.product.image + '"></a>'
                                html += '</td>'
                                html += '<td class="cart_description"><p class="product-name"><a href="#">'+ value.product.name +'</a></p></td>'
                                html += '<td class="cart_avail"><span class="label label-success">In stock</span></td>'
                                html += '<td class="price"><span>'+ value.price + currency +'</span></td>'
                                html += '<td class="qty">'
                                html += '  <div class="qty-wrapper">'
                                html += '      <button type="button" class="qty-btn minus" data-id="'+ value.product.id +'">−</button>'
                                html += '      <input type="text" class="qty-input cart-qty" data-id="'+ value.product.id +'" value="'+ value.quantity +'">'
                                html += '      <button type="button" class="qty-btn plus" data-id="'+ value.product.id +'">+</button>'
                                html += '  </div>'
                                html += '</td>'
                                html += '<td class="price"><span>'+ (value.price * value.quantity) + currency +'</span></td>'
                                html += '<td class="action"><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="removeCartDataCheckout('+ value.product.id +');">Delete</a></td>'
                                html += '</tr>'
                            });

                            $('.cart_summary tbody').html(html);
                            $('.cartTotal').text(total + currency);
                            $('.cartShipping').text(total_shipping + currency);
                            $('.cartGrandTotal').text((total + total_shipping) + currency);

                            $('.cartTotal_input').val(total);
                            $('.cartShipping_input').val(total_shipping);
                            $('.cartGrandTotal_input').val((total + total_shipping));
                        }
                    }
                });
            }
            $(document).on('click', '.qty-btn', function() {
                var type = $(this).data('type');
                var product_id = $(this).data('id');
                var input = $('.cart-qty[data-id="'+ product_id +'"]');
                var qty = parseInt(input.val());

                if (type == 'plus') {
                    qty++;
                } else if (type == 'minus' && qty > 1) {
                    qty--;
                }

                input.val(qty);

                // call update API
                $.ajax({
                    type: "POST",
                    url: "{{ route('frontend.addCart.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: product_id,
                        quantity: qty
                    },
                    success: function(res) {
                        if(res == 'success'){
                            addCheckoutCartData(); // refresh table
                        }
                    }
                });
            });
        function removeCartDataCheckout(product_id){
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
        $(document).ready(function(){
            addCheckoutCartData();
        });
        </script>
        <script>
            $("#division_id").on('change', function(){
                var division_id = $(this).val();
                url = "/get/district/" + division_id;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data){
                       var html = '';
                       html += '<option>Select District</option>';
                       $.each(data, function(index, value){
                            html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                       });
                       $("#district_id").html(html);
                    }
                })
            });
            $("#division_id, #district_id").on('change',function() {
                addCheckoutCartData();
                var district_id = $("#district_id").val();
                url = "/get/upazila/" + district_id;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data){
                       var html = '';
                       html += '<option>Select Thana/Upazila</option>';
                       $.each(data, function(index, value){
                            html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                       });
                       $("#upazila_id").html(html);
                    }
                })
            });
        </script>
    @endpush

