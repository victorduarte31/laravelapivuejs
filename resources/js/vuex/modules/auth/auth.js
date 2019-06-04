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

        AUTH_USER_LOGOUT (state) {
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

                    localStorage.setItem(NAME_TOKEN, response.data.token); // armazenar o token
                })
                .catch(error => console.log(error))
                .finally(() => context.commit('PRELOADER', false))

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
            localStorage.removeItem(NAME_TOKEN)

            context.commit('AUTH_USER_LOGOUT')
        }
    }
}
