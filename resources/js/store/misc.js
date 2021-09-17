import Vuex from 'vuex'
import Vue from 'vue';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        errors: '',
        islogin: false,
        user: {}
    },
    mutations: {
        setErrors(state, err) {
            state.errors = err
        },
        setUser(state, data) {
            state.islogin = true
            state.user = data
        }
    }
})
export default store