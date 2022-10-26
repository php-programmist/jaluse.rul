import $ from 'jquery';
import '../../scss/modal_success.css'

/*Открытие/закрытие модального окна*/
const modal_success = $('#modal-success');
const modal_close = modal_success.find('.modal_close');

modal_close.on('click', () => {
	modal_success.removeClass('is-visible');
});

export const openSuccessModal = () => {
	modal_success.addClass('is-visible');
}
