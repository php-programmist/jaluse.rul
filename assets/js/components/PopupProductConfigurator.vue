<template>
	
	<div class="product-configurator-popup" :class="{'is-visible':visible}">
		<div class="overlay" @click.prevent="visible=false"></div>
		<div class="product-configurator-popup__container">
			<div id="raschet">
        <div class="modal_close" @click.prevent="visible=false">×</div>
				<div class="product-configurator-popup__wrapper">
          <v-product-configurator v-model="productConfigs"
                                  :calculationType="product.calculationType"></v-product-configurator>
          <v-price-renderer :prices="prices"></v-price-renderer>
          <div class="button-wrapper">
            <v-order-form
                text="Заказать"
                :product="product"
                :productConfigs="productConfigs"
                :prices="prices"
            ></v-order-form>
            <v-consultation-form text="Консультация"></v-consultation-form>
          </div>

        </div>
			</div>
		</div>
	</div>

</template>

<script>
import PriceRenderer from './PriceRenderer'
import ProductConfigurator from './ProductConfigurator'
import OrderForm from './OrderForm';
import ConsultationForm from './ConsultationForm';

export default {
  data() {
    return {
      visible: false,
      productConfigs: {}
    };
  },
  props: ["price_calculator", "product",],
  methods: {},
		components: {
			'v-price-renderer': PriceRenderer,
			'v-product-configurator': ProductConfigurator,
			'v-order-form': OrderForm,
			'v-consultation-form': ConsultationForm,
		},
		computed:{
			prices() {
				if (!this.price_calculator || typeof this.price_calculator.getAllPrices === 'undefined') {
					return {basePrice: 0, discountedPrice: 0, priceWithDelivery: 0, currentDiscount: 0};
				}
				
				return this.price_calculator.getAllPrices(this.product, this.productConfigs);
				
			}
		}
	}
</script>

<style lang="scss">
	.product-configurator-popup {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 9999;
		overflow-y: auto;
		cursor: pointer;
		visibility: hidden;
		opacity: 0;
		-webkit-transition: opacity 0.3s, visibility 0.3s;
		-moz-transition: opacity 0.3s, visibility 0.3s;
		transition: opacity 0.3s, visibility 0.3s;
		
		&__wrapper{
			padding: 2em;
		}
		.modal_close {
			position: absolute;
			top: 0;
			right: 15px;
			font-size: 3em;
			color: crimson;
			cursor: pointer;
		}
		
		.overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.85);
		}
		
		&__container {
			position: relative;
			width: 90%;
			max-width: 650px;
			background: #FFF;
			margin: 3em auto 4em;
			cursor: auto;
			border-radius: 0.25em;
			transform: translateY(-30px);
			transition-property: transform;
			transition-duration: 0.3s;
		}
		
		&.is-visible {
			visibility: visible;
			opacity: 1;
			.product-configurator-popup__container {
				transform: translateY(0);
			}
		}
		
		.mbtn{
			width: 48%;
			height: 40px;
			margin-right: 1%;
			font-weight: bold;
		}
	}
	
	
	
	
</style>