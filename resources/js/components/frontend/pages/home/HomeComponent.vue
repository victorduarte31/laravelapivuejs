<template>
    <div class="container">
        <h1>Produtos</h1>

        <search @search="search"></search>
        <hr>

        <div class="row">
            <Item
                v-for="product in products.data" :key="product.id"
                :item="product"
                :path="'products'">

            </Item>
        </div>

        <hr>
        <paginate
            :pagination="products"
            @paginate="loadProducts"
        ></paginate>
    </div>
</template>

<script>
    import PaginationComponent from "../../../layouts/PaginationComponent";
    import Item from "../../../layouts/Item";
    import Search from "./partials/Search";

    export default {
        data() {
            return {
                filter: '',
                category_id: '',
            }
        },
        created() {
            if (this.products.data.length === 0)
                this.$store.dispatch('loadProducts', {})
        },
        computed: {
            products() {
                return this.$store.state.products.items
            },
            params() {
                return {
                    filter: this.filter,
                    page: this.products.current_page,
                    category_id: this.category_id
                }
            }
        },
        methods: {
            loadProducts(page = 1) {
                this.$store.dispatch('loadProducts', {...this.params, page})
            },

            search(values) {
                this.filter = values.filter;
                this.category_id = values.category_id;
                this.loadProducts();
            }
        },
        components: {
            paginate: PaginationComponent,
            Item,
            Search
        }
    }
</script>

<style scoped>

</style>
