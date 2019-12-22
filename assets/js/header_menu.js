export default function () {
	$('.headermbtn').click(function (event) {
		$('.header-n2').slideToggle(1000);
	});
	var headertop = $('.header').height();
	
	$(window).scroll(function () {
		if ($(window).width() > 1199) {
			if ($(window).scrollTop() > headertop) {
				$('.header-n1').css({display: 'none'});
				$('.header-n2').css({background: 'rgba(0,0,0, 0.7)'});
				$('.headern2phone').css({display: 'inline-block'});
				$('.vip-menu').css({top: '47px'});
				
			}
			else {
				$('.header-n1').css({display: 'block'});
				$('.header-n2').css({background: 'rgba(0,0,0, 1)'});
				$('.headern2phone').css({display: 'none'});
				$('.vip-menu').css({top: '113px'});
			}
		}
	});
}