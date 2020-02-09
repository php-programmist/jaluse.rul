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
				priceConfigs: {},
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
					this.priceConfigs = response.data.priceConfigs;
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