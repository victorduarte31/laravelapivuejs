<template>
    <div>
        <form class="form form-inline" @submit.prevent="search">
            <select v-model="category_id" class="custom-select">
                <option value="">Selecione a categoria</option>
                <option :value="category.id" v-for="category in categories" :key="category.id">
                    {{category.name}}
                </option>
            </select>

            <input type="text" v-model="filter" class="form-control mr-sm-2" placeholder="Pesquisar:">

            <button type="submit" class="btn btn-outline-success">Pesquisar</button>
        </form>
    </div>
</template>

<script>
    export default {
        methods: {
            search() {
                this.$emit('search', {
                    filter: this.filter,
                    category_id: this.category_id,
                }) // $emit envia a ação para o componente pai, ou seja, aonde esta sendo utilizado o component que disparou o metodo
            }
        },
        data() {
            return {
                filter: '',
                category_id: '',
            }
        },
        computed: {
            categories() {
                return this.$store.state.categories.items.data
            }
        }
    }
</script>

<style scoped>

</style>
