import '../../scss/blocks/recommended-products.scss'

import $ from 'jquery';

$('.recommended_products').slick({
	slidesToShow: 4,
	slidesToScroll: 4,
	lazyLoad: 'ondemand',
	autoplay: false,
	autoplaySpeed: 2000,
	responsive: [
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