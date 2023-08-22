"use strict";

$(document).ready(function () {
    //preloader
    $(".preloader")
        .delay(300)
        .animate(
            {
                opacity: "0",
            },
            300,
            function () {
                $(".preloader").css("display", "none");
            }
        );
});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function () {
    const element = $(this).parent("li");
    if (element.hasClass("open")) {
        element.removeClass("open");
        element.find("li").removeClass("open");
    } else {
        element.addClass("open");
        element.siblings("li").removeClass("open");
        element.siblings("li").find("li").removeClass("open");
    }
});

$(".header-search-open-btn").on("click", function () {
    $(this).toggleClass("active");
    $(".header-search-form-mobile").toggleClass("active");
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// main wrapper calculator
var bodySelector = document.querySelector("body");
var header = document.querySelector(".header");
var footer = document.querySelector(".footer");

(function () {
    if (bodySelector.contains(header) && bodySelector.contains(footer)) {
        var headerHeight = document.querySelector(".header").clientHeight;
        var footerHeight = document.querySelector(".footer").clientHeight;

        // if header isn't fixed to top
        var totalHeight = parseInt(headerHeight, 10) + parseInt(footerHeight, 10) + "px";

        // if header is fixed to top
        // var totalHeight = parseInt( footerHeight, 10 ) + 'px';
        var minHeight = "100vh";
        document.querySelector(
            ".main-wrapper"
        ).style.minHeight = `calc(${minHeight} - ${totalHeight})`;
    }
})();

// Show or hide the sticky footer button
$(window).on("scroll", function () {
    if ($(this).scrollTop() > 200) {
        $(".scroll-to-top").fadeIn(200);
    } else {
        $(".scroll-to-top").fadeOut(200);
    }
});

// Animate the scroll to top
$(".scroll-to-top").on("click", function (event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, 300);
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        boundary: "window",
    });
});

// action-sidebar js
const actionSidebar = $(".action-sidebar");
const actionSidebarOpenBtn = $(".action-sidebar-open");
const actionSidebarCloseBtn = $(".action-sidebar-close");

actionSidebarOpenBtn.on("click", function () {
    actionSidebar.addClass("active");
});
actionSidebarCloseBtn.on("click", function () {
    actionSidebar.removeClass("active");
});

new WOW().init();

// review-slider
$(".review-slider").slick({
    dots: false,
    arrows: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    speed: 3000,
    cssEase: "linear",
    autoplay: true,
    autoplaySpeed: 0,
    adaptiveHeight: false,
    autoplay: true,
    pauseOnDotsHover: false,
    pauseOnHover: true,
    pauseOnFocus: true,
    rows: 2,
    responsive: [
        {
            breakpoint: 1400,
            settings: {
                slidesToShow: 3,
            },
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 576,
            settings: {
                slidesToShow: 1,
            },
        },
    ],
});

// testimonial-slider
$(".testimonial-slider").slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    autoplay: false,
    cssEase: "cubic-bezier(0.645, 0.045, 0.355, 1.000)",
    speed: 1000,
    autoplaySpeed: 1000,
    arrows: true,
    nextArrow: '<div class="next"><i class="las la-long-arrow-alt-right"></i></div>',
    prevArrow: '<div class="prev"><i class="las la-long-arrow-alt-left"></i></div>',
});
