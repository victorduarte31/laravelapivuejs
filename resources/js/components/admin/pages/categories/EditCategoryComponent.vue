<template>
    <div>
        <h1>Editar Categoria</h1>

        <form-cat
            :category="category"
            :updating="true"
        ></form-cat> <!-- updating = true informa que estou tentando editar a categoria -->
    </div>
</template>

<script>
    import FormCategoryComponent from "./add-edit-form/FormCategoryComponent";
    import admin from "../../../../vuex/store";

    export default { // Para editar uma categoria e obrigatorio o id do item, por isso adicionado os props
        props: {
            id: {
                required: true
            }
        },
        created() {
            this.loadCategory()
        },
        components: {
            formCat: FormCategoryComponent
        },
        data() {
            return {
                category: {}
            }
        },
        methods: {
            loadCategory() {
                this.$store.dispatch('loadCategory', this.id) // passamos sempre a actions
                    .then(response => this.category = response)
                    .catch(error => {
                        this.$snotify.error('Categoria não encontrada', '404');
                        this.$router.push({name: admin.categories})
                    })
            }
        }
    }
</script>

<style scoped>

</style>
