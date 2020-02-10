<template>
	<span>
		<button class="mbtn" @click="showProductConfigurator">Рассчитать стоимость</button>
		<v-consultation-form text="Получить консультацию"></v-consultation-form>
		<v-popup-product-configurator
				ref="product_configurator"
				:price_calculator="price_calculator"
				:product="product"
		></v-popup-product-configurator>
	</span>
</template>

<script>
	import axios from 'axios';
	import ConsultationForm from './ConsultationForm';
	import PopupProductConfigurator from './PopupProductConfigurator';
	import PriceCalculator from './PriceCalculator';
	
	export default {
		data() {
			return {
				price_calculator: {},
				product: {},
			};
		},
		props: ["product_id"],
		components: {
			'v-consultation-form': ConsultationForm,
			'v-popup-product-configurator': PopupProductConfigurator
		},
		created() {
			axios.get('/api/calc/getInitData')
				.then(response => {
					const matrices = response.data.matrices;
					const priceConfigs = response.data.priceConfigs;
					this.price_calculator = new PriceCalculator(priceConfigs, matrices);
				});
			axios.get('/api/calc/getProduct/'+this.product_id)
				.then(response => {
					this.product = response.data;
				});
		},
		methods: {
			showProductConfigurator(){
				this.$refs.product_configurator.visible = true;
			}
		}
	};
</script>

<style>
</style>