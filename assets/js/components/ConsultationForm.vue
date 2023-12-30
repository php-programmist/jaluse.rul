<template>
	<span class="mbtn-wrapper">
		<button class="mbtn mbtn2" @click.prevent="$refs.consultation.visible = true">{{ text }}</button>
		<v-popup-contact-form
        :header="text"
        ref="consultation"
        @sendForm="sendConsultation">
    </v-popup-contact-form>
	</span>
</template>

<script>
import PopupContactForm from './PopupContactForm'
import axios from 'axios';
import {openSuccessModal} from "./modal_success";

export default {
  data() {
    return {};
  },
  components: {
    'v-popup-contact-form': PopupContactForm
  },
  props: ["text", "token"],
  methods: {
    sendConsultation(data) {
      const str = JSON.stringify({...data, token: this.token});
      axios.post('/mail/callback/consultation', str)
          .then(() => {
            this.$refs.consultation.visible = false;
            openSuccessModal();
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