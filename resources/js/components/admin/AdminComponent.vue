<template>
    <div>
        <nav class="navbar">
            <ul class="nav ">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{name: 'admin.dashboard'}">Dashboard</router-link>
                </li>
                <li>
                    <router-link class="nav-link" :to="{name: 'admin.categories'}">Categorias ({{totalCategories}})
                    </router-link>
                </li>
                <li>
                    <router-link class="nav-link" :to="{name: 'admin.products'}">Produtos</router-link>
                </li>
            </ul>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>

    </div>
</template>

<script>
    export default {
        computed: {
            totalCategories() {
                return this.$store.state.categories.items.data.length
            }
        }
    }
</script>

<style scoped>

</style>
