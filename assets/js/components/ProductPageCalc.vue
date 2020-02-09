<template>
	<span>
		<button class="mbtn">Рассчитать стоимость</button>
		<v-consultation-form text="Получить консультацию"></v-consultation-form>
	</span>
</template>

<script>
	import axios from 'axios';
	import ConsultationForm from './ConsultationForm';
	//import OrderForm from './OrderForm';
	
	export default {
		data() {
			return {
				matrices: [],
				usd_rate: 0,
				discount_global: 0,
				delivery_cost: 0,
				product: {},
			};
		},
		props: ["product_id"],
		components: {
			'v-consultation-form': ConsultationForm,
		//	'v-order-form': OrderForm
		},
		created() {
			axios.get('/api/main-page-calc/getInitData')
				.then(response => {
					this.matrices = response.data.matrices;
					this.usd_rate = parseFloat(response.data.usd_rate);
					this.delivery_cost = parseInt(response.data.delivery_cost);
					this.discount_global = parseInt(response.data.discount_global);
				});
			axios.get('/api/main-page-calc/getProduct/'+this.product_id)
				.then(response => {
					this.product = response.data;
				});
		},
		methods: {
		
		}
	};
</script>

<style>
</style>