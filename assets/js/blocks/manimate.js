const scrollItems = document.querySelectorAll('.scroll-item');
const scrollAnimation = () => {
  let windowCenter = (window.innerHeight / 2) + window.scrollY;
  scrollItems.forEach(el => {
    let scrollOffset = el.offsetTop - (el.offsetHeight / 10);
    if (windowCenter >= scrollOffset) {
      el.classList.add('animation-class');
    } else {
      el.classList.remove('animation-class');
    }
  });
};
if (document.documentElement.clientWidth > 576) {
  scrollAnimation();
  window.addEventListener('scroll', () => {
    scrollAnimation();
  });
}
