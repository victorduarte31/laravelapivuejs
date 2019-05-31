<template>
    <div>
        <a href="#" @click.prevent="confirmDelete(item)" class="btn btn-outline-danger">Deletar</a>
    </div>
</template>

<script>
    export default {
        props: {
            item: {
                require: true,
                type: Object,
            }
        },
        methods: {
            confirmDelete(item) {
                this.$snotify.error(`Deseja realmente deletar  ${item.name} ?`, item.name, {
                    timeout: 10000,
                    showProgressBar: true,
                    closeOnClick: true,
                    pauseOnHover: true,
                    buttons: [
                        {text: 'Não', action: () => console.log('Não...')},
                        {
                            text: 'Sim', action: (value) => {
                                this.$emit('destroy', item.id);
                                this.$snotify.remove(value.id)
                            }
                        },
                    ]
                })
            },
        }
    }
</script>

<style scoped>

</style>
