export default function ($) {
	/*Обработчик ответа получаемого при отправке формы консультации*/
	const consultationFetchHandler = (response)=>{
		if (response.status !== 200) {
			response.json().then((data)=>{
				alert(data.detail);
			});
			return;
		}
		response.json().then((data)=>{
			if (data.status) {
				alert(data.msg);
				$('#modal-callback').removeClass('is-visible');
			}else{
				alert("Произошла ошибка: \n\n"+data.errors.join("\r\n"));
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
		}).then(consultationFetchHandler).catch((error)=>{
			alert(error.message);
		});
	});
	
	/*Открытие/закрытие модального окна*/
	const modal_callback = $('#modal-callback');
	const modal_close = modal_callback.find('.modal_close');
	const modal_overlay = modal_callback.find('.overlay');
	$('.modal-open').on('click',function (event) {
		event.preventDefault();
		modal_callback.addClass('is-visible');
	});
	modal_close.on('click',()=>{
		modal_callback.removeClass('is-visible');
	});
	modal_overlay.on('click',()=>{
		modal_callback.removeClass('is-visible');
	});
	
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
	$('.b1fonwrap').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		autoplay: true
	});
	
	$('.slider-for1').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		asNavFor: '.slider-nav1',
		responsive: [
			{
				breakpoint: 567,
				settings: {
					fade: false
				}
			}
		]
	});
	$('.slider-nav1').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.slider-for1',
		dots: false,
		arrows: false,
		centerMode: false,
		focusOnSelect: true,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 5
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 4
				}
			}
		]
		
	});
	
	$('.client-wrap').slick({
		slidesToShow: 6,
		slidesToScroll: 6,
		responsive: [
			
			{
				breakpoint: 1600,
				settings: {
					slidesToShow: 5,
					slidesToScroll: 5
				}
			},
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 567,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		
		]
	});
	$('.primeri-wrap').slick({
		slidesToShow: 5,
		slidesToScroll: 5,
		
		responsive: [
			
			{
				breakpoint: 1600,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 567,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		
		]
	});
	
	$('.preim-block').click(function (event) {
		
		if ($(window).width() > 577) {
			$('.bigslider-foot-wrap').slideToggle(400);
			$('.header').slideToggle(400);
			$('.bigslider-foot-for').slick({
				slidesToShow: 1,
				slidesToScroll: 1
			});
		}
	});
	$('.bigslider-foot-close').click(function (event) {
		$('.bigslider-foot-wrap').slideToggle(400);
		$('.header').slideToggle(400);
	});
	
	$('.calc-parametr-minimages').slick({
		slidesToShow: 7,
		slidesToScroll: 4,
		responsive: [
			
			{
				breakpoint: 1199,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 6
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 6
				}
			},
			{
				breakpoint: 567,
				settings: {
					slidesToShow: 5,
					slidesToScroll: 5
				}
			},
			{
				breakpoint: 435,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 390,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			}
		
		]
	});


//Код калькулятора, который лучше переделать.
	$('.bgcolor-wrap-color').click(function (event) {
		$(this).toggleClass('color-activ');
		
	});
	
	
	$('.minimages1').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/1.jpg');
	});
	$('.minimages2').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/2.jpg');
	});
	$('.minimages3').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/3.jpg');
	});
	$('.minimages4').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/4.jpg');
	});
	$('.minimages5').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/5.jpg');
	});
	$('.minimages6').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/6.jpg');
	});
	$('.minimages7').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/7.jpg');
	});
	$('.minimages8').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/8.jpg');
	});
	$('.minimages9').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/9.jpg');
	});
	$('.minimages10').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/10.jpg');
	});
	$('.minimages11').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/11.jpg');
	});
	$('.minimages12').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/12.jpg');
	});
	$('.minimages13').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/13.jpg');
	});
	$('.minimages14').click(function (event) {
		$('.calc-vivod-imgwrap img').attr('src', 'img/calc-img/14.jpg');
	});
	
	
	$('.colorzag').click(function (event) {
		$('.bgcolor-wrap').slideToggle();
	});
	$('.type-head1').click(function (event) {
		$('.type-body1').slideToggle();
	});
	$('.type-head2').click(function (event) {
		$('.type-body2').slideToggle();
	});
	
	/*Реализация переключения экранов в каталоге*/
	var catalogbtn1 = $('#catalog-header-button1');
	var catalogbtn2 = $('#catalog-header-button2');
	var catalogbtn3 = $('#catalog-header-button3');
	var catalogbtn4 = $('#catalog-header-button4');
	catalogbtn1.click(function (event) {
		catalogbtn1.attr('class', 'col-md-3 col-6 catalog-header-button catalog-header-active catalog-header-button1');
		catalogbtn2.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button2');
		catalogbtn3.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button3');
		catalogbtn4.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button4');
		$('.catalog-body1').css({display: 'block'});
		$('.catalog-body2').css({display: 'none'});
		$('.catalog-body3').css({display: 'none'});
		$('.catalog-body4').css({display: 'none'});
		
	});
	catalogbtn2.click(function (event) {
		catalogbtn1.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button1');
		catalogbtn2.attr('class', 'col-md-3 col-6 catalog-header-button catalog-header-active catalog-header-button2');
		catalogbtn3.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button3');
		catalogbtn4.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button4');
		$('.catalog-body1').css({display: 'none'});
		$('.catalog-body2').css({display: 'block'});
		$('.catalog-body3').css({display: 'none'});
		$('.catalog-body4').css({display: 'none'});
		$('.slider-for2').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			asNavFor: '.slider-nav2',
			responsive: [
				{
					breakpoint: 567,
					settings: {
						fade: false
					}
				}
			]
		});
		$('.slider-nav2').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			asNavFor: '.slider-for2',
			dots: false,
			arrows: false,
			centerMode: false,
			focusOnSelect: true,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 5
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				}
			]
			
		});
		
	});
	catalogbtn3.click(function (event) {
		catalogbtn1.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button1');
		catalogbtn2.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button2');
		catalogbtn3.attr('class', 'col-md-3 col-6 catalog-header-button catalog-header-active catalog-header-button3');
		catalogbtn4.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button4');
		$('.catalog-body1').css({display: 'none'});
		$('.catalog-body2').css({display: 'none'});
		$('.catalog-body3').css({display: 'block'});
		$('.catalog-body4').css({display: 'none'});
		$('.slider-for3').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			asNavFor: '.slider-nav3',
			responsive: [
				{
					breakpoint: 567,
					settings: {
						fade: false
					}
				}
			]
		});
		$('.slider-nav3').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			asNavFor: '.slider-for3',
			dots: false,
			arrows: false,
			centerMode: false,
			focusOnSelect: true,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 5
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				}
			]
			
		});
		
	});
	catalogbtn4.click(function (event) {
		catalogbtn1.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button1');
		catalogbtn2.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-button2');
		catalogbtn3.attr('class', 'col-md-3 col-6 catalog-header-button catalog-header-button3');
		catalogbtn4.attr('class', 'col-md-3 col-6 catalog-header-button  catalog-header-active  catalog-header-button4');
		$('.catalog-body1').css({display: 'none'});
		$('.catalog-body2').css({display: 'none'});
		$('.catalog-body3').css({display: 'none'});
		$('.catalog-body4').css({display: 'block'});
		$('.slider-for4').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			asNavFor: '.slider-nav4',
			responsive: [
				{
					breakpoint: 567,
					settings: {
						fade: false
					}
				}
			]
		});
		$('.slider-nav4').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			asNavFor: '.slider-for4',
			dots: false,
			arrows: false,
			centerMode: false,
			focusOnSelect: true,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 5
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				}
			]
			
		});
		
	});
}