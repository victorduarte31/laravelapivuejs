<template>
    <div>
        <form class="form form-inline" @submit.prevent="search">

            <input type="text" v-model="filter" class="form-control mr-sm-2" placeholder="Pesquisar:">
            <button type="submit" class="btn btn-outline-success">Pesquisar</button>
            <div v-if="filter">
                <p>Resultados para: {{ filter }}</p>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        methods: {
            search() {
                this.$emit('search', this.filter) // $emit envia a ação para o componente pai, ou seja, aonde esta sendo utilizado o component que disparou o metodo
            }
        },
        data() {
            return {
                filter: ''
            }
        }
    }
</script>

<style scoped>

</style>
