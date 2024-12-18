(function ($) {
    'use strict';

    var mona_window = $(window);

    // *******************************
    // :: 1.0 Preloader Active Code
    // *******************************

    mona_window.on('load', function () {
        $('#preloader').fadeOut('1000', function () {
            $(this).remove();
        });
    });
	
    // ***********************************
    // :: 5.0 Slick Slider Active Code
    // ***********************************
    if ($.fn.slick) {
        $('.review-slider').slick({
			dots: true,
			speed: 2000,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 1,
			slidesToScroll: 1,
			responsive: [
		{


      		breakpoint: 1024,
			settings: {
			arrows: false,
			dots: true,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 901,
			settings: {
			arrows: false,
			dots: true,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			rows: 1,
			dots: true,
			arrows: false,
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			rows: 1,
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			rows: 1,
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 6.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.fade').slick({
			dots: false,
			speed: 2000,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1024,
			settings: {
			slidesToShow: 4,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 901,
			settings: {
			slidesToShow: 4,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }

	// ***********************************
    // :: 7.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.lazy').slick({
			dots: false,
			speed: 2000,
            arrows: true,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1240,
			settings: {
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 1024,
			settings: {
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 901,
			settings: {
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }

	// ***********************************
    // :: 8.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.one-time').slick({
			dots: false,
			speed: 2000,
            arrows: true,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 5,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1240,
			settings: {
			arrows: false,
			slidesToShow: 5,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 1024,
			settings: {
			arrows: false,
			slidesToShow: 5,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 901,
			settings: {
			arrows: false,
			slidesToShow: 5,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			dots: false,
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			dots: false,
			arrows: false,
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			dots: false,
			arrows: false,
			slidesToShow: 2,
			slidesToScroll: 1
		}
		}
		]
		});
    }
    
    // ***********************************
    // :: 9.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.center').slick({
			rows: 2,
			dots: false,
			speed: 2000,
            arrows: true,
			autoplay: true,
			centerMode: true,
			centerPadding: '0',
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 2,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1024,

			settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 901,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 10.0 Slick Slider Active Code
    // ***********************************
    if ($.fn.slick) {
        $('.responsive').slick({
			dots: false,
            speed: 2000,
			fade: false,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			variableWidth: true,
			autoplayTimeout: 7000,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1024,
			settings: {
			slidesToShow: 4,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 900,
			settings: {
			slidesToShow: 4,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 767,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 1,
			variableWidth: false
		}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 1,
			variableWidth: false
		}
		},
		{
			breakpoint: 480,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1,
			variableWidth: false
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 9.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.treatments').slick({
			dots: false,
			speed: 2000,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1024,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 901,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 6.0 Slick Slider Active Code
    // ***********************************
    if ($.fn.slick) {
		$('.slider-for').slick({
			dots: true,
			speed: 2000,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 1,
			slidesToScroll: 1,
			asNavFor: '.slider-nav'
		});
		$('.slider-nav').slick({
			dots: false,
			speed: 2000,
            arrows: false,
			autoplay: true,
			focusOnSelect: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 1,
			slidesToScroll: 1,
			asNavFor: '.slider-for',
			responsive: [
		{
      		breakpoint: 1024,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 901,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 9.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.testimonials').slick({
			dots: false,
			speed: 2000,
            arrows: true,
			autoplay: true,
			centerMode: true,
			centerPadding: '0',
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 2,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1024,

			settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 901,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 7.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.cases').slick({
			dots: false,
			speed: 2000,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1240,
			settings: {
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 1024,
			settings: {
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 901,
			settings: {
			arrows: false,
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }
	
	// ***********************************
    // :: 7.0 Slick Slider Active Code
    // ***********************************	
	if ($.fn.slick) {
        $('.video').slick({
			rows: 2,
			dots: false,
			speed: 2000,
            arrows: false,
			autoplay: true,
			pauseOnHover: false,
			autoplayTimeout: 7000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
		{
      		breakpoint: 1240,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 1024,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
      		breakpoint: 901,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 768,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		},
		{
			breakpoint: 480,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		}
		}
		]
		});
    }

	// ***********************************
    // :: 11.0 WOW Active Code
    // ***********************************
    if (mona_window.width() > 767) {
        new WOW().init();
    }

	 // ***********************************
    // :: 12.0 Jarallax Active Code
    // ***********************************
    if ($.fn.jarallax) {
        $('.jarallax').jarallax({
            speed: 0.2
        });
    }
	
    // ***********************************
    // :: 13.0 Scrollup Active Code
    // ***********************************
    if ($.fn.scrollUp) {
        mona_window.scrollUp({
            scrollSpeed: 2000,
            scrollText: ''
        });
    }

})(jQuery);