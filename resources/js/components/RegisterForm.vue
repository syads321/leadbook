<template>
    <div class="card">
        <div class="card-header">Register</div>

        <div class="card-body">
            <validation-observer ref="observer">
                <form
                    method="POST"
                    novalidate="novalidate"
                    v-on:submit.prevent="onSubmit"
                >
                    <validation-provider
                        name="Name"
                        rules="required|min:3"
                        v-slot="{ errors }"
                    >
                        <div class="form-group row">
                            <label
                                for="name"
                                class="col-md-4 col-form-label text-md-right"
                                >Name</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    v-model="form.name"
                                    required
                                    autocomplete="name"
                                    autofocus
                                    :class="{ 'is-invalid': errors.length > 0 }"
                                />

                                <template v-for="(message, key) in errors">
                                    <span
                                        class="invalid-feedback"
                                        :key="key"
                                        role="alert"
                                    >
                                        {{ message }}
                                    </span>
                                </template>
                            </div>
                        </div>
                    </validation-provider>
                    <validation-provider
                        name="Email Address"
                        rules="required|max:25|min:3|email"
                        v-slot="{ errors }"
                    >
                        <div class="form-group row">
                            <label
                                for="email"
                                class="col-md-4 col-form-label text-md-right"
                                >Email Address</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    value="email"
                                    v-model="form.email"
                                    required
                                    autocomplete="email"
                                    :class="{ 'is-invalid': errors.length > 0 }"
                                />
                                <template v-for="(message, key) in errors">
                                    <span
                                        class="invalid-feedback"
                                        :key="key"
                                        role="alert"
                                    >
                                        {{ message }}
                                    </span>
                                </template>
                            </div>
                        </div>
                    </validation-provider>
                    <validation-provider
                        name="Password"
                        rules="required|max:10|min:6"
                        v-slot="{ errors }"
                        vid="confirmation"
                    >
                        <div class="form-group row">
                            <label
                                for="password"
                                class="col-md-4 col-form-label text-md-right"
                                >Password</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    v-model="form.password"
                                    ref="password"
                                    required
                                    autocomplete="new-password"
                                    :class="{ 'is-invalid': errors.length > 0 }"
                                />
                                <template v-for="(message, key) in errors">
                                    <span
                                        class="invalid-feedback"
                                        :key="key"
                                        role="alert"
                                    >
                                        {{ message }}
                                    </span>
                                </template>
                            </div>
                        </div>
                    </validation-provider>
                    <validation-provider
                        name="Password Confirm"
                        rules="required|max:10|min:6|confirmed:confirmation"
                        v-slot="{ errors }"
                    >
                        <div class="form-group row">
                            <label
                                for="password-confirm"
                                class="col-md-4 col-form-label text-md-right"
                                >Confirm Password</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    :class="{ 'is-invalid': errors.length > 0 }"
                                />
                                <template v-for="(message, key) in errors">
                                    <span
                                        class="invalid-feedback"
                                        :key="key"
                                        role="alert"
                                    >
                                        {{ message }}
                                    </span>
                                </template>
                            </div>
                        </div>
                    </validation-provider>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </validation-observer>
        </div>
    </div>
</template>

<script>
import {
    ValidationProvider,
    ValidationObserver
} from "vee-validate/dist/vee-validate.full";
export default {
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                phonenumber: "",
                password_confirmation: ""
            }
        };
    },
    methods: {
        async onSubmit() {
            const valid = await this.$refs.observer.validate();
            if (!valid) return
            try {
                await this.axios.post("/register", this.form);
            } catch(e) {
                console.log(e)
                this.$store.commit('setErrors', e.message)
            } 
        }
    }
};
</script>
