<template>
	<div class="product_configurator">
		<div class="product_configurator__dimension">
			<div class="bigzag">Задайте размер:</div>
			<div class="dimension_row">
				<div class="dimension_wrapper">
          <label for="width">Ширина, см</label>
          <input id="width" type="number" placeholder="Ширина, см" v-model.number="width">
        </div>
        <div class="dimension_wrapper">
          <label for="height">Высота, см</label>
          <input id="height" type="number" placeholder="Высота, см" v-model.number="height">
        </div>
			</div>
		</div>
		<div class="calc-parametr__control">
      <div class="bigzag d-none d-md-block">Выберите тип управления:</div>
      <input class="d-none d-md-inline" type="radio" id="controlTypeManual" value="Ручное" v-model="controlType">
      <label class="d-none d-md-inline" for="controlTypeManual">Ручное</label>
      <input class="d-none d-md-inline" type="radio" id="controlTypeAuto" value="Электропривод" v-model="controlType">
      <label class="d-none d-md-inline" for="controlTypeAuto">Электропривод</label>
      <div class="mt-4 mt-md-0">
        <b>Количество изделий:</b>
        <select v-model="number" @input="triggerEvent">
          <option v-for="i in 10" :value="i">{{ i }}</option>
        </select>
      </div>
      <i class="d-none d-md-block">Изготовим за 1-3 рабочих дня</i>
    </div>
	</div>
</template>

<script>
	export default {
    data() {
      return {
        width: 100,
        height: 100,
        controlType: 'Ручное',
        number: 1
      };
    },
    props: ["calculationType"],
    methods: {
      triggerEvent() {
        this.$emit('input', {
          width: this.width,
          height: this.height,
          controlType: this.controlType,
          number: this.number
        });
      }
    },
    mounted() {
      this.triggerEvent();
    },
    updated() {
      this.$nextTick(() => {
        this.triggerEvent()
      });
    },
    watch: {
      calculationType: function (newVal, oldVal) {
        if (newVal === 'matrix') {
          this.width = 40;
          this.height = 50;
        } else if (oldVal === 'matrix' && newVal === 'simple') {
          this.width = 100;
          this.height = 100;
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
	.product_configurator{
		&__dimension{
			padding-top: 20px;
			.bigzag{
				font-weight: bold;
				font-size: 20px;
				margin-bottom: 15px;
			}
			.dimension_row{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
      }
			.dimension_wrapper {
        display: flex;
        flex-direction: column;
        max-width: 50%;
        min-width: 150px;
      }
			input{
        margin-right: 15px;
        padding: 5px;
        outline: none !important;
        border: 1px solid rgba(0, 0, 0, .1);

        &:focus {
          border: 1px solid #2aa5cc;
        }
      }
			
		}
		&__control{
			margin-top: 20px;
			label{
				cursor: pointer;
				margin-right: 40px;
			}
			i{
				color: rgba(54, 54, 54, 0.8);
				margin-top: 15px;
				display: inline-block;
				font-size: 14px;
			}
		}
		
	}
	
</style>