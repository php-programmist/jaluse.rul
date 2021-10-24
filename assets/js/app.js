import '../scss/app.scss'

import './components/header_menu';
import './components/modal_callback';
import './components/slick_sliders';
import './components/order_catalog';
import './components/swiper_sliders';
import './blocks/seo-block';
import './blocks/popup-banner';
import './blocks/manimate';
import './blocks/mobile-menu';
import './blocks/recommended-products';
import './blocks/example-works';

import LazyLoad from './libs/lazyload.min'

new LazyLoad({
	elements_selector: ".lazy"
});