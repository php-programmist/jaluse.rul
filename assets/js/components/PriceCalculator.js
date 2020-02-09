export default class PriceCalculator {
	constructor(discount_global,delivery_cost,usd_rate,matrices) {
		this.discount_global = discount_global;
		this.delivery_cost = delivery_cost;
		this.usd_rate = usd_rate;
		this.matrices = matrices;
	}
	
	getCurrentDiscount() {
		if (!this.product.discount || this.product.discount < 1) {
			return this.currentDiscount = this.discount_global;
		}
		return this.currentDiscount = this.product.discount;
	}
	getAllPrices(product,width,height,number){
		this.product = product;
		this.width = width;
		this.height = height;
		this.number = number;
		const currentDiscount = this.getCurrentDiscount();
		const basePrice = this.getBasePrice();
		const discountedPrice = this.getDiscountedPrice();
		const priceWithDelivery = this.getPriceWithDelivery();
		return {basePrice,discountedPrice,priceWithDelivery,currentDiscount};
	}
	getBasePrice() {
		if (this.product.id === 0 || !this.width || !this.height) {
			return this.basePrice = 0;
		}
		if (this.product.calculationType === 'simple') {
			let area = this.width * this.height;
			if (area < 1000000) {
				area = 1000000;
			}
			return this.basePrice = parseInt(this.number * this.product.price * this.usd_rate * area / 1000000);
		}else if(this.product.calculationType === 'matrix'){
			const matrix_folder = this.product.matrixFolder;
			const matrix_name = this.product.matrixId;
			if (matrix_name && matrix_folder) {
				const matrix_set = this.matrices[matrix_folder];
				const matrix = matrix_set[matrix_name];
				for(let width in matrix){
					if (this.width <= width) {
						for(let height in matrix[width]){
							if (this.height <= height) {
								return this.basePrice = parseInt(this.number * matrix[width][height] * this.usd_rate);
							}
						}
					}
				}
			}
			
		}
		return this.basePrice = 0;
	}
	getDiscountedPrice() {
		return this.discountedPrice = parseInt(this.basePrice * (100 - this.currentDiscount) / 100);
	}
	
	getPriceWithDelivery() {
		return this.discountedPrice + this.delivery_cost;
	}
}