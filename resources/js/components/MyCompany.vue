<template>
    <div class="row">
        <div class="col-12">
            <h4 v-if="companies.length === 0 && !loading">
                You do not have any company
            </h4>
        </div>
        <company-item
            v-for="(item, i) in companies"
            :key="i"
            :item="item"
            :addButton="false"
            :removeButton="true"
            class="col-lg-4 col-md-6 col-xs-12 ml-2 mb-2"
            @removeButton="deleteMyCompany(item)"
        ></company-item>
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
            companies: [],
            loading: true
        };
    },
    mounted() {
        this.fetchMyCompanies();
    },
    methods: {
        async fetchMyCompanies() {
            this.loading = true;
            try {
                const companies = await this.axios.get("/api/getmycompany");
                this.companies = companies.data;
            } catch (e) {
                this.$store.commit(
                    "setErrors",
                    e.response.data.message || "Not Found"
                );
            } finally {
                this.loading = false;
            }
        },
        async deleteMyCompany(item) {
            try {
                const data = {
                    company_id: item.id
                };
                await this.axios.delete("/api/deletemycompany", {
                    data: data
                });
                this.fetchMyCompanies();
            } catch (e) {
                this.$store.commit(
                    "setErrors",
                    e.response.data.message || "Not Found"
                );
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
