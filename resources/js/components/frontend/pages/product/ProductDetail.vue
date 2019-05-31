<template>
    <div>
        <h1> {{product.name}} </h1>
        <div v-if="product.image">
            <img :src="[`/storage/products/${product.image}`]" :alt="product.image" class="img-list">
        </div>
        <div v-else>
            <img src="/images/sem-imagem.jpeg" :alt="product.image" class="img-list">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product: {}
            }
        },
        created() {
            this.loadProduct()
        },
        props: ['id'],
        methods: {
            loadProduct() {
                this.$store.dispatch('loadProduct', this.id)
                    .then(response => this.product = response)
            }
        }
    }
</script>

<style scoped>

</style>
