<!-- Footer section Start -->
<section id="footer">
    <!-- Section padding -->
    <div class="square"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-4">
                <div class="logo mb-30">
                    <img src="{{ config('company.logo') }}" alt="" class="img-fluid" />
                </div>

                <div class="paragraph mb-20">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed
                    nulla eu dui suscipit ultricies. Mauris vestibulum volutpat nisl
                    vel cursus. Cras finibus nec mauris tincidunt condimentum.
                </div>

                <div class="social-links">
                    <a href="https://facebook.com/"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://instagram.com/"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://linkedin.com/"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <h3 class="heading3">Link</h3>

                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/">About Us</a></li>
                    <li><a href="/">Products</a></li>
                    <li><a href="/">Contact Us</a></li>
                    <li><a href="/">Blog</a></li>
                </ul>
            </div>
            <div class="col-md-8 col-lg-3">
                <h3 class="heading3">Get In Touch</h3>
                <ul class="addresses">
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-phone-volume"></i> {{ config('company.phone') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-envelope"></i> {{ config('company.email') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-map-location-dot"></i> {{ config('company.address') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 col-lg-3">
                <h3 class="heading3">Other Links</h3>

                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Section padding -->
    <div class="square"></div>

    <div class="divider"></div>

    <div class="container copyright">
        <div class="d-flex py-3 justify-content-between align-items-center">
            <div class="paragraph">Copyright & Design by SolPlant-2023</div>

            <div class="d-flex">
                <div class="card-wrapper">
                    <img src="{{ asset('frontend/assets/images/footer/1.png') }}" class="img-fluid" alt="" />
                </div>
                <div class="card-wrapper">
                    <img src="{{ asset('frontend/assets/images/footer/2.png') }}" class="img-fluid" alt="" />
                </div>
                <div class="card-wrapper">
                    <img src="{{ asset('frontend/assets/images/footer/3.png') }}" class="img-fluid" alt="" />
                </div>
                <div class="card-wrapper">
                    <img src="{{ asset('frontend/assets/images/footer/4.png') }}" class="img-fluid" alt="" />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer section end -->

<!-- Product short details popup start -->
<div id="popup-overlay">
    <div class="popup d-flex">
        <div class="img-wrapper">
            <img src="{{ asset('frontend/assets/images/popup/1.png') }}" alt="" class="img-fluid" />
        </div>
        <div onclick="closePopup()" class="close">
            <i class="fa-sharp fa-regular fa-circle-xmark"></i>
        </div>
        <div class="content">
            <h3 class="heading3">Aliquam vel</h3>
            <div class="price d-flex mb-20">
                <span class="line-through">$12</span>

                <span>$10</span>
            </div>

            <div class="paragraph">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed
                nulla eu dui suscipit ultricies. Mauris vestibulum volutpat nisl vel
                cursus. Cras finibus nec mauris tincidunt condimentum. Cras vel
                interdum arcu.
            </div>

            <div class="rating d-flex">
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
            </div>

            <h4 class="heading4 mb-30">Category : Small Plant</h4>

            <div class="d-flex quantity-wrapper align-items-center">
                <h4 class="heading">Quantity</h4>
                <div class="d-flex quantity">
                    <span class="quantity-down"><i class="fa-solid fa-minus"></i></span>
                    <input type="number" min="1" max="100" step="1" value="1" readonly />
                    <span class="quantity-up"><i class="fa-solid fa-plus"></i></span>
                </div>
            </div>

            <a href="/">
                <button class="button-1 mt-30">Add to cart</button>
            </a>
        </div>

        <div onclick="closePopup()" class="overlay-popup-bg"></div>
    </div>
</div>
<!-- Product short details popup end -->

<!-- Cart Sidebar -->
<div class="header-cart-wrap" id="headerCartWrap">
    <div onclick="closeCart()" class="cart-overlay"></div>

    <div class="cart-list">
        <div class="title">
            <h3 class="heading3">Shopping Cart</h3>
            <button onclick="closeCart()" class="cart-close">
                <i class="fa-regular fa-circle-xmark"></i>
            </button>
        </div>
        <ul>
            <li>
                <a href="/">
                    <div class="part-img">
                        <img src="{{ asset('frontend/assets/images/products/1.png') }}" alt="Image" />
                    </div>
                    <div class="part-txt">
                        <span class="heading5">Diamond wedding ring</span>
                        <span>1 <i class="fa-solid fa-xmark"></i> $5.00</span>
                    </div>
                </a>
                <button class="delete-btn">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </li>
            <li>
                <a href="/">
                    <div class="part-img">
                        <img src="{{ asset('frontend/assets/images/products/2.png') }}" alt="Image" />
                    </div>
                    <div class="part-txt">
                        <span class="heading5">Living Summer Chair</span>
                        <span>1 <i class="fa-solid fa-xmark"></i> $5.00</span>
                    </div>
                </a>
                <button class="delete-btn">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </li>
            <li>
                <a href="/">
                    <div class="part-img">
                        <img src="{{ asset('frontend/assets/images/products/3.png') }}" alt="Image" />
                    </div>
                    <div class="part-txt">
                        <span class="heading5">Wireless Headphone</span>
                        <span>1 <i class="fa-solid fa-xmark"></i> $5.00</span>
                    </div>
                </a>
                <button class="delete-btn">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </li>
        </ul>
        <div class="total">
            <p>Subtotal: <span>$15:00</span></p>
        </div>
        <div class="btn-box">
            <a href="/" class="button-1">Checkout</a>
        </div>
    </div>
</div>
<!-- Cart Sidebar -->

<!-- Right Sidebar-Bar Toggler -->
<div onclick="openCart()" class="side_cart">
    <div class="top-1">
        <div class="top-items-number">
            <i class="fa-sharp fa-solid fa-bag-shopping"></i>
            <p class="paragraph-2">3 Items</p>
        </div>
        <div class="top-item-dollar">
            <p class="paragraph-2">$15</p>
        </div>
    </div>
</div>
<!-- Right Sidebar-Bar Toggler -->

<script src="{{ asset('frontend/assets/js/scrollUp.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/owl.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

<script>
    // init Isotope
    var $grid1 = $(".arrival-card-body").isotope({
        filter: ".top-rated-list",
    });
    // filter items on button click
    $(".arrival-head-list").on("click", "p", function() {
        var filterValue = $(this).attr("data-filter");
        $grid1.isotope({
            filter: filterValue
        });
    });

    var $grid2 = $(".best-card-body").isotope({
        filter: ".all",
    });
    // filter items on button click
    $(".best-head-list").on("click", "p", function() {
        var filterValue = $(this).attr("data-filter");
        $grid2.isotope({
            filter: filterValue
        });
    });
</script>

<script>
    $(".flip-demo").on("done", function() {});
    $(".flip-demo").on(
        'before<a href="https://www.jqueryscript.net/tags.php?/Flip/">Flip</a>ping',
        function(e, data) {
            console.log("beforeFlipping:", data);
        }
    );
    $(".flip-demo").on("afterFlipping", function(e, data) {
        console.log("afterFlipping:", data);
    });
</script>

<script>
    var $grid = $(".item-details").isotope({
        layoutMode: "fitRows",
    });
    $(".filters-button-group").on("click", "button", function() {
        var filterValue = $(this).attr("data-filter");
        $grid.isotope({
            filter: filterValue
        });
        $(".filters-button-group button").removeClass("active");
        $(this).addClass("active");
    });
</script>
