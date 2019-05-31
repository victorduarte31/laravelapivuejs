<template>
    <div>
        <form class="form" @submit.prevent="onSubmit">

            <!-- Upload de imagem -->
            <div :class="['form-group', {'alert alert-warning': errors.image}] ">
                <div v-if="errors.image">{{errors.image[0]}}</div>

                <div v-if="imagePreview" class="text-center">
                    <img :src="imagePreview" class="image-preview">
                    <button @click="removePreview" class="btn btn-danger">Remover</button>
                </div>

                <div v-else class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Upload</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" @change="onFileChange">
                        <label class="custom-file-label" for="inputGroupFile01">Escolher arquivo</label>
                    </div>
                </div>
            </div>
            <!-- Fim Upload de imagem -->

            <div :class="['form-group', {'alert alert-warning': errors.name}] ">
                <div v-if="errors.name">{{errors.name[0]}}</div>
                <label>Nome do Produto</label>
                <input type="text" v-model="product.name" class="form-control" placeholder="Nome do Produto">
            </div>

            <div :class="['form-group', {'alert alert-warning': errors.description}] ">
                <div v-if="errors.description">{{errors.description[0]}}</div>
                <label>Descrição do Produto</label>
                <textarea type="text" v-model="product.description" class="form-control"
                          placeholder="Descrição do Produto"></textarea>
            </div>

            <!-- Carregando as categorias para fazer a associação -->
            <div :class="['form-group', {'alert alert-warning': errors.category_id}] ">
                <div v-if="errors.category_id">{{errors.category_id[0]}}</div>
                <select v-model="product.category_id" class="custom-select">
                    <option value="">Selecione a categoria</option>
                    <option :value="category.id" v-for="category in categories" :key="category.id">
                        {{category.name}}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            update: {
                required: false,
                type: Boolean,
                default: false,
            },
            product: {
                require: false,
                type: Object,
            }
        },
        data() {
            return {
                errors: {},
                upload: null,
                imagePreview: null
            }
        },
        methods: {
            onSubmit() {
                let action = this.update ? 'updateProduct' : 'storeProduct'; // um unico metodo responsavel por cadastrar e editar

                // Ao trabalhar com upload crio um objeto de FormData e passo atraves do metodo append os valores separadamente
                // e adiciono essa constante de formData como parametro na action
                const formData = new FormData();

                if (this.upload != null)
                    formData.append('image', this.upload);

                formData.append('id', this.product.id);
                formData.append('name', this.product.name);
                formData.append('description', this.product.description);
                formData.append('category_id', this.product.category_id);

                this.$store.dispatch(action, formData)
                    .then(() => {
                        this.$snotify.success('Ação executada com sucesso');

                        this.reset();

                        this.$emit('success')
                    })
                    .catch(errors => {
                        this.$snotify.error('Algo errado', 'Erro');
                        this.errors = errors.data.errors
                    })
            },
            reset() {
                this.errors = {};
                this.imagePreview = null;
                this.upload = null;
            },

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;

                this.upload = files[0];

                this.previewImage(files[0])

            },

            previewImage(file) {
                let reader = new FileReader(); // Classe do Java Script para trabalhar com visualização de imagens

                reader.onload = (e) => {
                    this.imagePreview = e.target.result; // carregando a preview da imagem
                };

                reader.readAsDataURL(file);
            },

            removePreview () {
                this.imagePreview = null;
                this.upload = null;
            },
        },
        computed: {
            categories() {
                return this.$store.state.categories.items.data
            }
        }
    }
</script>

<style scoped>
    .image-preview {
        max-width: 60px;
    }
</style>
