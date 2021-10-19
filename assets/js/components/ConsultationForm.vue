<template>
	<span class="mbtn-wrapper">
		<button class="mbtn mbtn2" @click="$refs.consultation.visible = true">{{ text }}</button>
		<v-popup-contact-form :header="text" ref="consultation" @sendForm="sendConsultation"></v-popup-contact-form>
	</span>
</template>

<script>
import PopupContactForm from './PopupContactForm'
import axios from 'axios';

export default {
  data() {
    return {};
  },
  components: {
    'v-popup-contact-form': PopupContactForm
  },
  props: ["text"],
  methods: {
    sendConsultation(data) {
      const {name, phone} = data;
				const body = {
					name,
					phone
				};
				const str = JSON.stringify(body);
				axios.post('/mail/callback/consultation', str)
					.then(({data}) => {
						alert(data.msg);
						this.$refs.consultation.visible = false;
					})
					.catch((error) => {
						alert(error.response.data.detail);
					});
			}
		}
	}
</script>

<style scoped>
	.mbtn2 {
		background-color: #fd971f;
	}
</style>