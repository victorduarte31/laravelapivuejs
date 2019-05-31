import axios from 'axios'
import {URL_BASE} from '../../../config/configs'

const RESOURCE = 'products';

const CONFIGS = {
    headers: {
        'content-type': 'multipart/form-data'
    }
};

export default {

    loadProducts(context, params) {
        context.commit('PRELOADER', true);
        axios.get(`${URL_BASE}${RESOURCE}`, {params})
            .then(response => {
                context.commit('LOAD_PRODUCTS', response.data)
            })
            .catch(error => console.log(error))
            .finally(() => context.commit('PRELOADER', false))
    },

    /* ao trabalhar com upload de imagens necessitamos passar uma configuração adicional ao axios
    que neste caso passamos o CONFIGS declarado numa constante onde passamos a informação de multipart/form-data
     */
    storeProduct(context, formData) {
        context.commit('PRELOADER', true);
        return new Promise((resolve, reject) => {
            axios.post(`${URL_BASE}${RESOURCE}`, formData, CONFIGS)
                .then(response => resolve())
                .catch(error => reject(error.response))
                .finally(() => context.commit('PRELOADER', false))
        })
    },

    loadProduct(context, id) {
        context.commit('PRELOADER', true);
        return new Promise((resolve, reject) => {
            axios.get(`${URL_BASE}${RESOURCE}/${id}`)
                .then(response => resolve(response.data))
                .catch(error => console.log(error))
                .finally(() => context.commit('PRELOADER', false))
        })
    },

    updateProduct(context, formData) {
        context.commit('PRELOADER', true);

        formData.append('_method', 'PUT'); //necessário para trabalharmos com update devido a limitações na api

        return new Promise((resolve, reject) => {
            /* Como o parametro formData e um objeto, não podemos pegar o id na forma de formData.id
            necessitamos formData.get('id')
             */
            axios.post(`${URL_BASE}${RESOURCE}/${formData.get('id')}`, formData, CONFIGS)
                .then(response => resolve())
                .catch(error => reject(error.response))
                .finally(() => context.commit('PRELOADER', false))
        })
    },

    destroyProduct(context, id) {
        context.commit('PRELOADER', true);
        return new Promise((resolve, reject) => {
            axios.delete(`${URL_BASE}${RESOURCE}/${id}`)
                .then(response => resolve())
                .catch(error => reject(error.response))
                .finally(() => context.commit('PRELOADER', false))
        })
    }





}
