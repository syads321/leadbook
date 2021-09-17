<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                Laravel
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" to="/">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="isLoggedIn">
                        <router-link class="nav-link" to="/"
                            >My Company</router-link
                        >
                    </li>
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" to="/register"
                            >Register</router-link
                        >
                    </li>
                    <li class="nav-item" v-if="isLoggedIn">
                        <router-link class="nav-link" to="/findcompany"
                            >Find Company</router-link
                        >
                    </li>
                    <li class="nav-item dropdown" v-if="isLoggedIn">
                        <a
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            {{ name }}
                        </a>

                        <div
                            class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="navbarDropdown"
                        >
                            <a class="dropdown-item" @click="logOut">
                                Log Out
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    computed: {
        isLoggedIn() {
            return this.$store.state.islogin;
        },
        name() {
            return this.$store.state.user.name;
        }
    },
    methods: {
        async logOut() {
            const valid = await this.$refs.observer.validate();
            try {
                await this.axios.post("/logout", {});
            } catch (e) {
                this.$store.commit("setErrors", e.response.data.message);
            }
        }
    }
};
</script>
