import $ from 'jquery';
import '../../scss/blocks/mobile_menu.scss'

$('.mobile-menu-container li').removeClass('d-hover-effect');

$('.mobile-menu-container .mobile-menu-item i').on('click', function () {
	const listElem = $(this).parent().parent();
	$(listElem).toggleClass('d-hover-effect');
});

$('[data-menu-visible]').on('click', function (event) {
	const $this = $(this),
		visibleHeadArea = $this.data('menu-visible');
	$('.nav-visible').not(visibleHeadArea).removeClass('visible');
	$(visibleHeadArea).toggleClass('visible');
	event.stopPropagation();
});


