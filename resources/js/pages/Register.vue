<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <register-form />
            </div>
        </div>
    </div>
</template>

<script>
import RegisterForm from "./../components/RegisterForm.vue";
export default {
    components: {
        RegisterForm
    }
};
</script>
