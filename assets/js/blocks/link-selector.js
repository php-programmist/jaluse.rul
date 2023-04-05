const popups = [...document.getElementsByClassName('link_selector')];

window.addEventListener('click', ({target}) => {
	const popup = target.closest('.link_selector');
	const clickedOnClosedPopup = popup && !popup.classList.contains('open');
	
	popups.forEach(p => p.classList.remove('open'));
	
	if (clickedOnClosedPopup) popup.classList.add('open');
});