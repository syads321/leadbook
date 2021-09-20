<template>
    <div>
        <main-header />
        <div
            class="alert alert-danger"
            role="alert"
            v-if="errors !== ''"
            v-html="errors"
        ></div>
        <div
            class="alert alert-warning"
            role="alert"
            v-if="process !== ''"
            v-html="process"
        ></div>
        <div
            class="alert alert-info"
            role="alert"
            v-if="info !== ''"
            v-html="info"
        ></div>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import MainHeader from "./components/MainHeader.vue";
import fetchuser from "./mixins/fetchuser";
export default {
    components: { MainHeader },
    mixins: [fetchuser],
    computed: {
        errors() {
            return this.$store.state.errors;
        },
        process() {
            return this.$store.state.process;
        },
        info() {
            return this.$store.state.info;
        }
    },
    mounted() {
        this.fetchUser();
    },
    watch: {
        $route() {
            this.$store.commit("setErrors", "");
        }
    }
};
</script>
