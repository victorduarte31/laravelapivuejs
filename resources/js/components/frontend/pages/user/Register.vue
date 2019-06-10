<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        Cadastre-se
                    </div>
                    <div class="card-body">
                        <form class="form">
                            <div class="form-group">
                                <input type="text" v-model="formData.name" class="form-control" placeholder="Nome">
                            </div>
                            <div class="form-group">
                                <input type="email" v-model="formData.email" class="form-control" placeholder="E-mail">
                            </div>

                            <div class="form-group">
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
                }
            }
        }
    }
</script>

<style scoped>

</style>
