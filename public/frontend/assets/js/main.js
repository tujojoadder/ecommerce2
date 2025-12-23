$(function () {
  $("#eye").click(function () {
    if ($(this).hasClass("fa-eye-slash")) {
      $(this).removeClass("fa-eye-slash");
      $(this).addClass("fa-eye");
      $(this).parents(".input-password").find(".password").attr("type", "text");
    } else {
      $(this).removeClass("fa-eye");
      $(this).addClass("fa-eye-slash");
      $(this)
        .parents(".input-password")
        .find(".password")
        .attr("type", "password");
    }
  });
  $("#neweye").click(function () {
    if ($(this).hasClass("fa-eye-slash")) {
      $(this).removeClass("fa-eye-slash");
      $(this).addClass("fa-eye");
      $(this).parents(".input-password").find(".password").attr("type", "text");
    } else {
      $(this).removeClass("fa-eye");
      $(this).addClass("fa-eye-slash");
      $(this)
        .parents(".input-password")
        .find(".password")
        .attr("type", "password");
    }
  });
  $("#confirmeye").click(function () {
    if ($(this).hasClass("fa-eye-slash")) {
      $(this).removeClass("fa-eye-slash");
      $(this).addClass("fa-eye");
      $(this).parents(".input-password").find(".password").attr("type", "text");
    } else {
      $(this).removeClass("fa-eye");
      $(this).addClass("fa-eye-slash");
      $(this)
        .parents(".input-password")
        .find(".password")
        .attr("type", "password");
    }
  });
});

$(document).ready(function () {
  //Home -2 Client slider
  $(".client-slider").owlCarousel({
    autoplay: true,
    loop: true,
    dots: false,
    sliderTransition: "linear",
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    autoplaySpeed: 2000,
    responsive: {
      0: {
        items: 2,
      },
      500: {
        items: 2,
      },
      600: {
        items: 3,
      },
      800: {
        items: 3,
      },
      1200: {
        items: 5,
      },
    },
  });

  // Testimonial slider
  $(".testimonial-carousel").owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    center: true,
    autoplay: true,
    autoplaySpeed: 2000,
    nav: true,
    dots: false,
    responsive: {
      0: {
        items: 1,
      },
      800: {
        items: 1,
      },
      1000: {
        items: 3,
      },
      1200: {
        items: 3,
      },
    },
  });

  // Testimonial slider
  $(".team-slider").owlCarousel({
    loop: true,
    margin: 30,
    responsiveClass: true,
    autoplay: true,
    autoplaySpeed: 2000,
    dots: false,
    // center: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 2,
      },
      768: {
        items: 3,
      },
      992: {
        items: 3,
      },
      1200: {
        items: 4,
      },
    },
  });

  //Related Product Slider
  $(".related-slider").owlCarousel({
    loop: true,
    margin: 30,
    responsiveClass: true,
    autoplay: true,
    autoplaySpeed: 2000,
    dots: false,
    nav: true,
    // center: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 2,
      },
      768: {
        items: 3,
      },
      992: {
        items: 3,
      },
      1200: {
        items: 4,
      },
    },
  });

  $(document).ready(function () {
    $(".popup-gallery").magnificPopup({
      delegate: "a",
      type: "image",
      tLoading: "Loading image #%curr%...",
      mainClass: "mfp-img-mobile",
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1], // Will preload 0 - before current, and 1 after the current image
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
          return item.el.attr("title") + "<small></small>";
        },
      },
    });
  });

  //Swiper

  var swiper = new Swiper(".mySwiper", {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 3,
    freeMode: true,
    watchSlidesProgress: true,
    direction: "vertical",
  });

  var swiper2 = new Swiper(".mySwiper2", {
    loop: true,
    spaceBetween: 10,
    thumbs: {
      swiper: swiper,
    },
  });
});

// ----------------------------------------//
//Increment or decrement product quantity  //
// ----------------------------------------//

$(".quantity").each(function () {
  var quantity = jQuery(this),
    input = quantity.find('input[type="number"]'),
    btnUp = quantity.find(".quantity-up"),
    btnDown = quantity.find(".quantity-down"),
    min = input.attr("min"),
    max = input.attr("max");

  btnUp.on("click", function () {
    var oldValue = parseFloat(input.val());
    if (oldValue >= max) {
      var newVal = oldValue;
    } else {
      var newVal = oldValue + 1;
    }
    quantity.find("input").val(newVal);
    quantity.find("input").trigger("change");

    // var mainPrice = parseFloat(
    //   $(this).parents(".cart-row").find(".main-price").text()
    // );
    // var updatePrice = mainPrice * newVal;

    // var totalPrice = $(this).parents(".cart-page").find(".total-price").text();
    // console.log(totalPrice);
  });

  btnDown.on("click", function () {
    var oldValue = parseFloat(input.val());
    if (oldValue <= min) {
      var newVal = oldValue;
    } else {
      var newVal = oldValue - 1;
    }
    quantity.find("input").val(newVal);
    quantity.find("input").trigger("change");
  });
});

// --------------------//
//Order Details popup  //
// --------------------//
$(".moreover").click(function (e) {
  $(this).siblings().toggleClass("active");
});

// ------------------------------//
//Navbar Hambarger on Navbar    //
// ------------------------------//
window.addEventListener("resize", function (e) {
  if (window.innerWidth > 992) {
    $("#mobile_nav_wrapper").removeClass("active");
    $(".nav_overlay").removeClass("active");
    $(".hamburger").removeClass("is-active");
  }
});

$(".hamburger").click(function () {
  $(this).toggleClass("is-active");

  $("#mobile_nav_wrapper").toggleClass("active");
  $(".nav_overlay").toggleClass("active");
});

$(".nav_overlay").on("click", function () {
  $(this).toggleClass("active");
  $("#mobile_nav_wrapper").toggleClass("active");
  $("#hamburger").toggleClass("is-active");
});

$(".close-button").on("click", function () {
  $("#mobile_nav_wrapper").toggleClass("active");
  $(".nav_overlay").toggleClass("active");
  $(".hamburger").toggleClass("is-active");
});

$(window).on("scroll", function () {
  var scrolling = $(this).scrollTop();

  if (scrolling > 300) {
    $(".navbar").addClass("fixed-nav");
  } else {
    $(".navbar").removeClass("fixed-nav");
  }
});

// --------------------//
//Mobile menu accordion//
// --------------------//

$(document).ready(function () {
  $(".accordion").on("click", ".heading", function () {
    $(this).toggleClass("active").next().slideToggle();

    $(".contents").not($(this).next()).slideUp(300);

    $(this).siblings().removeClass("active");
  });
});

// --------------------//
//Scroll Top function//
// --------------------//
$.scrollUp({
  scrollName: "scrollUp", // Element ID
  topDistance: "300", // Distance from top before showing element (px)
  topSpeed: 300, // Speed back to top (ms)
  animation: "fade", // Fade, slide, none
  animationInSpeed: 400, // Animation in speed (ms)
  animationOutSpeed: 400, // Animation out speed (ms)
  scrollText: " ", // Text for element
});

// --------------------------//
//Handle popup Product modal //
// --------------------------//
function openPopup() {
  $("#popup-overlay").addClass("active");
  $("body").addClass("stop-scrolling");
}
//Handle popup
function closePopup() {
  $("#popup-overlay").removeClass("active");
  $("body").removeClass("stop-scrolling");
}

//Search Bar popup
function openSearchBar() {
  $(".main-search-bar").addClass("active");
  $("body").addClass("stop-scrolling");
}
//Search Bar popup
function closeSearchBar() {
  $(".main-search-bar").removeClass("active");
  $("body").removeClass("stop-scrolling");
}

//Payment Success popup
function openPaymentSuccess() {
  $(".payment-success").addClass("active");
  $("body").addClass("stop-scrolling");
}

//Payment Success popup
function closePaymentSuccess() {
  $(".payment-success").removeClass("active");
  $("body").removeClass("stop-scrolling");
}

//Cart popup
function openCart() {
  $("#headerCartWrap").addClass("active");
  $(".cart-overlay").addClass("active");
  $("body").addClass("stop-scrolling");
}

//Close cart popup
function closeCart() {
  $("#headerCartWrap").removeClass("active");
  $(".cart-overlay").removeClass("active");
  $("body").removeClass("stop-scrolling");
}

//hero image Slider
$(".hero-image").owlCarousel({
  loop: true,
  margin: 30,
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  items: 1,
  nav: true,
});

// --------------------//
//AOS Initialization
// --------------------//
AOS.init();
