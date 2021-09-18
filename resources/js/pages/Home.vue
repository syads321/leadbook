<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" v-if="!isLoggedIn">
                <login-form @onSuccess="fetchUser()" />
            </div>
            <div class="col-md-8" v-if="isLoggedIn">
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <h2 class="center">My Company</h2>
                    </div>
                    <div class="col-lg-4 text-right">
                        <router-link
                            class="btn btn-primary btn-lg"
                            to="/findcompany"
                            >Add Company</router-link
                        >
                    </div>
                </div>

                <my-company></my-company>
            </div>
        </div>
    </div>
</template>

<script>
import LoginForm from "./../components/LoginForm.vue";
import MyCompany from "./../components/MyCompany.vue";
import fetchuser from "./../mixins/fetchuser";
export default {
    mixins: [fetchuser],
    components: {
        LoginForm,
        MyCompany
    },
    methods: {
        onLogin(data) {
            this.$store.commit("setUser", data);
        }
    },
    mounted() {
        this.fetchUser();
    },
    computed: {
        isLoggedIn() {
            return this.$store.state.islogin;
        }
    }
};
</script>
