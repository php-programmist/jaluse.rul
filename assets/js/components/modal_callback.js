import Inputmask from 'inputmask';
import $ from 'jquery';
import '../../css/modal_callback.css'

/*Обработчик ответа получаемого при отправке формы консультации*/
const consultationFetchHandler = (response) => {
	if (response.status !== 200) {
		response.json().then((data) => {
			alert(data.detail);
		});
		return;
	}
	response.json().then((data) => {
		if (data.status) {
			alert(data.msg);
			$('#modal-callback').removeClass('is-visible');
		} else {
			alert("Произошла ошибка: \n\n" + data.errors.join("\r\n"));
		}
	});
};
/*Маска ввода телефона*/
const im = new Inputmask("+9 (999) 999-99-99");
const phoneFields = document.querySelectorAll(".phone-field");
im.mask(phoneFields);

/*Отправка формы обратной связи*/
$('.phone_callback').submit(function (event) {
	event.preventDefault();
	const form = $(this);
	const phone = form.find('input[name="phone"]').val();
	const body = {phone};
	const name_field = form.find('input[name="name"]');
	if (name_field.length > 0) {
		body.name = name_field.val();
	}
	const url = form.prop('action');
	fetch(url, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json;charset=utf-8'
		},
		body: JSON.stringify(body)
	}).then(consultationFetchHandler).catch((error) => {
		alert(error.message);
	});
});

/*Открытие/закрытие модального окна*/
const modal_callback = $('#modal-callback');
const modal_close = modal_callback.find('.modal_close');
const modal_overlay = modal_callback.find('.overlay');
$('.modal-open').on('click', function (event) {
	event.preventDefault();
	modal_callback.addClass('is-visible');
});
modal_close.on('click', () => {
	modal_callback.removeClass('is-visible');
});
modal_overlay.on('click', () => {
	modal_callback.removeClass('is-visible');
});
