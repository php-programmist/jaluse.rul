import Vue from 'vue';
import CategoryPageCalc from './components/CategoryPageCalc';
import '../scss/pages/category.scss'
import MainPageCalc from './components/MainPageCalc';
Vue.component('main-page-calc', MainPageCalc);
Vue.component('v-category-page-calc',CategoryPageCalc);
new Vue({
	el: '#app'
});
new Vue({
	el: '#app-calc'
});
