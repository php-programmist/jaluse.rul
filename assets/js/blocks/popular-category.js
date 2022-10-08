import $ from 'jquery';

document.addEventListener("DOMContentLoaded", function (event) {
	const button = document.querySelector(".js-popular-category-show-more");
	button.addEventListener("click", () => {
		const hiddenCategories = document.querySelectorAll(".js-hidden-category");
		for (const category of hiddenCategories) {
			category.classList.toggle("hidden-category");
		}
		button.textContent = button.textContent === 'Показать все' ? 'Скрыть' : 'Показать все';
	});
});

$('.popular-category .category-area').slick({
	slidesToShow: 3,
	slidesToScroll: 1,
	responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1
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