@extends('layouts.frontend.app')
@section('title', 'Arha Shop')

@section('content')
    <div class="product-details">
        <div class="square"></div>

        <div class="container">
            <!-- <div class="details d-flex justify-content-between"> -->
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="img-wrapper">
                        <div class="slider-container">
                            <div class="row">
                                <div class="col-3">
                                    <div thumbsSlider="" class="swiper mySwiper">
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/product/' . $item->image) }}">
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/product/' . $item->image) }}">
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('storage/product/' . $item->image) }}">
                                            </div>
                                            {{--  @foreach ($item->images as $images)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/product/subimages/' . $images->image) }}">
                                                </div>
                                            @endforeach --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-9">
                                    <div class="swiper mySwiper2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img style="width: 507px; height:719px;"
                                                    src="{{ asset('storage/product/' . $item->image) }}" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- </div> -->
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="content">
                        <h3 class="heading3">{{ $item->name }}</h3>

                        <div class="rating d-flex align-items-center">
                            {{--     <span><i class="fa-sharp fa-regular fa-star"></i></span>
                            <span><i class="fa-sharp fa-regular fa-star"></i></span>
                            <span><i class="fa-sharp fa-regular fa-star"></i></span>
                            <span><i class="fa-sharp fa-regular fa-star"></i></span>
                            <span><i class="fa-sharp fa-regular fa-star"></i></span>

                            <div class="heading6 ml-5">No Reviews</div> --}}
                        </div>

                        <div class="price d-flex mb-20">
                            <span class="line-through">{{ $item->main_price }}{{ config('company.currency_symbol') }}</span>

                            <span>{{ $item->selling_price }}{{ config('company.currency_symbol') }}</span>
                        </div>

                        <div class="paragraph mb-30">
                            {{ $item->description }}
                        </div>

                        <div class="pro-details">
                            <div class="d-flex">
                                <h4 class="heading4 mb-30">Category</h4>
                                <h4 class="heading4 mb-30">{{ $item->category->name }}</h4>
                            </div>

                            <div class="d-flex quantity-wrapper mb-30 align-items-center">
                                <h4 class="heading4">Quantity</h4>

                                <div class="d-flex quantity">
                                    <span class="quantity-down">
                                        <i class="fa-solid fa-minus"></i>
                                    </span>
                                    <input type="number" min="1" max="100" step="1" value="1"
                                        readonly />
                                    <span class="quantity-up">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center flex-wrap mb-30">
                                <h4 class="heading4">Payment Method</h4>
                                <div class="c-card mr-10">
                                    <img src="{{ asset('frontend/assets/images/product-details/c-1.png') }}"
                                        alt="" />
                                </div>
                                <div class="c-card mr-10">
                                    <img src="{{ asset('frontend/assets/images/product-details/c-2.png') }}"
                                        alt="" />
                                </div>
                                <div class="c-card mr-10">
                                    <img src="{{ asset('frontend/assets/images/product-details/c-3.png') }}"
                                        alt="" />
                                </div>
                                <div class="c-card">
                                    <img src="{{ asset('frontend/assets/images/product-details/c-4.png') }}"
                                        alt="" />
                                </div>
                            </div>

                            <div class="d-flex">
                                <h4 class="heading4">Share</h4>

                                <div class="d-flex social-links">
                                    <a href="https://facebook.com/">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    <a href="https://instagram.com/">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    <a href="https://linkedin.com/">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('cart') }}">
                            <button class="button-1 mt-30">Add to cart</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="square"></div>

            <!-- Descriptions Start -->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                        type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                        Reviews
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link heading4" id="pills-contact-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false">
                        Comment
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <div class="paragraph mb-10">
                        {{ $item->description }}
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">
                    <form action="" class="review_wrapper">
                        <div class="heading4 mb-20">Write a Review</div>
                        <label for="">Name</label>
                        <input type="text" name="" id="" placeholder="Enter your name " required />
                        <label for=""> Email </label>
                        <input type="text" name="" id="" placeholder="Enter your email " required />
                        <label for="">Rating</label>
                        <div class="ratings">
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                            <i class="fa-sharp fa-solid fa-star"></i>
                        </div>
                        <label for="">Review Title</label>
                        <input type="text" name="" id="" placeholder="Give you review a title "
                            required />

                        <button type="submit" class="button-1">Submit</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                    tabindex="0">
                    <div class="heading4 mb-20">Comments</div>
                    <div class="comments d-flex justify-content-between align-items-center border">
                        <div class="paragraph">0 Comments</div>

                        <div class="sortby d-flex align-items-center">
                            <div class="paragraph mr-10">Sort by</div>

                            <select name="" id="">
                                <option value="">Newest</option>
                                <option value="old">Old</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Descriptions End -->
        </div>

        <!-- Section padding -->
        <div class="square"></div>

        <!-- Related Products Start -->
        <div class="related-products">
            <!-- Header -->
            <div class="d-flex flex-column align-items-center justify-content-center">
                <h2 class="heading2 mb-40">Related products</h2>
            </div>
            <!-- Header -->

            <div class="container">
                <div class="related-slider owl-carousel owl-theme">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <div class="img-wrapper mb-20">
                                <a href="#">
                                    <img style="width: 320px; height:340px;"
                                        src="{{ asset('storage/product/' . $product->image) }}" alt=""
                                        class="img-fluid" />
                                </a>
                                <a href="">
                                    <img style="width: 320px; height:340px;"
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
                                            <div class="icon">
                                                <i onclick="addToCart({{ $product->id }})"
                                                    class="fa-solid fa-cart-shopping"></i>
                                            </div>
                                            <div class="my-tooltip">Add to Cart</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ url('product-details') }}">
                                <h5 class="heading5">{{ $product->name }}</h5>
                            </a>
                            <div class="paragraph text-center">
                                {{ text_limit($product->description) }}
                            </div>
                            <h3 class="heading3">{{ $product->selling_price }}{{ config('company.currency_symbol') }}
                            </h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Related Products End -->
    </div>

@endsection
