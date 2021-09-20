<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <register-form @onSuccess="onSuccess" />
            </div>
        </div>
    </div>
</template>

<script>
import RegisterForm from "./../components/RegisterForm.vue";
export default {
    components: {
        RegisterForm
    },
    methods: {
        onSuccess() {
            this.$store.commit(
                "setInfo",
                "Register succedd, please check you email"
            );
            this.$router.push('/')
        }
    }
};
</script>
