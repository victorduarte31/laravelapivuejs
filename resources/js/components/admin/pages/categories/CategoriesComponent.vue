<template>
    <div>
        <h1>Listagem das Categorias</h1>

        <div class="row">
            <div class="col">
                <router-link class="btn btn-success" :to="{name: 'admin.categories.create'}">Cadastrar</router-link>
            </div>
            <div class="col">
                <search @searchCategory="buscar"></search>
            </div>
        </div>
        <hr>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th width="180">AÇÕES</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(category, index) in categories" :key="index">
                <td>{{category.id}}</td>
                <td>{{category.name}}</td>
                <td>
                    <router-link class="btn btn-outline-info"
                                 :to="{name: 'admin.categories.edit', params: {id: category.id}}">
                        Editar
                    </router-link>
                    <destroy :item="category"
                             @destroy="destroy"
                    ></destroy>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import SearchCategoryComponent from "./add-edit-form/SearchCategoryComponent";
    import ButtonDestroy from "../../layouts/ButtonDestroy";

    export default {
        created() {
            this.loadCategory()  // passamos sempre a actions
        },
        data() {
            return {
                name: '',
            }
        },
        computed: {
            categories() {
                return this.$store.state.categories.items.data
            }
        },
        methods: {
            destroy(id) {
                this.$store.dispatch('destroyCategory', id)
                    .then(() => {
                        this.$snotify.success('Categoria deletada com sucesso!');
                        this.loadCategory()
                    })
                    .catch(error => {
                        console.log(error);
                        this.$snotify.error('Erro ao deletar a categoria', 'Falha')
                    })
            },

            loadCategory() {
                this.$store.dispatch('loadCategories', {name: this.name})
            },

            buscar(filter) {
                this.name = filter;
                this.loadCategory()
            }
        },
        components: {
            search: SearchCategoryComponent,
            destroy: ButtonDestroy,
        }
    }
</script>

<style scoped>

</style>
