import Inputmask from 'inputmask';
import $ from 'jquery';

function initBanner() {
	let banner_shown = getCookie("banner_shown");
	const screen_width = document.documentElement.clientWidth;
	if (banner_shown !== "1" && screen_width > 992) {
		setTimeout(() => {
			$('.baner-wraper').slideDown();
			document.cookie = "banner_shown=1; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
		}, 60000);
	}
}
function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

const bannerFetchHandler = (response) => {
	if (response.status !== 200) {
		response.json().then((data) => {
			alert(data.detail);
		});
		return;
	}
	response.json().then((data) => {
		if (data.status) {
			alert(data.msg);
			$('.modal-close-action').click();
		} else {
			alert("Произошла ошибка: \n\n" + data.errors.join("\r\n"));
		}
	});
};

$('.banner-form').on('submit', function(event) {
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
	}).then(bannerFetchHandler).catch((error) => {
		alert(error.message);
	});
});

$(document).ready(function () {
	const im = new Inputmask("+9 (999) 999-99-99");
	const phoneFields = document.querySelectorAll("#phone_client");
	im.mask(phoneFields);
	
	/*Закрытие модального окна*/
	$('.modal-close-action').on('click', function () {
		$('.baner-wraper').slideUp();
	});
	
	initBanner();
});
