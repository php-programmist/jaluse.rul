import Vue from 'vue';
import ProductPageCalc from './components/ProductPageCalc';
import '../scss/pages/product.scss'
Vue.component('v-product-page-calc',ProductPageCalc);
new Vue({
	el: '#app'
});
