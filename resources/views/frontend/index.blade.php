@extends('layouts.frontend.app')
@section('content')
    <!-- slider section -->
    <section id="hero">
        <div class="hero-image owl-carousel owl-theme">
            @foreach ($sliders as $slider)
                <div>
                    <img src="{{ asset('storage/slider/' . $slider->image) }}" alt="slider">

                </div>
            @endforeach
        </div>

        <div class="hero-text-wrapper container">
            <div class="hero-card">
                <div class="hero-text">
                    <p class="heading-1">Summer Collection 2023</p>
                    <p class="heading-2">Plants Gonna Make People Happy</p>
                    <div class="hero-button">
                        <a href="/">
                            <button class="button-1">Shop Now</button>
                        </a>
                        <button class="button-2">
                            <a href="/">Explore Now</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- selling section-->
    <section id="selling">
        <div class="container">
            <div class="selling-top">
                <div class="selling-img marg-d-30">
                    <div class="selling-wrap">
                        <img src="{{ asset('frontend/assets/images/home/selling/best-selling.png') }}" alt=""
                            class="" />
                        <div class="selling-card-text-1">
                            <p class="heading-3">Get 50% Off</p>
                            <p class="heading-4">Best Selling</p>
                            <button class="button-1">
                                <a href="/">Shop Now</a>
                            </button>
                        </div>
                        <div class="selling-overlay"></div>
                    </div>
                </div>

                <div class="selling-duo">
                    <div class="selling-img marg-30">
                        <div class="selling-wrap">
                            <img src="{{ asset('frontend/assets/images/home/selling/image.png') }}" class=""
                                alt="" />
                            <div class="selling-card-text-2">
                                <p class="heading-4">Big Saving</p>
                                <p class="heading-3">Flat 50% Off</p>
                            </div>
                            <div class="selling-overlay"></div>
                        </div>
                    </div>

                    <div class="selling-img">
                        <div class="selling-wrap">
                            <img src="{{ asset('frontend/assets/images/home/selling/summer-pots.png') }}" alt="" />
                            <div class="selling-card-text-3">
                                <p class="heading-5">Summer's Pots</p>
                            </div>
                            <div class="selling-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="selling-bottom">
                <div class="selling-duo">
                    <div class="selling-img marg-30">
                        <div class="selling-wrap">
                            <img src="{{ asset('frontend/assets/images/home/selling/quality-products.png') }}"
                                alt="" />
                            <div class="selling-card-text-4">
                                <p class="heading-5">Quality Product</p>
                            </div>
                            <div class="selling-overlay"></div>
                        </div>
                    </div>
                    <div class="selling-img marg-d-30">
                        <div class="selling-wrap">
                            <img src="{{ asset('frontend/assets/images/home/selling/green-plants.png') }}" alt="" />
                            <div class="selling-card-text-5">
                                <p class="heading-4">Green Plants</p>
                                <p class="heading-3">Flat 50% Off</p>
                            </div>
                            <div class="selling-overlay"></div>
                        </div>
                    </div>
                </div>
                <div class="selling-img">
                    <div class="selling-wrap">
                        <img src="{{ asset('frontend/assets/images/home/selling/popular.png') }}" class=""
                            alt="" />
                        <div class="selling-card-text-6">
                            <p class="heading-4">Popular</p>
                            <p class="heading-3">Collection of Cactus</p>
                            <button class="button-1">
                                <a href="/">Shop Now</a>
                            </button>
                        </div>
                        <div class="selling-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- new arrival --}}
    <section id="arrival">
        <div class="container">
            <p class="section-heading">New Arrival</p>

            <div class="arrival-head-list filters-button-group heading-8 d-flex justify-content-center">
                <button class="card-type is-checked active" data-filter="*">
                    All
                </button>
                <button class="card-type" data-filter=".top-rated">Best Selling Product</button>
                <button class="card-type" data-filter=".trending">Special Product</button>
                <button class="card-type" data-filter=".best-seller">
                    New Arrival Product
                </button>
            </div>

            <div class="item-details row">

                @foreach ($products->where('is_bestsell', 1) as $product)
                    <div class="col-sm-6 col-lg-4 col-xl-3 item top-rated">
                        <div class="product-card">

                            <div class="img-wrapper mb-20">
                                <a href="/">
                                    <img style="width:320ppx; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid" />
                                </a>
                                <a href="/">
                                    <img style="width:320ppx; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid hovered-img" />
                                </a>
                                <div class="overlay">
                                    <div class="icon-wrapper">
                                        <div class="tooltip-wrapper">
                                            <div onclick="openPopup()" class="icon">
                                                <i class="fa-regular fa-eye"></i>
                                            </div>
                                            <div class="my-tooltip">Quick View</div>
                                        </div>
                                        <div class="tooltip-wrapper">
                                            <div onclick="openCart()" class="icon">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </div>
                                            <div class="my-tooltip">Add to Cart</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="best-card-text">
                                {{--    <div class="best-card-star">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                </div> --}}

                                <p class="card-name">
                                    <a href="/">{{ $product->name }}</a>
                                </p>
                                <p class="card-price">
                                    {{ $product->selling_price }}৳ -
                                    <span class="text-decoration-line-through"> {{ $product->main_price }}৳ </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach ($products->where('is_special', 1) as $product)
                    <div class="col-sm-6 col-lg-4 col-xl-3 item best-seller">
                        <div class="product-card">
                            <div class="img-wrapper mb-20">
                                <a href="/">
                                    <img style="width:320ppx; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid" />
                                </a>
                                <a href="/">
                                    <img style="width:320ppx; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid hovered-img" />
                                </a>
                                <div class="overlay">
                                    <div class="icon-wrapper">
                                        <div class="tooltip-wrapper">
                                            <div onclick="openPopup()" class="icon">
                                                <i class="fa-regular fa-eye"></i>
                                            </div>
                                            <div class="my-tooltip">Quick View</div>
                                        </div>
                                        <div class="tooltip-wrapper">
                                            <div onclick="openCart()" class="icon">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </div>
                                            <div class="my-tooltip">Add to Cart</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="best-card-text">
                                {{--    <div class="best-card-star">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                </div> --}}

                                <p class="card-name">
                                    <a href="/">Curabitur a Purus</a>
                                </p>
                                <p class="card-price">
                                    {{ $product->selling_price }}৳ -
                                    <span class="text-decoration-line-through">{{ $product->main_price }}৳ </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach ($products->where('is_newarrival', 1) as $product)
                    <div class="col-sm-6 col-lg-4 col-xl-3 item trending">
                        <div class="product-card">
                            <div class="img-wrapper mb-20">
                                <a href="/">
                                    <img style="width:320ppx; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid" />
                                </a>
                                <a href="/">
                                    <img style="width:320ppx; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid hovered-img" />
                                </a>
                                <div class="overlay">
                                    <div class="icon-wrapper">
                                        <div class="tooltip-wrapper">
                                            <div onclick="openPopup()" class="icon">
                                                <i class="fa-regular fa-eye"></i>
                                            </div>
                                            <div class="my-tooltip">Quick View</div>
                                        </div>
                                        <div class="tooltip-wrapper">
                                            <div onclick="openCart()" class="icon">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </div>
                                            <div class="my-tooltip">Add to Cart</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="best-card-text">
                                {{--   <div class="best-card-star">
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                    <i class="fa-sharp fa-solid fa-star"></i>
                                </div> --}}

                                <p class="card-name">
                                    <a href="/">Convallis Quam Sit</a>
                                </p>
                                <p class="card-price">
                                    {{ $product->selling_price }}৳ -
                                    <span class="text-decoration-line-through">{{ $product->main_price }}৳ /span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- --------------------------------------------- -->
        </div>
        <div class="arrival-button">
            <button class="button-1">
                <a href="/">See All Products</a>
            </button>
        </div>
    </section>
    <div class="square"></div>
    {{-- time section --}}
    <section id="time">
        <div class="container">
            <div>
                <p class="heading-9">Here's The Skinny: Plants Bring People Joy</p>

                <div class="wrapper">
                    <div class="timeClock flip-clock-container flip-example">
                        <p class="flip-item-seconds">23</p>
                        <p class="flip-item-minutes">38</p>
                        <p class="flip-item-hours">23</p>
                        <p class="flip-item-days">01</p>
                    </div>
                </div>

                <div class="time-button">
                    <button class="button-1">
                        <a href="/">Shop Now</a>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div class="square"></div>
    <!-- best product -->
    <section id="best-product">
        <p class="section-heading">Best Product</p>
        <div class="container">
            <div class="related-slider owl-carousel owl-theme">


                @foreach ($products as $product)
                    <div class="product-card">
                        <div class="img-wrapper mb-20">
                            <a href="#">
                                <img style="height: 320px; width:320px;"
                                    src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                    class="img-fluid" />
                            </a>
                            <a href="">
                                <img src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                    class="img-fluid hovered-img" />
                            </a>

                            <div class="overlay">
                                <div class="icon-wrapper">
                                    <div class="tooltip-wrapper">
                                        <div onclick="openPopup()" class="icon">
                                            <i class="fa-regular fa-eye"></i>
                                        </div>
                                        <div class="my-tooltip">Quick View</div>
                                    </div>
                                    <div class="tooltip-wrapper">
                                        <div onclick="openCart()" class="icon">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </div>
                                        <div class="my-tooltip">Add to Cart</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="#">
                            <h5 class="heading5">{{ $product->name }}</h5>
                        </a>
                        <div class="paragraph text-center">
                            {{ $product->description }}
                        </div>
                        <h3 class="heading3"> {{ $product->selling_price }}৳</h3>
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!-- subscribe section -->
    <section id="subscribe">
        <div class="subscribe-body">
            <div class="join-newsletter">
                <div class="join-newsletter-text">
                    <p class="section-sub-heading">
                        Join to Our Newsletter For More Info
                    </p>
                    <p class="heading-6">
                        Contrary to popular belief, Lorem Ipsum is not simply
                    </p>
                    <div class="subscribe-input">
                        <input type="text" placeholder="Enter your email..." />
                        <button class="button-1">
                            <a href="{{ url('/') }}">Subscribe</a>
                        </button>
                    </div>
                </div>
            </div>
            <a href="https://www.instagram.com/" target="_blank" class="first-image">
                <div>
                    <img src="{{ asset('frontend/assets/images/home/subscribe/first-image.png') }}" class="img-bg"
                        alt="" />
                </div>
                <img src="{{ asset('frontend/assets/images/home/subscribe/insta.png') }}" class="instagram-logo"
                    alt="" />
                <div class="instagram-overlay"></div>
            </a>
            <a href="https://www.instagram.com/" target="_blank" class="second-image">
                <div>
                    <img src="{{ asset('frontend/assets/images/home/subscribe/second-image.png') }}" class="img-bg"
                        alt="" />
                </div>
                <img src="{{ asset('frontend/assets/images/home/subscribe/insta.png') }}" class="instagram-logo"
                    alt="" />
                <div class="instagram-overlay"></div>
            </a>
            <a href="https://www.instagram.com/" target="_blank" class="third-image">
                <div>
                    <img src="{{ asset('frontend/assets/images/home/subscribe/third-image.png') }}" class="img-bg"
                        alt="" />
                </div>
                <img src="{{ asset('frontend/assets/images/home/subscribe/insta.png') }}" class="instagram-logo"
                    alt="" />
                <div class="instagram-overlay"></div>
            </a>
            <a href="https://www.instagram.com/" target="_blank" class="fourth-image">
                <div>
                    <img src="{{ asset('frontend/assets/images/home/subscribe/fourth-image.png') }}" class="img-bg"
                        alt="" />
                </div>
                <img src="{{ asset('frontend/assets/images/home/subscribe/insta.png') }}" class="instagram-logo"
                    alt="" />
                <div class="instagram-overlay"></div>
            </a>
            <a href="https://www.instagram.com/" target="_blank" class="fifth-image">
                <div>
                    <img src="{{ asset('frontend/assets/images/home/subscribe/fifth-image.png') }}" class="img-bg"
                        alt="" />
                </div>
                <img src="{{ asset('frontend/assets/images/home/subscribe/insta.png') }}" class="instagram-logo"
                    alt="" />
                <div class="instagram-overlay"></div>
            </a>
        </div>
    </section>
    <div class="square"></div>
    <!-- top-rated-product -->
    <section id="top-rated-product">
        <p class="section-heading">Top Rated Products</p>
        <div class="top-card-body container">
            <div class="top-card-row">


                @foreach ($products as $product)
                    <div class="top-card">
                        <div class="img-wrapper mb-20">
                            <a href="#">
                                <img style="height: 124px; width:130px;"
                                    src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                    class="img-fluid" />
                            </a>
                            <a href="#">
                                <img src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                    class="img-fluid hovered-img" />
                            </a>
                            <div class="overlay"></div>
                        </div>

                        <div class="top-card-text">
                            {{--  <div class="top-card-star">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div> --}}
                            <p class="card-name">
                                <a href="#">{{ Str::limit($product->name, 40, '...') }}</a>
                            </p>
                            <p class="card-price">
                                {{ $product->selling_price }}৳ - <span
                                    class="text-decoration-line-through">{{ $product->main_price }}৳</span>
                            </p>
                            <div class="top-card-icon">
                                <a href="#">
                                    <div class="card-button mr-15">
                                        <i class="fa-regular fa-heart"></i>
                                    </div>
                                </a>
                                <div onclick="openCart()" class="card-button mr-15">
                                    <i class="fi fi-rr-shopping-bag"></i>
                                </div>
                                <div onclick="openPopup()" class="card-button">
                                    <i class="fi fi-rr-eye"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <div class="square"></div>
    <!-- article section -->
    <section id="article">
        <p class="section-heading">Read Our Article</p>

        <div class="container article-card-body">
            <div class="article-card">
                <p class="heading-7">February 15,2023</p>
                <a href="blog.html" class="heading-8">House More Beautiful</a>
                <p class="article-details">
                    There or are many the variations of passages of Lorem Ipsum or
                    available, but the majority have but the majority have suffered
                </p>
                <div class="article-writer-info">
                    <img class="rounded-circle h-100"
                        src="{{ asset('frontend/assets/images/home/article/person-1.png') }}" alt="" />
                    <p>
                        <span class="article-name">Mr. Onsequat</span> <br />
                        <span class="article-designation">Vesoz Admin</span>
                    </p>
                </div>
                <div class="article-img mt-30">
                    <img src="{{ asset('frontend/assets/images/home/article/house-beautiful.png') }}" alt="" />
                </div>
            </div>
            <div class="article-card">
                <p class="heading-7">February 10, 2023</p>
                <a href="blog.html" class="heading-8">Plants Help Make Your House</a>
                <p class="article-details">
                    There or are many the variations of passages of Lorem Ipsum or
                    available, but the majority have but the majority have suffered
                </p>
                <div class="article-writer-info">
                    <img class="rounded-circle h-100"
                        src="{{ asset('frontend/assets/images/home/article/person-2.png') }}" alt="" />
                    <p>
                        <span class="article-name">Mr. Onsequat</span> <br />
                        <span class="article-designation">Vesoz Admin</span>
                    </p>
                </div>
                <div class="article-img mt-30">
                    <img src="{{ asset('frontend/assets/images/home/article/plants-help.png') }}" alt="" />
                </div>
            </div>
            <div class="article-card">
                <p class="heading-7">February 20,2023</p>
                <a href="blog.html" class="heading-8">We Know That Buying Cars</a>
                <p class="article-details">
                    There or are many the variations of passages of Lorem Ipsum or
                    available, but the majority have but the majority have suffered
                </p>
                <div class="article-writer-info">
                    <img class="rounded-circle h-100"
                        src="{{ asset('frontend/assets/images/home/article/person-3.png') }}" alt="" />
                    <p>
                        <span class="article-name">Mr. Onsequat</span> <br />
                        <span class="article-designation">Vesoz Admin</span>
                    </p>
                </div>
                <div class="article-img mt-30">
                    <img src="{{ asset('frontend/assets/images/home/article/buying-cars.png') }}" alt="" />
                </div>
            </div>
        </div>
    </section>
    <div class="square"></div>
    <!-- contact section -->
    <section id="contact">
        <div class="container">
            <div class="contact-cards">
                <div class="contact-card">
                    <div class="contact-card-body">
                        <img src="{{ asset('frontend/assets/images/home/contact/truck.png') }}" alt="" />
                        <div class="contact-card-text">
                            <p class="contact-head">Free Shipping Order</p>
                            <p class="contact-text">On orders over $100</p>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-card-body">
                        <img src="{{ asset('frontend/assets/images/home/contact/gift-card.png') }}" alt="" />
                        <div class="contact-card-text">
                            <p class="contact-head">Special Gift Card</p>
                            <p class="contact-text">The perfect gift idea</p>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-card-body">
                        <img src="{{ asset('frontend/assets/images/home/contact/return-exchange.png') }}"
                            alt="" />
                        <div class="contact-card-text">
                            <p class="contact-head">Return & Exchange</p>
                            <p class="contact-text">Free return within 3 days</p>
                        </div>
                    </div>
                </div>

                <div class="contact-card border-0">
                    <div class="contact-card-body">
                        <img src="{{ asset('frontend/assets/images/home/contact/support.png') }}" alt="" />
                        <div class="contact-card-text">
                            <p class="contact-head">Support 24 / 7</p>
                            <p class="contact-text">Customer Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
