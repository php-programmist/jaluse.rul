import debounce from "../utils/debounce";

async function getData(searchString) {
	const request = new Request(`/api/search?search=${searchString}`);
	const result = await fetch(request);
	
	return result.text();
}

const handleSearchInput = debounce(async (e) => {
	const searchString = e.target.value;
	const searchResultsContainerElement = document.querySelector('.search_results_container');
	if (searchString.length < 3) {
		searchResultsContainerElement.innerHTML = '';
	} else {
		searchResultsContainerElement.innerHTML = await getData(searchString);
	}
});

const handleSearchInputClose = debounce((e) => {
	e.preventDefault();
	const searchInputContainerElement = document.querySelector(".search_input_container");
	searchInputContainerElement.classList.remove("active");
});

const handleSearchInputSubmit = debounce((e) => {
	e.preventDefault();
	const searchFormElement = document.querySelector(".search_form");
	searchFormElement.submit();
});


function searchInputToggle(e) {
	e.preventDefault();
	const searchInputContainerElement = document.querySelector(".search_input_container");
	const searchInputElement = document.querySelector(".search_input");
	searchInputContainerElement.classList.toggle("active");
	searchInputElement.focus();
}

document.addEventListener("DOMContentLoaded", function (event) {
	const searchInputElement = document.querySelector(".search_input");
	const searchInputCloseElement = document.querySelector(".search_input_close");
	const searchInputSubmitElement = document.querySelector(".search_input_submit");
	const searchInputToggleElements = document.querySelectorAll(".js-search_input_toggle");
	
	searchInputElement.addEventListener("keyup", handleSearchInput);
	searchInputCloseElement.addEventListener("click", handleSearchInputClose);
	searchInputSubmitElement.addEventListener("click", handleSearchInputSubmit);
	searchInputToggleElements.forEach(element => element.addEventListener("click", searchInputToggle));
});
