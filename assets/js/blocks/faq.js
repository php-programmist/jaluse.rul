import $ from 'jquery'
import '../../scss/blocks/faq.scss'

// Обработчик для кнопки "Показать еще/Скрыть"
$('.faq-show-more').on('click', function (e) {
	e.preventDefault();
	
	const button = $(this);
	const faqContainer = button.closest('.faq-container');
	
	if (faqContainer.hasClass('show-all')) {
		// Скрываем дополнительные элементы
		faqContainer.removeClass('show-all');
		button.removeClass('show-less');
		button.find('.button-text').text('Показать еще');
		
		// Закрываем все открытые аккордеоны в скрытых элементах
		faqContainer.find('.faq-hidden .faq-answer.active').removeClass('active');
		faqContainer.find('.faq-hidden .faq-question.active').removeClass('active');
	} else {
		// Показываем все элементы
		faqContainer.addClass('show-all');
		button.addClass('show-less');
		button.find('.button-text').text('Скрыть');
	}
});

// Обработчик для аккордеона
$(document).on('click', '.faq-question', function (e) {
	e.preventDefault();
	
	const question = $(this);
	const answer = question.next('.faq-answer');
	const isActive = question.hasClass('active');
	
	if (isActive) {
		// Закрываем текущий элемент
		question.removeClass('active');
		answer.removeClass('active');
	} else {
		// Открываем текущий элемент
		question.addClass('active');
		answer.addClass('active');
	}
});