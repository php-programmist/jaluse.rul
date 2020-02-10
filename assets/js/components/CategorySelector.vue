<template>
	<div class="calc-parametr-categori">
		<span
			v-for="(category,index) in categories"
			:class="{activ:category_index===index}"
			@click="setActive(index)"
		>
			{{category.name}}
		</span>
	</div>
</template>

<script>
	export default {
		name: "v-category-selector",
		data() {
			return {
				category_index:0
			};
		},
		props: ["categories"],
		methods: {
			setActive(index){
				this.category_index = index;
				this.triggerEvent();
			},
			triggerEvent() {
				if (typeof this.categories !== 'undefined' && this.categories.length) {
					this.$emit('input',this.categories[this.category_index]);
				}
			}
		}
	}
</script>

<style lang="scss" scoped>
	.calc-parametr-categori {
		margin: 0;
		padding: 15px 0 0;
		@media (max-width: 991px) {
			font-size: 14px;
		}
		span {
			display: inline-block;
			padding: 5px 10px;
			border: 1px solid #cccccc;
			font-weight: bold;
			cursor: pointer;
			transition: all .5s;
			margin: 0 5px 0 0;
			&.activ {
				background-color: #cccccc;
			}
		}
		
	}
</style>