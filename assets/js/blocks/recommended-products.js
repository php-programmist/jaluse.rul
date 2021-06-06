import '../../scss/blocks/recommended-products.scss'

import $ from 'jquery';

$('.recommended_products').slick({
	slidesToShow: 4,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 2
			}
		},
		{
			breakpoint: 567,
			settings: {
				slidesToShow: 1
			}
		}
	
	]
});