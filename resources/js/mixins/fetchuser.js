export default {
    methods: {
        async fetchUser() {
            try {
                const user = await this.axios.get("/api/user");
                this.$store.commit("setErrors", '');
                this.$store.commit("setUser", user.data);
            } catch (e) {
                this.$store.commit("setErrors", e.response.data.message);
            }
        }
    }
}