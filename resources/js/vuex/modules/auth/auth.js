import axios from "axios";
import {NAME_TOKEN} from "../../../config/configs";

export default {
    state: {
        me: {},
        authenticated: false,
        urlBack: 'home',
    },

    mutations: {
        AUTH_USER_OK(state, user) {
            state.authenticated = true;
            state.me = user
        },

        CHANGE_URL_BACK(state, url) {
            state.urlBack = url;
        },

        AUTH_USER_LOGOUT(state) {
            state.me = {};
            state.authenticated = false;
            state.urlBack = 'home';
        }
    },

    actions: {
        login(context, params) {
            context.commit('PRELOADER', true);
            return axios.post('/api/auth', params)
                .then(response => {
                    context.commit('AUTH_USER_OK', response.data.user);


                    const token = response.data.token;
                    localStorage.setItem(NAME_TOKEN, token); // armazenar o token
                    /*
                    * Resolver bug que quando o usuario loga no sistema nao lista os produtos
                    * So mostrava quando o usuario atualizava a pagina
                     */
                    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                }).finally(() => context.commit('PRELOADER', false))

        },

        checkLogin(context) {
            context.commit('PRELOADER', true);
            return new Promise((resolve, reject) => {
                const token = localStorage.getItem(NAME_TOKEN);
                if (!token)
                    return reject();

                axios.get('/api/me')
                    .then(response => {
                        context.commit('AUTH_USER_OK', response.data.user);

                        resolve();
                    })
                    .catch(() => reject())
                    .finally(() => context.commit('PRELOADER', false))
            })
        },

        logout(context) {
            localStorage.removeItem(NAME_TOKEN);

            context.commit('AUTH_USER_LOGOUT')
        }
    }
}
