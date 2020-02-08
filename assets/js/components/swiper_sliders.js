import $ from 'jquery';
import Swiper from 'swiper';
import '../../scss/swiper.scss';
$(document).ready(function(){
	new Swiper('.works .swiper-container', {
		effect: 'coverflow',
		grabCursor: true,
		centeredSlides: true,
		slidesPerView: 1,
		loop: true,
		// Disable preloading of all images
		preloadImages: false,
		// Enable lazy loading
		lazy: {
			loadPrevNext: true,//загрузка нескольких слайдов влево и вправо
			loadPrevNextAmount: 3//Количество слайдов для предзагрузки
		},
		watchSlidesVisibility: true,
		coverflowEffect: {
			rotate: 60,
			stretch: 0,
			depth: 100,
			modifier: 1,
			slideShadows: true,
		},
		pagination: {
			el: '.works .swiper-pagination',
		},
		// Navigation arrows
		navigation: {
			nextEl: '.works .swiper-button-next',
			prevEl: '.works .swiper-button-prev',
		},
		breakpoints: {
			// when window width is >= 320px
			320: {
				slidesPerView: 1
			},
			// when window width is >= 480px
			480: {
				slidesPerView: 1
			},
			// when window width is >= 640px
			640: {
				slidesPerView: 2,
			},
			// when window width is >= 640px
			768: {
				slidesPerView: 3,
			}
		}
	});
});