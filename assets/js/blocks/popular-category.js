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