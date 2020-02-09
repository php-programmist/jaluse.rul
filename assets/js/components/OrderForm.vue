<template>
	<span>
		<button class="mbtn" @click="$refs.order.visible = true">{{ text }}</button>
		<v-popup-contact-form :header="text" ref="order" @sendForm="sendOrder"></v-popup-contact-form>
	</span>
</template>

<script>
	import PopupContactForm from './PopupContactForm'
	import PriceCalculator from './PriceCalculator'
	import axios from 'axios';
	export default {
		data() {
			return {};
		},
		components: {
			'v-popup-contact-form':PopupContactForm
		},
		props: ["text","product","width","height","number","discount_global","delivery_cost","usd_rate","matrices","controlType"],
		methods:{
			sendOrder(data) {
				const {name, phone} = data;
				const price_calculator = new PriceCalculator(this.discount_global,this.delivery_cost,this.usd_rate,this.matrices);
				const prices = price_calculator.getAllPrices(this.product,this.width,this.height,this.number);
				const base_price = prices.basePrice;
				const discounted_price = prices.discountedPrice;
				const price_with_delivery = prices.priceWithDelivery;
				const body = {
					name,
					phone,
					product_url: this.product.uri,
					product_name: this.product.name,
					category: this.product.categoryName,
					material: this.product.materialName,
					width: this.width,
					height: this.height,
					number: this.number,
					controlType: this.controlType,
					color: this.product.colorName,
					base_price,
					discounted_price,
					price_with_delivery,
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