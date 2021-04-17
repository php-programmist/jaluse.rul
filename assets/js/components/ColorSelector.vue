<template>
	<div class="calc-parametr-color">
		<div class="colorzag" @click="selector_opened = !selector_opened">Цвет:</div>
		<transition name="slide">
			<div class="bgcolor-wrap" v-show="selector_opened">
				<div
						v-for="(color,index) in items"
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
</template>

<script>
	export default {
		name: "v-color-selector",
		data() {
			return {
				selector_opened: true,
				colorsIds: []
			};
		},
		props: ["items"],
		methods: {
			toggleColorId(colorId) {
        if (this.colorsIds.includes(colorId)) {
          this.colorsIds = this.colorsIds.filter(value => value !== colorId);
        } else {
          this.colorsIds.push(colorId);
        }
        this.triggerEvent();
        this.$emit('changed', this.colorsIds);
      },
      triggerEvent() {
        this.$emit('input', this.colorsIds);
      },
      resetColors() {
        this.colorsIds = [];
      }
    },
		watch:{
			items(newVal,oldVal){
				this.colorsIds = this.colorsIds.filter(selectedId => newVal.find(color => color.id == selectedId));
				this.triggerEvent();
			}
		}
	}
</script>

<style lang="scss" scoped>
	$blue: #2aa5cc;
	.calc-parametr-color{
		margin-top: 15px;
		padding-left: 20px;
		.colorzag{
			padding-left: 20px;
			cursor: pointer;
			position: relative;
			&:before{
				content: '';
				width: 15px;
				height: 15px;
				top: 50%;
				left: 0;
				transform: translateY(-50%);
				position: absolute;
				background: url(/img/down-arrow.svg) center no-repeat;
				background-size: cover;
				
			}
		}
		.bgcolor-wrap{
			&-color{
				display: inline-block;
				width: 30px;
				height: 30px;
				margin-right: 12px;
				margin-top: 12px;
				position: relative;
				cursor: pointer;
				&:before{
					content: '';
					width: 40px;
					height: 40px;
					border: 1px solid $blue;
					position: absolute;
					left: -5px;
					top: -5px;
					opacity: 0;
				}
				&:hover{
					&:before{
						opacity: 9;
					}
				}
				
			}
			.colorActive{
				&:before{
					opacity: 1;
				}
			}
		}
	}
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
</style>