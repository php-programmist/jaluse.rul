import $ from 'jquery';

let isExtraMenuOpen = false;
const burgerIcon = $('.extra-menu-burger-js > .extra-menu-burger__icon');
const menuList = $('#mobile-menu-container > li');
const firstItem = $(menuList[0]);
const secondItem = $(menuList[1]);

$('.extra-menu-burger-js').on('click', () => {
	
	if (!isExtraMenuOpen) {
		burgerIcon.addClass('extra-menu-burger__icon-opened');
		firstItem.addClass('d-hover-effect');
		secondItem.addClass('d-hover-effect');
	} else {
		burgerIcon.removeClass('extra-menu-burger__icon-opened');
		firstItem.removeClass('d-hover-effect');
		secondItem.removeClass('d-hover-effect');
	}
	
	isExtraMenuOpen = !isExtraMenuOpen;
});