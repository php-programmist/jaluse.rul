import $ from 'jquery';
import 'slick-carousel';

$('.b1fonwrap').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	lazyLoad: 'ondemand',
	fade: true,
	autoplay: true
});

$('.slider-for1').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	lazyLoad: 'ondemand',
	autoplay: true,
	autoplaySpeed: 2000,
	fade: true,
	asNavFor: '.slider-nav1',
	responsive: [
		{
			breakpoint: 567,
			settings: {
				fade: false
			}
		}
	]
});
$('.slider-nav1').slick({
	slidesToShow: 4,
	slidesToScroll: 1,
	asNavFor: '.slider-for1',
	lazyLoad: 'ondemand',
	dots: false,
	arrows: false,
	centerMode: false,
	focusOnSelect: true,
	responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 5
			}
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 4
			}
		}
	]
	
});

$('.client-wrap').slick({
	slidesToShow: 6,
	slidesToScroll: 6,
	lazyLoad: 'ondemand',
	autoplay: true,
	autoplaySpeed: 2000,
	responsive: [
		
		{
			breakpoint: 1600,
			settings: {
				slidesToShow: 5,
				slidesToScroll: 5
			}
		},
		{
			breakpoint: 1199,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 4
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 567,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
	
	]
});


$('.preim-block').click(function (event) {
	
	if ($(window).width() > 577) {
		$('.bigslider-foot-wrap').slideToggle(400);
		$('.header').slideToggle(400);
		$('.bigslider-foot-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			lazyLoad: 'ondemand',
			autoplay: true,
			autoplaySpeed: 2000,
		});
	}
});
$('.bigslider-foot-close').click(function (event) {
	$('.bigslider-foot-wrap').slideToggle(400);
	$('.header').slideToggle(400);
});

