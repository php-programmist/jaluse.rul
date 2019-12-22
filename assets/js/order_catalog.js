import slick from 'slick-carousel';
export default function () {
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