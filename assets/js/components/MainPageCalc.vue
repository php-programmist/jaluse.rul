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
					<div class="calc-parametr-razmer">
						<div class="bigzag">Задайте размер:</div>
						<label for="width">Ширина, мм</label>
						<input id="width" type="number" placeholder="Ширина, мм" v-model.number="width">
						<label for="height">Высота, мм</label>
						<input id="height" type="number" placeholder="Высота, мм" v-model.number="height">
					</div>
					<div class="calc-parametr-tipu">
						<div class="bigzag">Выберите тип управления:</div>
						<input type="radio" id="controlTypeManual" value="Ручное" v-model="controlType">
						<label for="controlTypeManual">Ручное</label>
						<input type="radio" id="controlTypeAuto" value="Электропривод" v-model="controlType">
						<label for="controlTypeAuto">Электропривод</label>
						<div>
							<b>Количество изделий:</b>
							<select v-model="number">
								<option v-for="i in 10" :value="i">{{i}}</option>
							</select>
						</div>
						<i>Изготовим за 1-3 рабочих дня</i>
					</div>
				</form>
			</div>
			<div class="col-lg-5 col-md-6 calc-vivod align-self-center">
				<div class="calc-vivod-imgwrap">
					<img :src="currentProduct.imageBig" alt="*">
				</div>
				<div class="product-name">
					{{currentProduct.name}}
				</div>
				<div class="calc-vivod-price">
					<div class="starcena">{{base_price}}₽ <span>-{{currentDiscount}}%</span></div>
					
					<div class="new-cenawrap">
						<div class="row">
							<div class="col-6 bigcena"><b>{{discounted_price}}₽</b>
								<p>При самовывозе</p></div>
							<div class="col-6 cena"><b>{{price_with_delivery}}₽</b>
								<p>С доставкой</p></div>
						</div>
					</div>
				
				</div>
				<div class="calc-vivod-opis">
					<div class="row">
						<div class="calc-vivod-opis-text col-sm-6">
							
							<div><b>Размеры: </b><span>{{width}}</span> ММ X <span>{{height}}</span>ММ</div>
							<div><b>Цвет: {{currentProduct.colorName}}</b></div>
						</div>
						<div class="calc-vivod-opis-text col-sm-6">
							<div><b>Управление: </b><span>{{controlType}}</span></div>
							<div><b>Подтип: </b><span>{{currentProduct.materialName}}</span></div>
						</div>
					
					</div>
				</div>
				<v-order-form
						text="Заказать"
						:product="currentProduct"
						:width="width"
						:height="height"
						:number="number"
						:discount_global="discount_global"
						:usd_rate="usd_rate"
						:delivery_cost="delivery_cost"
						:matrices="matrices"
						:controlType="controlType"
				></v-order-form>
				<v-consultation-form text="Получить консультацию"></v-consultation-form>
			</div>
		</div>
	
	</div>
</template>

<script>
	import axios from 'axios';
	import popup from './PopupContactForm';
	import ConsultationForm from './ConsultationForm';
	import OrderForm from './OrderForm';
	import PriceCalculator from './PriceCalculator'
	
	export default {
		data() {
			return {
				types: [],
				matrices: [],
				colors: [],
				availableColorsIds: [],
				colorsIds: [],
				products: [],
				categories: [],
				category_index: 0,
				type_index: -1,
				material_index: -1,
				product_index: 0,
				usd_rate: 0,
				discount_global: 0,
				width: 1000,
				height: 1000,
				number: 1,
				controlType: "Ручное",
				delivery_cost: 500,
				type_opened: false,
				material_opened: false,
				color_opened: false,
				price_calculator: null,
				base_price: 0,
				discounted_price: 0,
				price_with_delivery: 0,
				currentDiscount:0
			};
		},
		components: {
			popup,
			'v-consultation-form': ConsultationForm,
			'v-order-form': OrderForm
		},
		created() {
			axios.get('/api/main-page-calc/getInitData')
				.then(response => {
					this.types = response.data.types;
					this.matrices = response.data.matrices;
					this.colors = response.data.colors;
					this.categories = response.data.categories;
					this.usd_rate = parseFloat(response.data.usd_rate);
					this.discount_global = parseInt(response.data.discount_global);
					this.price_calculator = new PriceCalculator(this.discount_global, this.delivery_cost, this.usd_rate,this.matrices);
					this.currentDiscount = this.discount_global;
				});
			axios.get('/api/main-page-calc/getProducts')
				.then(response => {
					this.products = response.data.products;
					this.setAvailableColorsIds(response.data.colors);
				});
		},
		watch:{
			currentProduct(){
				this.$nextTick(() => {
					this.recalculatePrice();
				});
			},
			width(){
				this.$nextTick(() => {
					this.recalculatePrice();
				});
			},
			height(){
				this.$nextTick(() => {
					this.recalculatePrice();
				});
			},
			number(){
				this.$nextTick(() => {
					this.recalculatePrice();
				});
			}
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
			},
			recalculatePrice(){
				if (!this.price_calculator) {
					return;
				}
				const prices = this.price_calculator.getAllPrices(this.currentProduct,this.width,this.height,this.number);
				this.base_price = prices.basePrice;
				this.discounted_price = prices.discountedPrice;
				this.price_with_delivery = prices.priceWithDelivery;
				this.currentDiscount = prices.currentDiscount;
			}
		}
	};
</script>

<style>
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
</style>