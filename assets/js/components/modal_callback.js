import Inputmask from 'inputmask';
import $ from 'jquery';
import '../../scss/modal_callback.css'
import {openSuccessModal} from "./modal_success";
import {addModalOpenHandlers} from "../libs/modal-helper";

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
			$('#modal-callback').removeClass('is-visible');
			openSuccessModal();
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
	const token_field = form.find('input[name="token"]');
	if (token_field.length > 0) {
		body.token = token_field.val();
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
addModalOpenHandlers('.js-modal-open', '#modal-callback');
addModalOpenHandlers('.js-modal-domain-open', '#modal-domain');

