<template>
	<div>
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
				<select v-model="number" @input="triggerEvent">
					<option v-for="i in 10" :value="i">{{i}}</option>
				</select>
			</div>
			<i>Изготовим за 1-3 рабочих дня</i>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				width: 1000,
				height: 1000,
				controlType: 'Ручное',
				number: 1
			};
		},
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
		}
	}
</script>

<style lang="scss" scoped>
	$blue: #2aa5cc;
	$text-grey: rgba(54, 54, 54, 0.8);
	.calc-parametr{
		.bigzag{
			font-weight: bold;
			font-size: 20px;
			margin-bottom: 15px;
		}
		&-razmer{
			padding-top: 20px;
			input{
				max-width: 300px;
				margin-right: 15px;
				padding: 5px;
				outline: none!important;
				border: 1px solid rgba(0,0,0, .1);
				&:focus{
					border: 1px solid $blue;
				}
			}
			
		}
		&-tipu{
			margin-top: 20px;
			label{
				cursor: pointer;
				margin-right: 40px;
			}
			i{
				color: $text-grey;
				margin-top: 15px;
				display: inline-block;
				font-size: 14px;
			}
		}
	}
	
</style>