import Vuex from 'vuex'
import Vue from 'vue';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        errors: '',
        process: '',
        islogin: false,
        user: {},
        info: ''
    },
    mutations: {
        setErrors(state, err) {
            state.errors = err
        },
        setProcess(state, process) {
            state.process = process
        },
        setInfo(state, info) {
            state.info = info
        },
        setUser(state, data) {
            state.islogin = true
            state.user = data
        }
    }
})
export default store