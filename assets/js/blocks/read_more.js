import $ from 'jquery'
import '../libs/readmore'
import '../../scss/blocks/read_more.scss'

$('.read-more-block').readmore({
	speed: 75,
	collapsedHeight:1800,
	moreLink: '<div class="read-more-button-wrapper"><button class="mbtn">Показать еще</button></div>',
	lessLink: '<div class="read-more-button-wrapper"><button class="mbtn">Свернуть</button></div>',
});