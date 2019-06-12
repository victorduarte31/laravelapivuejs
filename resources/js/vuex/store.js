import Vue from 'vue'
import Vuex from 'vuex'

import categories from './modules/categories/categories'
import products from './modules/products/products'
import preloader from './modules/preloader/preloader'
import cart from "./modules/cart/cart";
import auth from "./modules/auth/auth";
import profile from "./modules/users/profile";


Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        categories,
        products,
        preloader,
        cart,
        auth,
        profile
    }
});
