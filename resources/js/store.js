import Vue from 'vue';
import Vuex from 'vuex';
import {getLocalUser} from './helpers/auth';
import createPersistedState from "vuex-persistedstate";
import Axios from 'axios';
const user = getLocalUser();
Vue.use(Vuex);

export default new Vuex.Store ({
    state : {
        currentUser : user,
        auth_error : null
    },
    getters : {
        currentUser(state){
            return state.currentUser;
        },
    },
    mutations : {
        login(state){
            state.auth_error = null
        },
        loginSuccess(state, payload){
            state.currentUser = Object.assign({}, payload.user, {token : payload.access_token});
            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload){
            state.auth_error = payload.error;
        },
        logout(state){
            state.currentUser = null
            localStorage.removeItem('user')
            localStorage.removeItem('vuex')
        },  
 
    },
    actions : {
        login(context){
            context.commit('login')
        },
    },
    plugins: [createPersistedState()]
})