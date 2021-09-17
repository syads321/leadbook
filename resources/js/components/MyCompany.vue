<template>
    <div class="card">
        <div class="card">
            <div class="card" style="width: 18rem;">
                <company-item v-for="(item, i) in companies" :key="i" :item="item" :addButton="false" :removeButton="true"></company-item>
            </div>
        </div>
    </div>
</template>

<script>
import CompanyItem from "./CompanyItem.vue";
export default {
    components: {
        CompanyItem
    },
    data() {
        return {
            companies: []
        };
    },
    mounted() {
        this.fetchMyCompanies();
    },
    methods: {
        async fetchMyCompanies() {
            try {
                const companies = await this.axios.get("/api/getmycompany");
                this.companies = companies.data;
            } catch (e) {
                this.$store.commit(
                    "setErrors",
                    e.response.data.message || "Not Found"
                );
            }
        }
    }
};
</script>
