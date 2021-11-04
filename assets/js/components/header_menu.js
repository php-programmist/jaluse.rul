import $ from 'jquery';

$('.headermbtn').click(function (event) {
	$('.header-n2').slideToggle(1000);
});
var headertop = $('.header').height();
//$('.vip-menu').css({top: (headertop-2)+'px'});
$(window).scroll(handleStickyMenu);
$(document).ready(handleStickyMenu);

function handleStickyMenu() {
	if ($(window).width() > 1199) {
		if ($(window).scrollTop() > headertop) {
			sticky();
		} else {
			notSticky();
		}
	}
}

function notSticky() {
	$('.header-n1').css({display: 'block'});
	$('.header-n2').css({background: 'rgba(0,0,0, 1)'});
	$('.headern2phone').css({display: 'none'});
	$('.header-search').css({display: 'none'});
	//$('.vip-menu').css({top: 0});
}

function sticky() {
	$('.header-n1').css({display: 'none'});
	$('.header-n2').css({background: 'rgba(0,0,0, 0.7)'});
	$('.headern2phone').css({display: 'inline-block'});
	$('.header-search').css({display: 'inline-block'});
	//$('.vip-menu').css({top: '47px'});
}
