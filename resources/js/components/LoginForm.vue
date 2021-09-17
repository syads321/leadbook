<template>
    <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
            <validation-observer ref="observer">
                <form
                    method="POST"
                    action=""
                    ref="form"
                    v-on:submit.prevent="onSubmit"
                    novalidate="novalidate"
                >
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
                                    required
                                    autocomplete="email"
                                    autofocus
                                    v-model="form.email"
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
                        rules="required|min:6"
                        v-slot="{ errors }"
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
                                    required
                                    autocomplete="current-password"
                                    v-model="form.password"
                                    :class="{ 'is-invalid': errors.length > 0 }"
                                />
                            </div>
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
                    </validation-provider>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    v-model="form.remember"
                                />
                                <label class="form-check-label" for="remember">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                            <router-link class="btn btn-link" to="/register">
                                Forget Password
                            </router-link>
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
                email: "",
                password: "",
                remember: false
            }
        };
    },
    mounted() {
        // this.login();
    },
    methods: {
        async onSubmit() {
            const valid = await this.$refs.observer.validate();
            console.log(valid);
            try {
                const user = await this.axios.post("/login", this.form);
                this.$emit('onSuccess')
            } catch (e) {
                this.$store.commit("setErrors", e.response.data.message);
            }
        }
    }
};
</script>
