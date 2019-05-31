<template>
    <div>
        <ul class="nav">
            <li class="nav-item">
                <router-link :to="{name: 'home'}" class="nav-link">Home</router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{name: 'contact'}" class="nav-link">Contato</router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{name: 'cart'}" class="nav-link">Carrinho ({{cart.length}})</router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{name: 'auth'}" class="nav-link">Entrar</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        computed: {
            cart() {
                return this.$store.state.cart.products
            }
        }
    }
</script>

<style scoped>

</style>
