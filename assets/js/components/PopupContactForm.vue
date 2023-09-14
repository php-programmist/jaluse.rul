<template>
	<div class="cd-user-modal" :class="{'is-visible':visible}">
		<div class="overlay" @click.prevent="visible=false"></div>
		<div class="cd-user-modal-container">
			<div id="cd-raschet">
        <div class="modal_close" @click.prevent="visible=false">×</div>
				<form class="cd-form" method="POST">
					
					<div class="form-body">
						<span class="sspan">{{header}}:</span>
						
						<p class="fieldset">
							<label class="image-replace cd-name" for="form-name">Ваше имя:</label>
							<input
									class="full-width has-padding has-border"
									id="form-name"
									name="client-name"
									type="text"
									placeholder="Ваше имя"
									required=""
									v-model="name"
							>
						</p>
						
						<p class="fieldset">
							<label class="image-replace cd-phone" for="form-phone">Телефон</label>
							<input
									class="full-width has-padding has-border"
									id="form-phone"
									name="form-phone"
									type="tel"
									placeholder="Телефон"
									required=""
									v-model="phone"
									v-mask="'+# (###) ###-##-##'"
							>
						</p>
						<p class="fieldset">
              <button class="full-width form-submit js-submit-callback-form" @click.prevent="sendForm($event)">ОТПРАВИТЬ
              </button>
						</p>
					</div>
				</form>
			</div>
		</div> <!-- cd-user-modal-container -->
	</div>

</template>

<script>
import {mask} from 'vue-the-mask'

export default {
  data() {
    return {
      name: '',
      phone: '',
      visible: false
    };
  },
  directives: {mask},
  props: ["header"],
  methods: {
			sendForm(event){
				event.preventDefault();
				if (this.name !== '' && this.phone !== '') {
          this.$emit('sendForm', {name: this.name, phone: this.phone});
				}
			}
		}
	}
</script>

<style scoped>
	#cd-raschet .modal_close {
		position: absolute;
		top: 0;
		right: 15px;
		font-size: 3em;
		color: crimson;
		cursor: pointer;
	}
	
	.cd-form .select ul {
		display: none;
		position: absolute;
		overflow: hidden;
		overflow-y: auto;
		width: 100%;
		background: #fff;
		border-radius: 2px;
		top: 100%;
		left: 0;
		list-style: none;
		margin-top: -1px;
		border: 1px solid #d2d8d8;
		padding: 0;
		border-top: none;
		z-index: 100;
		max-height: 150px;
	}
	
	.cd-form .select ul li {
		display: block;
		text-align: left;
		padding: 16px 20px 16px 16px;
		color: #757575;
		cursor: pointer;
	}
	
	.cd-form .select ul li:hover {
		background: #4ebbf0;
		color: #fff;
	}
	
	.cd-user-modal {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 9999;
		overflow-y: hidden;
		cursor: pointer;
		visibility: hidden;
		opacity: 0;
		-webkit-transition: opacity 0.3s, visibility 0.3s;
		-moz-transition: opacity 0.3s, visibility 0.3s;
		transition: opacity 0.3s, visibility 0.3s;
	}
	
	.overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.85);
	}
	
	.cd-user-modal.is-visible {
		visibility: visible;
		opacity: 1;
	}
	
	.cd-user-modal.is-visible .cd-user-modal-container {
		-webkit-transform: translateY(0);
		-moz-transform: translateY(0);
		-ms-transform: translateY(0);
		-o-transform: translateY(0);
		transform: translateY(0);
	}
	
	.cd-user-modal-container {
		position: relative;
		width: 90%;
		max-width: 400px;
		background: #FFF;
		margin: 3em auto 4em;
		cursor: auto;
		border-radius: 0.25em;
		-webkit-transform: translateY(-30px);
		-moz-transform: translateY(-30px);
		-ms-transform: translateY(-30px);
		-o-transform: translateY(-30px);
		transform: translateY(-30px);
		-webkit-transition-property: -webkit-transform;
		-moz-transition-property: -moz-transform;
		transition-property: transform;
		-webkit-transition-duration: 0.3s;
		-moz-transition-duration: 0.3s;
		transition-duration: 0.3s;
	}
	
	.cd-user-modal-container .cd-switcher:after {
		content: "";
		display: table;
		clear: both;
	}
	
	.cd-user-modal-container .cd-switcher li {
		width: 50%;
		float: left;
		text-align: center;
	}
	
	.cd-user-modal-container .cd-switcher li:first-child a {
		border-radius: .25em 0 0 0;
	}
	
	.cd-user-modal-container .cd-switcher li:last-child a {
		border-radius: 0 .25em 0 0;
	}
	
	.cd-user-modal-container .cd-switcher a {
		display: block;
		width: 100%;
		height: 50px;
		line-height: 50px;
		background: #d2d8d8;
		color: #809191;
	}
	
	.cd-user-modal-container .cd-switcher a.selected {
		background: #FFF;
		color: #505260;
	}
	
	@media only screen and (min-width: 600px) {
		.cd-user-modal-container {
			margin: 8em auto;
		}
		
		.cd-user-modal-container .cd-switcher a {
			height: 70px;
			line-height: 70px;
		}
	}
	
	.cd-form {
		padding: 1.4em;
	}
	
	.cd-form .fieldset {
		position: relative;
		margin: 1.4em 0;
	}
	
	.cd-form .fieldset:first-child {
		margin-top: 0;
	}
	
	.cd-form .fieldset:last-child {
		margin-bottom: 0;
	}
	
	.cd-form label {
		font-size: 14px;
		font-size: 0.875rem;
	}
	
	.cd-form label[for=accept-terms] {
		font-size: 14px;
		display: initial;
		padding-left: 5px;
		position: relative;
		vertical-align: text-bottom;
		font-weight: normal;
	}
	
	.cd-form label.image-replace {
		/* replace text with an icon */
		display: inline-block;
		position: absolute;
		left: 15px;
		top: 50%;
		bottom: auto;
		-webkit-transform: translateY(-50%);
		-moz-transform: translateY(-50%);
		-ms-transform: translateY(-50%);
		-o-transform: translateY(-50%);
		transform: translateY(-50%);
		height: 20px;
		width: 20px;
		overflow: hidden;
		text-indent: 100%;
		white-space: nowrap;
		color: transparent;
		text-shadow: none;
		background-repeat: no-repeat;
		background-position: 50% 0;
	}
	
	.cd-form input, .cd-form .form-submit {
		margin: 0;
		padding: 0;
		border-radius: 0.25em;
	}
	
	.cd-form .full-width {
		width: 100%;
	}
	
	.cd-form input.has-padding {
		padding: 12px 20px 12px 50px;
	}
	
	.cd-form input.has-border {
		border: 1px solid #d2d8d8;
		-webkit-appearance: none;
		-moz-appearance: none;
		-ms-appearance: none;
		-o-appearance: none;
		appearance: none;
	}
	
	.cd-form input.has-border:focus {
		border-color: #343642;
		box-shadow: 0 0 5px rgba(52, 54, 66, 0.1);
		outline: none;
		transition: 0.3s;
	}
	
	.cd-form input.has-error {
		border: 1px solid #d76666;
	}
	
	.cd-form .sspan {
		text-align: center;
		width: 100%;
		display: block;
		line-height: 120%;
		font-size: 120%;
	}
	
	.cd-form input[type=password] {
		/* space left for the HIDE button */
		padding-right: 65px;
	}
	
	.cd-form .form-submit {
		padding: 16px 0;
		cursor: pointer;
		background: #6baf0b;
		color: #FFF;
		font-weight: bold;
		border: none;
		-webkit-appearance: none;
		transition: 0.3s;
		-moz-appearance: none;
		-ms-appearance: none;
		-o-appearance: none;
		appearance: none;
		text-transform: capitalize;
	}
	
	@media only screen and (min-width: 600px) {
		.cd-form {
			padding: 2em;
		}
		
		.cd-form .fieldset {
			margin: 2em 0;
		}
		
		.cd-form .fieldset:first-child {
			margin-top: 0;
		}
		
		.cd-form .fieldset:last-child {
			margin-bottom: 0;
		}
		
		.cd-form input.has-padding {
			padding: 16px 20px 16px 50px;
		}
		
		.cd-form .form-submit {
			padding: 16px 0;
		}
	}
</style>