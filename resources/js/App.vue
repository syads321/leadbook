<template>
    <div>
        <main-header />
        <div class="alert alert-danger" role="alert" v-if="errors !== ''">
            {{ errors }}
        </div>
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
        }
    },
    watch: {
        $route() {
            this.$store.commit("setErrors", "");
            this.fetchUser();
        }
    }
};
</script>
