<template>
    <div>
        <h1>Adicionar nova categoria</h1>

        <form-cat></form-cat>
    </div>
</template>

<script>
    import FormCategoryComponent from "./add-edit-form/FormCategoryComponent";

    export default {
        components: {
            formCat: FormCategoryComponent
        }
    }
</script>

<style scoped>

</style>
