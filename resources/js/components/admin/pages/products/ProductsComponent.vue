<template>
    <div>
        <h1>Listagem de produtos</h1>

        <div class="row">
            <div class="col">
                <button @click.prevent="create" class="btn btn-success">
                    Novo
                </button>

                <!-- Modal responsavel por cadastrar novo produto -->
                <vodal :show="showModal"
                       animation="zoon"
                       @hide="hideModal"
                       :width="600"
                       :height="500">

                    <!-- COMPONENTE RESPONSAVEL POR CADASTRAR OU EDITAR -->
                    <product-form
                        @success="success"
                        :update="update"
                        :product="product"

                    ></product-form>

                </vodal>

            </div>
            <div class="col">

                <!-- COMPONENT DE BUSCA -->
                <search @search="searchForm"></search>

            </div>
        </div>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th width="200">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products.data" :key="product.id">
                <td v-if="product.image">
                <img :src="[`/storage/products/${product.image}`]" :alt="product.image" class="img-list">
            </td>
                <td v-else>...</td>
                <td>{{product.name}}</td>
                <td>{{product.description}}</td>
                <td>
                    <a class="btn btn-outline-info" href="#" @click.prevent="edit(product.id)">Editar</a>
                    <destroy :item="product"
                      @destroy="destroy"
                    ></destroy>
                </td>
            </tr>
            </tbody>
        </table>

        <paginate
            :pagination="products"
            :offset="6"
            @paginate="loadProducts"
        ></paginate>

    </div>
</template>

<script>
    import PaginationComponent from "../../../layouts/PaginationComponent";
    import SearchComponent from "../../layouts/SearchComponent";
    import ProductFormComponent from "./form/ProductFormComponent";
    import ButtonDestroy from "../../layouts/ButtonDestroy";
    import Vodal from "vodal"


    export default {
        data() {
            return {
                search: '',
                showModal: false,
                product: {
                    id: '',
                    name: '',
                    description: '',
                    category_id: '',
                },
                update: false,
            }
        },
        created() {
            this.loadProducts(1)
        },
        methods: {
            loadProducts(page) {
                this.$store.dispatch('loadProducts', {...this.params, page})
            },

            searchForm(filter) {
                this.search = filter;

                this.loadProducts(1)
            },

            hideModal() {
                this.showModal = false
            },

            success() {
                this.hideModal();
                this.loadProducts(1)
            },

            edit(id) {
                this.reset();

                this.$store.dispatch('loadProduct', id)
                    .then(response => {
                        this.product = response;
                        this.showModal = true;
                        this.update = true;
                    })
                    .catch(() => {
                        this.$snotify.error('Erro ao carregar o produto', 'Erro');
                    })
            },

            create() {
                this.update = false;
                this.reset();
                this.showModal = true;
            },

            reset() {
                this.product = {
                    id: '',
                    name: '',
                    description: '',
                    category_id: '',
                }
            },

            destroy(id) {
                this.$store.dispatch('destroyProduct', id)
                    .then(response => {
                        this.$snotify.success('Produto deletado com sucesso!', 'Sucesso');
                        this.loadProducts(1)
                    })
                    .catch(() => {
                        this.$snotify.error('Erro ao carregar o produto', 'Erro');
                    })
            }
        },
        computed: {
            products() {
                return this.$store.state.products.items
            },
            params() {
                return {
                    page: this.products.current_page,
                    filter: this.search
                }
            }
        },
        components: {
            paginate: PaginationComponent,
            search: SearchComponent,
            productForm: ProductFormComponent,
            destroy: ButtonDestroy,
            vodal: Vodal,
        }
    }
</script>

<style scoped>
.img-list {
    max-width: 100px;
}
</style>
