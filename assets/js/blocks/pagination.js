import $ from 'jquery';

$('body').on('click', '.js-load-next-products', function () {
	const url = $(this).data('url');
	$.get(url, function (response) {
		$('.pagination-wrapper').replaceWith(response);
	});
});