import slick from 'slick-carousel';
export default function () {
	$('.b1fonwrap').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		autoplay: true
	});
	
	$('.slider-for1').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
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
	$('.primeri-wrap').slick({
		slidesToShow: 5,
		slidesToScroll: 5,
		
		responsive: [
			
			{
				breakpoint: 1600,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
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
				slidesToScroll: 1
			});
		}
	});
	$('.bigslider-foot-close').click(function (event) {
		$('.bigslider-foot-wrap').slideToggle(400);
		$('.header').slideToggle(400);
	});
	
	$('.calc-parametr-minimages').slick({
		slidesToShow: 7,
		slidesToScroll: 4,
		responsive: [
			
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 6
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
					slidesToShow: 6,
					slidesToScroll: 6
				}
			},
			{
				breakpoint: 567,
				settings: {
					slidesToShow: 5,
					slidesToScroll: 5
				}
			},
			{
				breakpoint: 435,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 390,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			}
		
		]
	});
}