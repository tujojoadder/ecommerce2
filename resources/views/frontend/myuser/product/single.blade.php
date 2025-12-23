@extends('layouts.frontend.app')
@section('title', 'Arha Shop')

@section('content')
<style>
.img-zoom-wrapper{
    display: flex;
    gap: 15px;
}
.img-zoom-container {
    position: relative;
}
.img-zoom-lens {
    position: absolute;
    border: 1px solid #d4d4d4;
    width: 40px;
    height: 40px;
    transition: none;
    pointer-events: none;
}
.img-zoom-result {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    border: 1px solid #d4d4d4;
    width: 100%;
    height: 500px;
    background-repeat: no-repeat;
    border-radius: 10px;
    display: none;
    transition: opacity 0.2s ease;
    will-change: background-position;
}
.shop-detail-right {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}
.product-info-detailed {
    margin-top: 30px;
}

/* Tabs wrapper */
.product-info-detailed .nav-pills {
    border-bottom: 2px solid #eee;
    margin-bottom: 20px;
}

/* Tab item */
.product-info-detailed .nav-pills > li {
    margin-right: 10px;
}

/* Tab link */
.product-info-detailed .nav-pills > li > a {
    border-radius: 0;
    color: #555;
    font-weight: 600;
    padding: 12px 18px;
    background: transparent;
    position: relative;
    transition: all 0.3s ease;
}

/* Hover */
.product-info-detailed .nav-pills > li > a:hover {
    color: #0d6efd;
    background: transparent;
}

/* Active tab */
.product-info-detailed .nav-pills > li.active > a,
.product-info-detailed .nav-pills > li.active > a:focus,
.product-info-detailed .nav-pills > li.active > a:hover {
    color: #0d6efd;
    background: transparent;
}

/* Active underline */
.product-info-detailed .nav-pills > li.active > a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -2px;
    width: 100%;
    height: 3px;
    background: #0d6efd;
}

/* Tab content */
.product-info-detailed .tab-content {
    background: #fff;
    border: 1px solid #eee;
    padding: 20px;
    border-radius: 6px;
}

/* Block title */
.product-info-detailed .block-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #333;
}

/* Block content */
.product-info-detailed .block-content {
    font-size: 15px;
    line-height: 1.7;
    color: #555;
}
</style>

    <!-- body  -->
    <section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('/') }}">
                        <strong><span class="mdi mdi-home"></span> Home</strong>
                    </a>
                    <span class="mdi mdi-chevron-right"></span>
                    <a href="#">{{ $item?->category?->name }}</a>
                    {{-- <span class="mdi mdi-chevron-right"></span>
                     <a href="#">Fruits</a> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="shop-single section-padding pt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="shop-detail-left">
                        <div class="shop-detail-slider">
                            <div class="favourite-icon">
                                <a class="fav-btn" href="#" title="59% OFF">
                                    <i class="mdi mdi-tag-outline"></i>
                                </a>
                            </div>

                            <div class="img-zoom-wrapper">
                                <div id="sync1">
                                    <div class="item img-zoom-container">
                                        <img src="{{ asset('storage/product/' . $item->image) }}"
                                            class="img-fluid zoom-image"
                                            alt="">
                                    </div>

                                    @foreach ($item->images as $images)
                                        <div class="item img-zoom-container">
                                            <img src="{{ asset('storage/product/subimages/' . $images->image) }}"
                                                class="img-fluid zoom-image"
                                                alt="" style="width: 100%;height: 100%">
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div id="sync2" class="owl-carousel">

                                <div class="item">
                                    <img src="{{ asset('storage/product/' . $item->image) }}" class="img-fluid img-center"
                                        alt="">
                                </div>
                                @foreach ($item->images as $images)
                                    <div class="item">
                                        <img src="{{ asset('storage/product/subimages/' . $images->image) }}"
                                            class="img-fluid img-center" alt="">
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- ONE zoom result for all images -->
                    <div id="zoom-result" class="img-zoom-result"></div>
                    <div class="shop-detail-right">
                        <span
                            class="badge badge-success">{{ round((($item->main_price - $item->selling_price) / $item->main_price) * 100) }}%OFF</span>
                        <h2>{{ $item->name }}</h2>
                        {{--    <h6>
                            <strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm
                        </h6> --}}
                        <p class="regular-price">
                            <i class="mdi mdi-tag-outline"></i> MRP : ৳{{ $item->main_price }}
                        </p>
                        <p class="offer-price mb-0">
                            Discounted price : <span class="text-success">৳{{ $item->selling_price }}</span>
                        </p>

                        {{-- Add to cart--}}
                        <button type="button" class="btn btn-secondary btn-lg" onClick="addToCart({{ $item->id }})">
                            <i class="mdi mdi-cart-outline"></i> Add To Cart
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" onClick="buyNow({{ $item->id }})">
                            <i class="mdi mdi-cart-outline"></i> Buy Now
                        </button>


                        <div class="short-description">
                            <h5>
                                Quick Overview
                                <p class="float-right">
                                    {{--   Availability:
                                    <span class="badge badge-success">In Stock</span> --}}
                                </p>
                            </h5>
                            <p>
                                <b>{{ $item->description }}
                            </p>

                        </div>

                        <h6 class="mb-3 mt-4">Why shop from Groci?</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-box">
                                    <i class="mdi mdi-truck-fast"></i>
                                    <h6 class="text-info">Free Delivery</h6>
                                    <p>Lorem ipsum dolor...</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-box">
                                    <i class="mdi mdi-basket"></i>
                                    <h6 class="text-info">100% Guarantee</h6>
                                    <p>Rorem Ipsum Dolor sit...</p>
                                </div>
                            </div>
                        </div>
                        <div class="product-info-detailed ">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills" role="tablist">
                                <li role="presentation" class="active"><a href="#description"  role="tab" data-toggle="tab">Product Details   </a></li>
                                <li role="presentation"><a href="#tags"  role="tab" data-toggle="tab">Specification </a></li>
                                <li role="presentation"><a href="#reviews"  role="tab" data-toggle="tab">reviews</a></li>
                                <li role="presentation"><a href="#tab-cust"  role="tab" data-toggle="tab">Guarantees</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="description">
                                    <div class="block-title">Product Details</div>
                                    <div class="block-content">
                                        {!! $item->information !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tags">
                                    <div class="block-title">Specification</div>
                                    <div class="block-content">
                                        {!! $item->specification ?? '' !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="reviews">
                                    <div class="block-title">reviews</div>
                                    <div class="block-content">

                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab-cust">
                                    <div class="block-title">Guarantees</div>
                                    <div class="block-content">
                                        {!! $item->guarantee ?? '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- items --}}
    <section class="product-items-slider section-padding">
        <div class="container">
            <div class="section-header">
                <h5 class="heading-design-h5">Best Offers View <span class="badge badge-info">20% OFF</span>
                    <a class="float-right text-secondary" href="#">View All</a>
                </h5>
            </div>
            <div class="owl-carousel owl-carousel-featured">
                @foreach ($products as $product)
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
                                    <h5>{{ Str::limit($product->name, 40, '...')  }} </h5>
                                    {{--  <h6><strong><span class="mdi mdi-approval"></span> Available in</strong> - 500 gm</h6> --}}

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
                @endforeach
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
function imageZoom(img, result) {
    let lens = document.createElement("DIV");
    lens.className = "img-zoom-lens";
    img.parentElement.appendChild(lens);

    let cx = result.offsetWidth / lens.offsetWidth;
    let cy = result.offsetHeight / lens.offsetHeight;

    result.style.backgroundImage = "url('" + img.src + "')";
    result.style.backgroundSize =
        (img.width * cx) + "px " + (img.height * cy) + "px";

    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);

    function moveLens(e) {
        e.preventDefault();
        let pos = getCursorPos(e);
        let x = pos.x - lens.offsetWidth / 2;
        let y = pos.y - lens.offsetHeight / 2;

        if (x > img.width - lens.offsetWidth) x = img.width - lens.offsetWidth;
        if (x < 0) x = 0;
        if (y > img.height - lens.offsetHeight) y = img.height - lens.offsetHeight;
        if (y < 0) y = 0;

        lens.style.left = x + "px";
        lens.style.top = y + "px";

        result.style.backgroundPosition =
            "-" + (x * cx) + "px -" + (y * cy) + "px";
    }

    function getCursorPos(e) {
        let a = img.getBoundingClientRect();
        let x = e.pageX - a.left;
        let y = e.pageY - a.top;
        return { x, y };
    }
}

// Apply zoom to ALL images
document.querySelectorAll('.zoom-image').forEach(img => {
    img.addEventListener('mouseenter', function () {
        let result = document.getElementById('zoom-result');
        result.style.display = "inline-block";
        result.innerHTML = ''; // reset
        imageZoom(img, result);
    });

    // যখন mouse leave করবে তখন zoom-result লুকিয়ে যাবে
    img.addEventListener('mouseleave', function () {
        let result = document.getElementById('zoom-result');
        result.style.display = "none";
        result.innerHTML = ''; // cleanup
        
        // lens remove করুন
        let lens = img.parentElement.querySelector('.img-zoom-lens');
        if (lens) {
            lens.remove();
        }
    });
});
</script>
<script>
$('.nav-pills a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $('.nav-pills li').removeClass('active');
    $(e.target).parent('li').addClass('active');
});
</script>
@endpush
