/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/global.scss'
import '../css/style.scss'
import '../css/media.scss'

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
import $ from 'jquery';
import slick from 'slick-carousel';
import scripts from './script';
scripts($);

import Vue from 'vue';
import MainPageCalc from './components/MainPageCalc';

new Vue({
	el: '#main-page-calc',
	render: h => h(MainPageCalc)
});
