<template>
	<div class="calc-parametr-typewrap-type " :class="{blink:!selectedItem.id}">
		<div class="type-head" @click="selector_opened = !selector_opened">
			<div class="type-text" >{{itemName}}</div>
		</div>
		<transition name="slide">
			<div class="type-body" v-show="selector_opened">
				<div
						v-for="item in items"
						:key="item.id"
						class="type-text"
						@click="changeItem(item)"
				>
					{{ item.name }}
				</div>
			</div>
		</transition>
	</div>
</template>

<script>
	export default {
    name: "v-drop-down-selector",
    data() {
      return {
        selector_opened: false,
        selectedItem: this.value
      };
    },
    props: ["items", "default_name", "value"],
    methods: {
      changeItem(item) {
        this.selectedItem = item;
        this.selector_opened = false;
        this.triggerEvent();
      },
      triggerEvent() {
        this.$emit('input', this.selectedItem);
      }
    },
    /*watch:{
      items(newVal,oldVal){
        this.selectedItem = {id: 0, name: ''};
      }
    },*/
		computed: {
			itemName() {
				return this.selectedItem.name ? this.selectedItem.name : this.default_name;
			}
		}
	}
</script>

<style lang="scss" scoped>
	$orang: #fd971f;
	.blink{
		animation-name: blink_border;
		animation-duration: 1s;
		animation-iteration-count: infinite;
		animation-direction: alternate;
		animation-delay: 1s;
	}
	
	@keyframes blink_border{
		0%{
			border: 4px solid #f0f0f0;
		}
		100%{
			border: 4px solid #2aa5cc;
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
	
	.calc-parametr-typewrap {
		
		&-type {
      background-color: #fff;
      cursor: pointer;
      position: relative;
      min-width: 170px;
      border: 1px solid rgba(0, 0, 0, .1);
      margin-left: 15px;
      margin-top: 5px;

      .type-text {
        padding: 10px 40px 10px 20px;
        position: relative;

        &:before {
          content: '';
          position: absolute;
          width: 0%;
					height: 2px;
					background: $orang;
					bottom: 0;
					left: 0;
					transition: all .5s
					
				}
				&:hover {
					background-color: #f0f0f0;
					&:before {
						width: 100%;
						transition: all 5s;
					}
				}
			}
			.type-head {
				position: relative;
				&:after {
					content: '';
					position: absolute;
					width: 15px;
					height: 15px;
					top: 15px;
					right: 10px;
					position: absolute;
					background: url(/img/down-arrow.svg) center no-repeat;
					background-size: cover;
				}
			}
			.type-body {
        position: absolute;
        top: 44px;
        left: 0;
        background: #fff;
        z-index: 4;
        width: 100%;
        min-width: 170px;
      }
		}
	}
</style>