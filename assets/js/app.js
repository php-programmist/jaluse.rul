import '../scss/app.scss'

import './components/header_menu';
import './components/modal_callback';
import './components/slick_sliders';
import './components/order_catalog';
import './components/swiper_sliders';

import LazyLoad from './libs/lazyload.min'
new LazyLoad({
	elements_selector: ".lazy"
});