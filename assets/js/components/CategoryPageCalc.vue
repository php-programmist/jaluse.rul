<template>
	<div class="row catalog-calculator">
		<div class="col-md-2 col-sm-12">
			<h3>Фильтры:</h3>
			<div class="type_selector" v-show="types.length > 0 && (type_id == 0 || force_show_filters)">
				<v-drop-down-selector
					:items="types"
					default_name="Выбрать вид"
					v-model="type"
				></v-drop-down-selector>
			</div>
			<div class="material_selector" v-show="materials.length > 0 && material_id == 0">
				<v-drop-down-selector
					:items="materials"
					default_name="Выбрать изделие"
					v-model="material"
					@input="getProducts"
				></v-drop-down-selector>
			</div>
			<div class="color_selector" v-show="availableColors.length > 0">
				<v-color-selector
					:items="availableColors"
					v-model="colorsIds"
				></v-color-selector>
			</div>
		</div>
		<div class="col-md-9 col-sm-12">
			<div class="categories">
				<v-category-selector :categories="categories" v-model="category" @input="getProducts"></v-category-selector>
			</div>
			<div class="products">
				<div
						class="product"
						v-for="product in filteredProducts"
						:key="product.id"
				>
					<a :href="`/${product.uri}/`" target="_blank"><img :src="product.imageCatalog" :alt="product.name"></a>
					<div class="product__name"><a :href="`/${product.uri}/`" target="_blank">{{ product.name }}</a></div>
					<div class="product__price">{{product.calculationType === 'simple'? `${product.minPrice} руб/м2`:`от ${product.minPrice} руб` }}</div>
					<button class="mbtn mbtn_orange" @click="showProductConfigurator(product)">Рассчитать</button>
				</div>
			</div>
			<div class="text-center">
				<button v-if="products.length < totalProducts" class="mbtn" @click="getProductsNextPage()">Показать еще...</button>
			</div>
		</div>
		
		
		<v-popup-product-configurator
				ref="product_configurator"
				:price_calculator="price_calculator"
				:product="currentProduct"
		></v-popup-product-configurator>
	</div>
</template>

<script>
	import axios from 'axios';
	import ConsultationForm from './ConsultationForm';
	import PopupProductConfigurator from './PopupProductConfigurator';
	import PriceCalculator from './PriceCalculator';
	import CategorySelector from './CategorySelector';
	import DropDownSelector from './DropDownSelector';
	import ColorSelector from './ColorSelector';
	
	export default {
		data() {
			return {
				types: [],
				colors: [],
				availableColorsIds: [],
				colorsIds: [],
				products: [],
				categories: [],
				price_calculator: {},
				category: {},
				type: {id:0},
				material: {id:0},
				totalProducts:0,
				page:1,
				currentProduct: {
					"price": 0,
					"discount": 0,
					"id": 0,
					"name": "",
					"uri": ""
				},
			};
		},
		props: ["type_id","material_id","force_show_filters"],
		components: {
			'v-consultation-form': ConsultationForm,
			'v-popup-product-configurator': PopupProductConfigurator,
			'v-category-selector': CategorySelector,
			'v-drop-down-selector': DropDownSelector,
			'v-color-selector': ColorSelector,
		},
		created() {
			axios.get('/api/calc/getInitData')
				.then(response => {
					this.types = response.data.types;
					this.colors = response.data.colors;
					this.categories = response.data.categories;
					this.category = this.categories[0];
					const matrices = response.data.matrices;
					const priceConfigs = response.data.priceConfigs;
					this.price_calculator = new PriceCalculator(priceConfigs, matrices);
					this.setInitType();
					if (this.materials.length > 0 && this.material_id > 0) {
						this.material = this.materials.find(material=>material.id == this.material_id )
					}
					this.getProducts();
				});
		},
		computed:{
			materials() {
				return typeof this.type.materials !=='undefined'? this.type.materials : [];
			},
			availableColors() {
				return this.colors.filter(color => this.availableColorsIds.includes(color.id));
			},
			filteredProducts(){
				if (this.colorsIds.length === 0) {
					return this.products;
				}
				return this.products.filter(product => this.colorsIds.includes(product.colorId));
			}
		},
		watch:{
			type(newVal,oldVal){
				if (newVal.id > 0 && oldVal.id > 0) {
					this.material = {id:0};
				}
				if (newVal.id > 0) {
					this.getProducts();
				}
			}
		},
		methods: {
			showProductConfigurator(product){
				this.currentProduct = product;
				this.$refs.product_configurator.visible = true;
			},
			setInitType(){
				this.type = {id:0,name:'Тип'}
				if (this.types.length > 0 && this.type_id > 0) {
					this.type = this.types.find(type => type.id == this.type_id);
				}
			},
			getProducts() {
				const query = this.getProductsQuery();
				axios.get(query)
					.then(response => {
						this.products = response.data.products;
						this.totalProducts = response.data.count;
						this.page=1;
						this.setAvailableColorsIds(response.data.colors);
					});
			},
			getProductsNextPage() {
				const query = this.getProductsQuery();
				this.page++;
				axios.get(query+'&page='+this.page)
					.then(response => {
						this.products = this.products.concat(response.data.products);
						this.totalProducts = response.data.count;
						this.addAvailableColorsIds(response.data.colors);
					});
			},
			getProductsQuery(){
				let query = '/api/calc/getCatalogProducts?';
				query += 'category=' + this.category.id;
				if (this.type.id > 0) {
					query += '&type=' + this.type.id;
				}
				if (this.material.id > 0) {
					query += '&material=' + this.material.id;
				}
				/*if (this.colorsIds.length > 0) {
					query += '&color=' + this.colorsIds.join(',');
				}*/
				return query;
			},
			setAvailableColorsIds(array) {
				this.availableColorsIds = array.map(item => parseInt(item));
			},
			addAvailableColorsIds(array) {
				this.availableColorsIds = this.availableColorsIds.concat(array.map(item => parseInt(item)));
			}
		}
	};
</script>

<style lang="scss">
	$orang: #fd971f;
	.mbtn{
		height: 40px;
		font-weight: bold;
		&_orange{
			background-color: $orang;
		}
	}
	.catalog-calculator{
		margin-top: 2em;
		.products{
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}
		.product{
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			border:1px solid #f3f6f8;
			border-radius: 10px;
			padding: 10px;
			margin: 10px;
			width: calc(1/4*100% - 20px);
			@media (max-width: 991px) {
				width: calc(1/3*100% - 20px);
			}
			@media (max-width: 767px) {
				width: calc(1/2*100% - 20px);
			}
			@media (max-width: 575px) {
				width: calc(100% - 20px);
			}
			img{
				max-width: 100%;
				object-fit: contain;
			}
			a{
				text-align: center;
			}
			&__name{
				font-weight: bold;
				text-align: center;
			}
			&__price {
				color: #1376ba;
				font-size: 20px;
				line-height: 32px;
				font-weight: 400;
				text-align: center;
				margin: 5px;
			}
			.mbtn{
				width: 98%;
				margin-right: 1%;
			}
		}
		
	}
</style>