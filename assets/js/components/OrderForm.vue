<template>
	<div class="mbtn-wrapper">
    <button class="mbtn" @click="$refs.order.visible = true">{{ text }}</button>
    <v-popup-contact-form :header="text" ref="order" @sendForm="sendOrder"></v-popup-contact-form>
  </div>
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
  props: ["text", "product", "productConfigs", "prices"],
  methods: {
    sendOrder(data) {
      const {name, phone} = data;
				const body = {
					name,
					phone,
					product_url: this.product.uri,
					product_name: this.product.name,
					category: this.product.categoryName,
					material: this.product.materialName,
					width: this.productConfigs.width,
					height: this.productConfigs.height,
					number: this.productConfigs.number,
					controlType: this.productConfigs.controlType,
					color: this.product.colorName,
					base_price: this.prices.basePrice,
					discounted_price: this.prices.discountedPrice,
					price_with_delivery: this.prices.priceWithDelivery,
				};
				const str = JSON.stringify(body);
				axios.post('/mail/callback/order', str)
					.then(({data}) => {
						alert(data.msg);
						this.$refs.order.visible = false;
					})
					.catch((error) => {
						alert(error.response.data.detail);
					});
			}
		}
	}
</script>

<style scoped>

</style>