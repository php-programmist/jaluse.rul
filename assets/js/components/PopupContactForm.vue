<template>
	<div class="cd-user-modal" :class="{'is-visible':visible}">
		<div class="overlay" @click="visible=false"></div>
		<div class="cd-user-modal-container">
			<div id="cd-raschet">
				<div class="modal_close" @click="visible=false">×</div>
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
							<button class="full-width form-submit" @click="sendForm($event)">ОТПРАВИТЬ</button>
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
		methods:{
			sendForm(event){
				event.preventDefault();
				if (this.name !== '' && this.phone !== '') {
					this.$emit('sendForm', {name:this.name,phone:this.phone});
				}
			}
		}
	}
</script>

<style scoped>

</style>