import $ from 'jquery'
import '../libs/fotorama'

$(document).ready(function () {
	const jobs = {};
	jobs.next = $('.job_next');
	jobs.prev = $('.job_prev');
	jobs.current = $('.row--job');
	jobs.current.h = $(jobs.current).height();
	jobs.current.number = $(jobs.current).attr('data-job-id') * 1;
	jobs.filter = '';
	jobs.max = jobs.current.length;
	
	jQuery('.fotorama').fotorama({
		width: '100%',
		ratio: 16 / 9,
		fit: 'cover',
		transition: 'crossfade',
		nav: 'thumbs',
		loop: true,
		thumbheight: 120,
		thumbwidth: 170,
	});
	
	function initJobs() {
		let jobIndex = 1;
		jobs.max = 0;
		jobs.current.each(function () {
			const item = $(this);
			const filters = item.data('filters').split(',');
			if (jobs.filter === '' || filters.indexOf(jobs.filter) > -1) {
				item.attr('data-job-id', jobIndex);
				jobIndex++;
				jobs.max++;
			} else {
				item.attr('data-job-id', -1);
			}
		});
		
		$(jobs.current).hide();
		$('.row--job[data-job-id=' + 1 + ']').show();
	}
	
	
	jobs.next.click(function () {
		const n = jobs.current.number + 1;
		if ($('.row--job[data-job-id=' + n + ']').length) {
			$(jobs.current).hide();
			jobs.current.number++;
			$('.row--job[data-job-id=' + n + ']').show();
			jobs.updateButtons();
		}
	});
	
	jobs.prev.click(function () {
		const n = jobs.current.number - 1;
		if ($('.row--job[data-job-id=' + n + ']').length) {
			$(jobs.current).hide();
			jobs.current.number--;
			$('.row--job[data-job-id=' + n + ']').show();
			jobs.updateButtons();
		}
	});
	
	jobs.updateButtons = function () {
		if (jobs.current.number === 1) {
			jobs.prev.addClass('btn-grey');
		} else {
			jobs.prev.removeClass('btn-grey');
		}
		if (jobs.current.number === jobs.max) {
			jobs.next.addClass('btn-grey');
		} else {
			jobs.next.removeClass('btn-grey');
		}
	};
	jobs.updateButtons();
	initJobs();
	
	$('.work_example_filters__item').click(function (e) {
		e.preventDefault();
		if (document.documentElement.clientWidth < 992) {
			$('.work_example_filters').slideUp();
		}
		$('.work_example_filters__item').removeClass('active');
		$(this).addClass('active');
		jobs.filter = $(this).data('value') || e.target.innerHTML;
		initJobs();
	});
	
	$('.work_example_filters_toggler').click(function (e) {
		e.preventDefault();
		$('.work_example_filters').slideToggle();
	});
});