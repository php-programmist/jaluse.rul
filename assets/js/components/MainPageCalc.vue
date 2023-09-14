<template>
  <form action="#">
    <div class="calc-wrap">
      <div class="row">
        <div class="col-lg-7 col-md-6 calc-parametr">
          <div class="calc-parametr-typewrap">
            <div class="row">
              <div class="type_selector" v-show="!type_hidden">
                <v-drop-down-selector
                    :items="types"
                    :default_name="'Выбрать вид'"
                    v-model="type"
                ></v-drop-down-selector>
              </div>
              <transition name="slide-fade">
                <div class="material_selector" v-show="materials.length > 0 && !material_hidden">
                  <v-drop-down-selector
                      :items="materials"
                      default_name="Выбрать изделие"
                      v-model="material"
                      @input="getProducts"
                  ></v-drop-down-selector>
                </div>
              </transition>
            </div>

          </div>
          <div class="calc-parametr-color">
            <div class="minzag colorzag" @click.prevent="toggleColorSelector()">Цвет:</div>
            <transition name="slide">
              <div class="bgcolor-wrap" v-show="color_opened">
                <div
                    v-for="(color,index) in availableColors"
                    :key="color.id"
                    class="bgcolor-wrap-color"
                    :class="{colorActive:colorsIds.includes(color.id)}"
                    :title="color.name"
                    :style="'background-color:'+color.hex"
                    @click.prevent="toggleColorId(color.id)"
                ></div>
              </div>
            </transition>
          </div>
          <v-category-selector
              v-show="isShowCategories"
              :categories="categories"
              v-model="category"
              @input="getProducts"
          ></v-category-selector>
          <div class="calc-parametr-minimages">
            <div
                class="minimages-wrap"
                v-for="(product,index) in products"
                :key="product.id"
            >
              <div class="minimages" @click.prevent="setActiveProductIndex(index)">
                <img :src="product.imageSmall" alt="">
              </div>
            </div>
          </div>
          <v-product-configurator v-model="productConfigs"
                                  v-if="!isMobile"
                                  :calculationType="currentProduct.calculationType" />

        </div>
        <div class="col-lg-5 col-md-6 calc-vivod align-self-center">
          <div class="calc-vivod-imgwrap">
            <img :src="currentProduct.imageBig" alt="*">
          </div>
          <div class="product-name">
            {{ currentProduct.name }}
          </div>
          <div class="w-100">
            <v-price-renderer :prices="prices"></v-price-renderer>
            <div class="calc-vivod-opis">
              <div class="row">
                <div class="calc-vivod-opis-text col-sm-6">

                  <div><b>Размеры: </b><span>{{ productConfigs.width }}</span> СМ X
                    <span>{{ productConfigs.height }}</span> СМ
                  </div>
                  <div><b>Цвет: {{ currentProduct.colorName }}</b></div>
                </div>
                <div class="calc-vivod-opis-text col-sm-6 d-none d-md-block">
                  <div><b>Управление: </b><span>{{ productConfigs.controlType }}</span></div>
                  <div><b>Подтип: </b><span>{{ currentProduct.materialName }}</span></div>
                </div>

              </div>
            </div>
            <v-product-configurator v-model="productConfigs"
                                    v-if="isMobile"
                                    :calculationType="currentProduct.calculationType" />
            <div class="button-wrapper">
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
      </div>

    </div>
  </form>
</template>

<script>
import axios from 'axios';
import ConsultationForm from './ConsultationForm';
import OrderForm from './OrderForm';
import PriceCalculator from './PriceCalculator'
import PriceRenderer from './PriceRenderer'
import ProductConfigurator from './ProductConfigurator'
import CategorySelector from './CategorySelector';
import DropDownSelector from './DropDownSelector';

export default {
  data() {
    return {
      types: [],
      colors: [],
      availableColorsIds: [],
      colorsIds: [],
      products: [],
      categories: [],
      category: {id: this.selected_category},
      type: this.getPreSelectedType(),
      material: this.getPreSelectedMaterial(),
      product_index: 0,
      type_opened: false,
      type_hidden: false,
      material_opened: false,
      material_hidden: false,
      color_opened: true,
      price_calculator: null,
      productConfigs: {}
    };
  },
  props: ["type_filter", "available_types", "selected_type", "selected_material", "hide_categories", "selected_category", "excluded_materials"],
  components: {
    'v-consultation-form': ConsultationForm,
    'v-order-form': OrderForm,
    'v-price-renderer': PriceRenderer,
    'v-product-configurator': ProductConfigurator,
    'v-category-selector': CategorySelector,
    'v-drop-down-selector': DropDownSelector,
  },
  created() {
    axios.get('/api/calc/getInitData')
        .then(response => {
          if (typeof this.available_types !== 'undefined' && null !== this.available_types) {
            this.types = response.data.types.filter(type => this.available_types.indexOf(type.id) > -1);
            if (this.excluded_materials.length > 0) {
              this.types = this.types.map(type => {
                type.materials = type.materials.filter(material => this.excluded_materials.indexOf(material.id) === -1);
                return type;
              })
            }
          } else {
            this.types = response.data.types;
          }

          if (typeof this.type_filter !== 'undefined') {
            this.types = this.types.filter(type => this.type_filter.includes(type.id));
          }
          if (typeof this.selected_type !== 'undefined' && parseInt(this.selected_type) > 0) {
            this.type = this.types.filter(type => parseInt(type.id) === parseInt(this.selected_type)).shift();
            this.type_hidden = true;
          }
          if (typeof this.selected_material !== 'undefined' && parseInt(this.selected_material) > 0) {
            this.material = this.type.materials.filter(material => parseInt(material.id) === parseInt(this.selected_material)).shift();
            this.material_hidden = true;
          }
          this.colors = response.data.colors;
          this.categories = response.data.categories;
          this.category = this.categories.find(category => +category.id === +this.selected_category);
          const matrices = response.data.matrices;
          const priceConfigs = response.data.priceConfigs;
          this.price_calculator = new PriceCalculator(priceConfigs, matrices);
          this.getProducts();
        });

  },

  computed: {
    isMobile() {
      return document.documentElement.clientWidth <= 576;
    },
    materials() {
      return this.type.id > 0 ? this.type.materials : [];
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
      if (!this.price_calculator || typeof this.price_calculator.getAllPrices === 'undefined') {
        return {basePrice: 0, discountedPrice: 0, priceWithDelivery: 0, currentDiscount: 0};
      }

      return this.price_calculator.getAllPrices(this.currentProduct, this.productConfigs);

    },
    isShowCategories() {
      if (this.type.id === 0) {
        return true;
      }
      return !this.type.hideCategories && !this.hide_categories;
    }
  },
  watch: {
    type(newVal, oldVal) {
      if (newVal.id > 0 && oldVal.id > 0 && newVal.id !== oldVal.id) {
        this.material = {id: 0};
      }
      if (newVal.id > 0) {
        this.getProducts();
      }
    }
  },
  methods: {
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
      let query = '/api/calc/getProducts?';
      query += 'category=' + this.category.id;
      const currentType = this.type.id > 0 ? this.type : this.types[0];
      const currentMaterial = this.material.id > 0 ? this.material : currentType.materials[0];

      query += '&type=' + currentType.id;
      if (currentMaterial) {
        query += '&material=' + currentMaterial.id;
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
    getPreSelectedType() {
      let id = 0
      if (typeof this.selected_type !== 'undefined') {
        id = parseInt(this.selected_type);
      }
      return {id};
    },
    getPreSelectedMaterial() {
      let id = 0
      if (typeof this.selected_material !== 'undefined') {
        id = parseInt(this.selected_material);
      }
      return {id};
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
  display: flex;
  flex-direction: column;
  @media (max-width: 768px) {
    margin-top: 20px;
  }

  .product-name {
    font-weight: bold;
    @media (max-width: 768px) {
      order: -1;
    }
  }

  &-imgwrap {
    text-align: center;

    img {
      max-width: 100%;
    }
  }

  &-opis {
    margin-bottom: 20px;
    @media (max-width: 576px) {
      display: none;
    }

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