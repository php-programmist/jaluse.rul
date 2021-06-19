import Vue from 'vue';
import MainPageCalc from './components/MainPageCalc';
import "../scss/blocks/catalog.scss";

Vue.component('main-page-calc', MainPageCalc);
new Vue({
	el: '#app-calc'
});