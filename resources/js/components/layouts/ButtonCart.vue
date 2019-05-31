<template>
    <div>
        <div v-if="notCart">
            <button @click.prevent="addCart" class="btn btn-info">Adicionar Carrinho</button>
        </div>
        <div v-else>
            <button @click.prevent="removeCart" class="btn btn-danger">Remover Carrinho</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        methods: {
            addCart () {
                this.$store.commit('ADD_PRODUCT_CART', this.product)
            },

            removeCart () {
                this.$store.commit('REMOVE_PRODUCT_CART', this.product)
            }
        },
        computed : {
            notCart () {
                return this.$store.state.cart.products.indexOf(this.product) < 0
            }
        }
    }
</script>

<style scoped>

</style>
