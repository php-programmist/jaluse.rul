import $ from 'jquery';
import '../../scss/modal_callback.css'

export function addModalOpenHandlers(triggerSelector, modalSelector) {
	const modal_callback = $(modalSelector);
	const modal_close = modal_callback.find('.modal_close');
	const modal_overlay = modal_callback.find('.overlay');
	const modal_title = modal_callback.find('.modal-title');
	$('body').on('click', triggerSelector, function (event) {
		event.preventDefault();
		let title = $(this).data('title');
		if (!title) {
			title = 'Заказать звонок';
		}
		modal_title.html(title + ':');
		modal_callback.addClass('is-visible');
	});
	modal_close.on('click', () => {
		modal_callback.removeClass('is-visible');
	});
	modal_overlay.on('click', () => {
		modal_callback.removeClass('is-visible');
	});
}