import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../vuex/store'

import AdminComponent from '../components/admin/AdminComponent'
import CategoriesComponent from '../components/admin/pages/categories/CategoriesComponent'
import DashboardComponent from '../components/admin/pages/dashboard/DashboardComponent'
import AddCategoryComponent from '../components/admin/pages/categories/AddCategoryComponent'
import EditCategoryComponent from '../components/admin/pages/categories/EditCategoryComponent'
import ProductsComponent from "../components/admin/pages/products/ProductsComponent";
import HomeComponent from "../components/frontend/pages/home/HomeComponent";
import SiteComponent from "../components/frontend/SiteComponent";
import ContactComponent from "../components/frontend/pages/contact/ContactComponent";
import ProductDetail from "../components/frontend/pages/product/ProductDetail";
import CartComponent from "../components/frontend/pages/cart/CartComponent";
import LoginComponent from "../components/frontend/pages/login/LoginComponent";

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: SiteComponent,
        children: [
            {path: 'produto/:id', component: ProductDetail, name: 'product.detail', props: true},
            {path: '', component: HomeComponent, name: 'home'},
            {path: 'contato', component: ContactComponent, name: 'contact'},
            {path: 'carrinho', component: CartComponent, name: 'cart'},
            {path: 'login', component: LoginComponent, name: 'auth', meta: {auth: false}},
        ]
    },
    {
        path: '/admin',
        component: AdminComponent,
        name: 'admin',
        meta: {auth: true},
        children: [ // Todas as rotas que pertencem ao setor de admin serão listadas
            // rotas de categorias
            {path: '', component: DashboardComponent, name: 'admin.dashboard'},
            {path: 'categories', component: CategoriesComponent, name: 'admin.categories'},
            {path: 'categories/create', component: AddCategoryComponent, name: 'admin.categories.create'},
            {path: 'categories/:id/edit', component: EditCategoryComponent, name: 'admin.categories.edit', props: true},

            // rotas de produtos
            {path: 'products', component: ProductsComponent, name: 'admin.products'} // adicionado o parametro meta que recebe um objeto na qual vamos utilizar para fazer a validação onde so pessoas autenticadas podem acessar o link de produtos
        ]
    },
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.auth && !store.state.auth.authenticated) {
        store.commit('CHANGE_URL_BACK', to.name);


        return router.push({name: 'login'})
    }

    if (to.matched.some(record => record.meta.auth) && !store.state.auth.authenticated) {
        store.commit('CHANGE_URL_BACK', to.name);

        return router.push({name: 'login'})
    }

    if (to.meta.hasOwnProperty('auth') && !to.meta.auth && store.state.auth.authenticated) {
        return router.push({name: 'admin.dashboard'})
    }


    next()

});

export default router

