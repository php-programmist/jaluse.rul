<template>
	<div class="calc-wrap">
		<div class="row">
			<div class="col-lg-7 col-md-6 calc-parametr">
				<form action="#">
					<div class="calc-parametr-typewrap">
						<div class="minzag">Выберите тип и подтип жалюзи</div>
						<div class="row">
							<div class="calc-parametr-typewrap-type">
								<div class="type-head type-head1">
									<div class="type-text" @click="toggleTypeSelector()">{{typeName}}</div>
								</div>
								<transition name="slide">
									<div class="type-body type-body1" v-show="type_opened">
										<div
												v-for="(type,index) in types"
												:key="index"
												class="type-text"
												@click="changeType(index)"
										>
											{{ type.name }}
										</div>
									</div>
								</transition>
							</div>
							<transition name="slide-fade">
								<div class="calc-parametr-typewrap-type" v-show="materials.length > 0">
									<div class="type-head type-head2">
										<div class="type-text" @click="toggleMaterialSelector()">{{materialName}}</div>
									</div>
									<transition name="slide">
										<div class="type-body type-body2" v-show="material_opened">
											<div
													v-for="(material,index) in materials"
													:key="index"
													class="type-text"
													@click="changeMaterial(index)"
											>
												{{ material.name }}
											</div>
										</div>
									</transition>
								</div>
							</transition>
						</div>
					
					</div>
					<div class="calc-parametr-color">
						<div class="minzag colorzag" @click="toggleColorSelector()">Цвет:</div>
						<transition name="slide">
							<div class="bgcolor-wrap" v-show="color_opened">
								<div
										v-for="(color,index) in availableColors"
										:key="color.id"
										class="bgcolor-wrap-color"
										:class="{colorActive:colorsIds.includes(color.id)}"
										:title="color.name"
										:style="'background-color:'+color.hex"
										@click="toggleColorId(color.id)"
								></div>
							</div>
						</transition>
					</div>
					<div class="calc-parametr-categori">
						<span
								v-for="(category,index) in categories"
								:class="{activ:category_index===index}"
								@click="changeCategory(index)"
						>
							{{category.name}}
						</span>
					</div>
					<div class="calc-parametr-minimages">
						<div
								class="minimages-wrap"
								v-for="(product,index) in products"
								:key="product.id"
						>
							<div class="minimages" @click="setActiveProductIndex(index)">
								<img :src="product.imageSmall" alt="">
							</div>
						</div>
					</div>
					<v-product-configurator v-model="productConfigs"></v-product-configurator>
					
				</form>
			</div>
			<div class="col-lg-5 col-md-6 calc-vivod align-self-center">
				<div class="calc-vivod-imgwrap">
					<img :src="currentProduct.imageBig" alt="*">
				</div>
				<div class="product-name">
					{{currentProduct.name}}
				</div>
				<v-price-renderer :prices="prices"></v-price-renderer>
				<div class="calc-vivod-opis">
					<div class="row">
						<div class="calc-vivod-opis-text col-sm-6">
							
							<div><b>Размеры: </b><span>{{productConfigs.width}}</span> ММ X <span>{{productConfigs.height}}</span>ММ</div>
							<div><b>Цвет: {{currentProduct.colorName}}</b></div>
						</div>
						<div class="calc-vivod-opis-text col-sm-6">
							<div><b>Управление: </b><span>{{productConfigs.controlType}}</span></div>
							<div><b>Подтип: </b><span>{{currentProduct.materialName}}</span></div>
						</div>
					
					</div>
				</div>
				<v-order-form
						text="Заказать"
						:product="currentProduct"
						:productConfigs="productConfigs"
						:prices="prices"
				></v-order-form>
				<v-consultation-form text="Получить консультацию"></v-consultation-form>
			</div>
		</div>
	
	</div>
</template>

<script>
	import axios from 'axios';
	import ConsultationForm from './ConsultationForm';
	import OrderForm from './OrderForm';
	import PriceCalculator from './PriceCalculator'
	import PriceRenderer from './PriceRenderer'
	import ProductConfigurator from './ProductConfigurator'
	
	export default {
		data() {
			return {
				types: [],
				colors: [],
				availableColorsIds: [],
				colorsIds: [],
				products: [],
				categories: [],
				category_index: 0,
				type_index: -1,
				material_index: -1,
				product_index: 0,
				type_opened: false,
				material_opened: false,
				color_opened: false,
				price_calculator: null,
				productConfigs:{}
			};
		},
		components: {
			'v-consultation-form': ConsultationForm,
			'v-order-form': OrderForm,
			'v-price-renderer': PriceRenderer,
			'v-product-configurator': ProductConfigurator,
		},
		created() {
			axios.get('/api/main-page-calc/getInitData')
				.then(response => {
					this.types = response.data.types;
					this.colors = response.data.colors;
					this.categories = response.data.categories;
					const matrices = response.data.matrices;
					const priceConfigs = response.data.priceConfigs;
					this.price_calculator = new PriceCalculator(priceConfigs, matrices);
				});
			axios.get('/api/main-page-calc/getProducts')
				.then(response => {
					this.products = response.data.products;
					this.setAvailableColorsIds(response.data.colors);
				});
		},
		
		computed: {
			typeName() {
				return this.type_index > -1 ? this.types[this.type_index].name : 'Тип';
			},
			materialName() {
				return this.materials.length > 0 && this.material_index > -1 ? this.materials[this.material_index].name : 'Подтип';
			},
			materials() {
				return this.type_index > -1 ? this.types[this.type_index].materials : [];
			},
			availableColors() {
				return this.colors.filter(color => this.availableColorsIds.includes(color.id));
				
			},
			currentProduct() {
				if (this.products.length === 0 || typeof this.products[this.product_index] == 'undefined') {
					return {
						"price": 0,
						"imageSmall": '',
						"imageBig": '',
						"colorId": 0,
						"colorName": "",
						"materialName": "",
						"discount": 0,
						"id": 0,
						"name": "",
						"uri": ""
					};
				}
				return this.products[this.product_index];
			},
			prices() {
				if (!this.price_calculator) {
					return {basePrice: 0, discountedPrice: 0, priceWithDelivery: 0, currentDiscount: 0};
				}
				
				return this.price_calculator.getAllPrices(this.currentProduct, this.productConfigs);
				
			}
			
		},
		mounted() {
		
		},
		methods: {
			changeType(index) {
				this.type_opened = false;
				if (index !== this.type_index) {//Тип действительно изменился
					this.type_index = index;
					this.material_index = -1;
					this.colorsIds = [];
					this.getProducts();
				}
			},
			changeMaterial(index) {
				this.material_opened = false;
				if (index !== this.material_index) {//Тип действительно изменился
					this.material_index = index;
					this.colorsIds = [];
					this.getProducts();
				}
			},
			changeCategory(index) {
				if (index !== this.category_index) {//Тип действительно изменился
					this.category_index = index;
					this.colorsIds = [];
					this.getProducts();
				}
			},
			toggleTypeSelector() {
				this.type_opened = !this.type_opened;
			},
			toggleMaterialSelector() {
				this.material_opened = !this.material_opened;
			},
			toggleColorSelector() {
				this.color_opened = !this.color_opened;
			},
			toggleColorId(colorId) {
				if (this.colorsIds.includes(colorId)) {
					this.colorsIds = this.colorsIds.filter(value => value !== colorId);
					this.getProducts();
				} else {
					this.colorsIds.push(colorId);
					this.getProducts();
				}
			},
			setActiveProductIndex(index) {
				this.product_index = index;
			},
			getProducts() {
				this.product_index = 0;
				let query = '/api/main-page-calc/getProducts?';
				query += 'category=' + this.categories[this.category_index].id;
				if (this.type_index > -1) {
					query += '&type=' + this.types[this.type_index].id;
				}
				if (this.material_index > -1) {
					query += '&material=' + this.materials[this.material_index].id;
				}
				if (this.colorsIds.length > 0) {
					query += '&color=' + this.colorsIds.join(',');
				}
				axios.get(query)
					.then(response => {
						this.products = response.data.products;
						this.setAvailableColorsIds(response.data.colors);
					});
			},
			setAvailableColorsIds(array) {
				this.availableColorsIds = array.map(item => parseInt(item));
			}
		}
	};
</script>

<style lang="scss">
	.slide-enter-active {
		-moz-transition-duration: 0.5s;
		-webkit-transition-duration: 0.5s;
		-o-transition-duration: 0.5s;
		transition-duration: 0.5s;
		-moz-transition-timing-function: ease-in;
		-webkit-transition-timing-function: ease-in;
		-o-transition-timing-function: ease-in;
		transition-timing-function: ease-in;
	}
	
	.slide-leave-active {
		-moz-transition-duration: 0.3s;
		-webkit-transition-duration: 0.3s;
		-o-transition-duration: 0.3s;
		transition-duration: 0.3s;
		-moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
		-webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
		-o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
		transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
	}
	
	.slide-enter-to, .slide-leave {
		max-height: 500px;
		overflow: hidden;
	}
	
	.slide-enter, .slide-leave-to {
		overflow: hidden;
		max-height: 0;
	}
	
	.slide-fade-enter-active {
		transition: all .3s ease;
	}
	
	.slide-fade-leave-active {
		transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
	}
	
	.slide-fade-enter, .slide-fade-leave-to {
		transform: translateX(30px);
		opacity: 0;
	}
	$text-grey: rgba(54, 54, 54, 0.8);
	.calc-vivod {
		&-imgwrap {
			text-align: center;
			img {
				max-width: 100%;
			}
		}
		&-opis {
			margin-bottom: 20px;
			&-text {
				
				font-size: 14px;
				div {
					
					font-size: 14px;
					b {
						text-transform: uppercase;
					}
				}
				i {
					margin-left: 20px;
					margin-top: 20px;
					display: block;
					margin-bottom: 20px;
					
				}
			}
			&-cena {
				font-size: 14px;
				a {
					display: block;
					color: $text-grey;
					text-align: right;
					text-decoration: underline;
					margin-top: 10px;
				}
				.price {
					font-weight: bold;
					font-size: 16px;
					margin-top: 10px;
					b {
						font-size: 36px;
						display: inline-block;
						margin-right: 5px;
					}
				}
				
			}
		}
	}
</style>