import axios from "axios";

export default {
    state: {
        items: {
            data: []
        }
    },
    mutations: {
        LOAD_CATEGORIES(state, categories) {
            state.items = categories
        }
    },
    actions: {

        // LISTAR CATEGORIAS
        loadCategories(context, params) {
            context.commit('PRELOADER', true);
            axios.get('/api/v1/categories', {params})
                .then(response => {
                    console.log(response);
                    context.commit('LOAD_CATEGORIES', response)
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                    context.commit('PRELOADER', false)
                });
        },

        // ADICIONAR NOVA CATEGORIA
        storeCategory(context, params) {
            context.commit('PRELOADER', true);

            return new Promise((resolve, reject) => {
                axios.post('/api/v1/categories', params)
                    .then(response => resolve())
                    .catch(error => reject(error))
                    .finally(() => {
                        context.commit('PRELOADER', false)
                    })
            })

        },

        // EXIBIR CATEGORIA POR ID
        loadCategory(context, id) {
            context.commit('PRELOADER', true);

            return new Promise((resolve, reject) => {
                axios.get(`/api/v1/categories/${id}`)
                    .then(response => resolve(response.data))
                    .catch(error => reject(error))
                    .finally(() => {
                        context.commit('PRELOADER', false)
                    })
            })
        },

        updateCategory(context, params) {
            return new Promise((resolve, reject) => {
                axios.put(`/api/v1/categories/${params.id}`, params)
                    .then(response => resolve(response.data))
                    .catch(error => reject(error))
                    .finally(() => {
                        context.commit('PRELOADER', false)
                    })
            })
        },

        destroyCategory(context, id) {
            context.commit('PRELOADER', true);
            return new Promise((resolve, reject) => {
                axios.delete(`/api/v1/categories/${id}`)
                    .then(response => resolve(response.data))
                    .catch(error => reject(error))
            })
        }
    },
    getters: {}
}
