import $ from 'jquery';

$('.link_selector').click(function () {
	const closeHandler = (event) => {
		if (!event.target.closest('.link_selector')) {
			$(this).removeClass('open');
		}
	}
	
	if ($(this).hasClass('open')) {
		$(this).removeClass('open');
		document.removeEventListener('click', closeHandler, false);
	} else {
		$(this).addClass('open');
		document.addEventListener(
			'click',
			closeHandler,
			false
		)
	}
})