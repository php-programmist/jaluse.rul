import Vue from 'vue';

import '../scss/pages/category.scss'
import MainPageCalc from './components/MainPageCalc';

Vue.component('main-page-calc', MainPageCalc);

if (document.getElementById('app-calc')) {
	new Vue({
		el: '#app-calc'
	});
}
