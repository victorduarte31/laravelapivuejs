<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="login">
                            <div class="form-group">
                                <input v-model="formData.email" type="email" placeholder="E-mail" class="form-control">
                            </div>
                            <div class="form-group">
                                <input v-model="formData.password" type="password" placeholder="Senha"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Acessar</button>
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
        data() {
            return {
                formData: {
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            login() {
                this.$store.dispatch('login', this.formData)
                    .then(()=> {
                        this.$router.push({name: 'admin.dashboard'})
                    })
            }
        }
    }
</script>

<style scoped>
</style>
