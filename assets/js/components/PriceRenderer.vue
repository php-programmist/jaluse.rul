<template>
	<div class="calc-vivod-price">
    <div class="row">
      <div class="col-md-6 col-12">
        <div class="starcena">{{ prices.basePrice }}₽ <span>-{{ prices.currentDiscount }}%</span></div>
      </div>
      <div class="col-md-6 col-12">
        <div class="new-cenawrap">
          <div class="row">
            <div class="col-6 bigcena"><b>{{ prices.discountedPrice }}₽</b></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
	export default {
		data() {
			return {};
		},
		props: ["prices"],
	}
</script>

<style lang="scss" scoped>
	$text-grey: rgba(54, 54, 54, 0.8);
	$orang: #fd971f;
	.calc-vivod {
		&-price {
			color: $text-grey;
			margin-top: 20px;
			margin-bottom: 20px;
			font-size: 14px;
			.starcena {
				font-size: 28px;
				display: inline-block;
				position: relative;
				margin-left: 5px;
				&:before {
					content: '';
					position: absolute;
					width: 110%;
					height: 2px;
					background-color: $text-grey;
					top: 50%;
					left: -5%;
					transform: translateY(-50%);
					
				}
				span {
					display: inline-block;
					position: absolute;
					top: 50%;
					right: -70px;
					transform: translateY(-50%);
					margin-left: 12px;
					padding: 0 7px;
					background: $orang;
					font: 300 15px/25px 'Roboto', serif;
					color: #fff;
					box-shadow: 0 0 50px rgba(204, 80, 108, .5);
				}
				
			}
			.new-cenawrap {
				margin-top: 10px;
				.bigcena {
					b {
						display: block;
						font-size: 49px;
						font-weight: 400;
						line-height: 1;
					}
				}
				.cena {
					b {
						padding-top: 10px;
						display: block;
						font-size: 40px;
						font-weight: 400;
						line-height: 1;
					}
				}
			}
			
		}
	}
</style>