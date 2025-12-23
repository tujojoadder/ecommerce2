<nav>
    <div class="top_nav">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <ul>
                    <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>{{ config('company.phone') }}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="{{ config('company.email') }}">{{ config('company.email') }}</a>
                    </li>
                </ul>

                <ul>
                    <li>
                        <a href="/"><i class="fa-brands fa-facebook-f"></i></a>
                    </li>

                    <li>
                        <a href="/"><i class="fa-brands fa-twitter"></i></a>
                    </li>

                    <li>
                        <a href="/"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="/"><i class="fa-brands fa-linkedin-in"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nav_wrapper">
        <div class="navbar">
            <div class="container">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <div class="logo">
                        <a href="/">

                            <img class="img-fluid" src=" {{ config('company.logo') }}" alt="" />
                        </a>
                    </div>

                    <div class="menus">
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    Home <i class="fa-solid fa-chevron-down"></i>
                                </a>

                                <ul class="dropdown">
                                    <a href="/">
                                        <li>Home 1</li>
                                    </a>
                                    <a href="/">
                                        <li>Home 2</li>
                                    </a>
                                </ul>
                            </li>
                            <li><a href="/"> About Us </a></li>
                            <li>
                                <a href="#">
                                    Page <i class="fa-solid fa-chevron-down"></i>
                                </a>

                                <ul class="dropdown">
                                    <a href="/">
                                        <li>Cart</li>
                                    </a>
                                    <a href="/">
                                        <li>Change Password</li>
                                    </a>
                                    <a href="/">
                                        <li>Login</li>
                                    </a>
                                    <a href="/">
                                        <li>Order Details</li>
                                    </a>
                                    <a href="/">
                                        <li>Order Summery</li>
                                    </a>
                                    <a href="/">
                                        <li>Order Tracking</li>
                                    </a>
                                    <a href="/">
                                        <li>Payment</li>
                                    </a>
                                    <a href="/">
                                        <li>Profile</li>
                                    </a>
                                    <a href="/">
                                        <li>Sign Up</li>
                                    </a>
                                </ul>
                            </li>
                            <li><a href="/"> Product </a></li>
                            <li><a href="/"> Blog </a></li>
                            <li><a href="/"> Contact Us </a></li>
                        </ul>

                        <ul class="options">
                            <li onclick="openSearchBar()">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </li>
                            <a href="/">
                                <li>
                                    <i class="fa-solid fa-cart-shopping"></i>

                                    <div class="qty">3</div>
                                </li>
                            </a>

                            <a href="/">
                                <li><i class="fa-solid fa-user"></i></li>
                            </a>

                            <li>
                                <div class="hamburger" id="hamburger-1">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav_overlay"></div>

    <div class="mobile_nav">
        <div id="mobile_nav_wrapper" class="wrapper">
            <div class="logo">
                <img class="img-fluid" src="{{ asset('frontend/assets/images/logo2.png') }}" alt="" />
            </div>

            <div class="accordion_wrapper">
                <div class="accordion">
                    <div class="heading">
                        <h3 class="heading3">Home</h3>
                    </div>
                    <div class="contents">
                        <a href="/">
                            <h3 class="heading3">Home1</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Home2</h3>
                        </a>
                    </div>
                    <a href="/">
                        <h3 class="heading3">Product</h3>
                    </a>
                    <a href="/">
                        <h3 class="heading3">Blog</h3>
                    </a>
                    <a href="/">
                        <h3 class="heading3">Contact Us</h3>
                    </a>

                    <div class="heading">
                        <h3 class="heading3">Pages</h3>
                    </div>
                    <div class="contents">
                        <a href="/">
                            <h3 class="heading3">Cart</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Change Password</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Login</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Order Details</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Order Summery</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Order Tracking</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Payment</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Profile</h3>
                        </a>
                        <a href="/">
                            <h3 class="heading3">Sign Up</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="close-button">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>
    </div>
</nav>
