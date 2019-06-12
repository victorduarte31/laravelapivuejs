<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        Cadastre-se
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="register">
                            <div :class="['form-group', {'has-error': errors.name}]">
                                <div v-if="errors.name">{{ errors.name[0] }}</div>
                                <input type="text" v-model="formData.name" class="form-control" placeholder="Nome">
                            </div>
                            <div :class="['form-group', {'has-error': errors.email}]">
                                <div v-if="errors.email">{{ errors.email[0] }}</div>
                                <input type="email" v-model="formData.email" class="form-control" placeholder="E-mail">
                            </div>

                            <div :class="['form-group', {'has-error': errors.password}]">
                                <div v-if="errors.password">{{ errors.password[0] }}</div>
                                <input type="password" v-model="formData.password" class="form-control"
                                       placeholder="Senha">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Cadastrar-se</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- card -->
            </div> <!-- col-8 -->
        </div> <!-- row -->
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData: {
                    name: '',
                    email: '',
                    password: '',
                },

                errors: {},
            }
        },

        methods: {
            register() {
                this.$store.dispatch('register', this.formData)
                    .then(() => {
                        this.$router.push({name: 'admin.dashboard'});

                        this.$snotify.success('Sucesso ao cadastrar');
                    })
                    .catch(response => {
                        this.errors = response.errors
                    })
            }
        }
    }
</script>

<style scoped>

</style>
