<template>
    <div class="container">
        <h2>Carrinho de compras</h2>

        <div class="row">
            <div class="col-12" v-for="product in cart.products" :key="product.id">
                <div v-if="product.image">
                    <img :src="[`/storage/products/${product.image}`]" :alt="product.image" class="img-list">
                </div>
                <div v-else>
                    <img src="/images/sem-imagem.jpeg" :alt="product.image" class="img-list">
                </div>
                {{product.name}}
                <div>
                    <button @click.prevent="removeCart(product)" class="btn btn-danger">Remover Carrinho</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            cart() {
                return this.$store.state.cart
            }
        },
        methods: {
            removeCart (product) {
                this.$store.commit('REMOVE_PRODUCT_CART', product)
            }
        }
    }
</script>

<style scoped>
    .img-list {
        max-width: 100px;
    }
</style>
