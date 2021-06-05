import Vue from 'vue';
import CategoryPageCalc from './components/CategoryPageCalc';
import '../scss/pages/category.scss'
import './blocks/recommended-products'
import MainPageCalc from './components/MainPageCalc';

Vue.component('main-page-calc', MainPageCalc);
Vue.component('v-category-page-calc',CategoryPageCalc);
new Vue({
	el: '#app'
});
if (document.getElementById('app-calc')) {
	new Vue({
		el: '#app-calc'
	});
}
