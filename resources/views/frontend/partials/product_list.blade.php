<div class="row">
    @foreach ($products as $product)
    <div class="col-md-4 mt-2">
        <div class="item">
            <div class="product">
                <a href="{{ route('frontend.product.item', $product->id) }}">
                    <div class="product-header">
                        <span
                            class="badge badge-success">{{ round((($product->main_price - $product->selling_price) / $product->main_price) * 100) }}%OFF</span>
                        <img class="img-fluid" src="{{ asset('storage/product/' . $product->image) }}"
                            alt="">
                        <span class="veg text-success mdi mdi-circle"></span>
                    </div>
                    <div class="product-body">
                        <h5>{{ Str::limit($product->name, 40, '...')  }}</h5>
                    </div>
                </a>
                <div class="product-footer">
                    <div class="justify-content-between align-items-center">
                        <div>
                            <p class="offer-price font-weight-bold mb-0">৳{{ $product->selling_price }}</p>
                            <small class="text-muted">
                                <del>৳{{ $product->main_price }}</del>
                            </small>
                        </div>
                        <div class="d-flex">
                            <button onclick="addToCart({{ $product->id }})" type="button" 
                                    class="btn btn-secondary btn-sm rounded-circle mx-1"
                                    data-toggle="tooltip" title="Add to Cart">
                                <i class="fa-solid fa-cart-arrow-down"></i>
                            </button>
                            <button onclick="buyNow({{ $product->id }})" type="button" 
                                    class="btn btn-primary btn-sm rounded-pill px-3"
                                    data-toggle="tooltip" title="Buy Now">
                                <i class="fa-solid fa-bag-shopping"></i> Buy
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>