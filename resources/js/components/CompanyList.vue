<template>
    <div>
        <div class="row">
            <input
                type="search"
                class="form-control ds-input form-control-lg"
                id="search-input"
                placeholder="Type keyword... eg: Microsoft"
                aria-label="Search for..."
                autocomplete="off"
                spellcheck="false"
                role="combobox"
                aria-autocomplete="list"
                aria-expanded="false"
                aria-owns="algolia-autocomplete-listbox-0"
                dir="auto"
                style="position: relative; vertical-align: top;"
                v-model="search"
            />
        </div>
        <div class="row">
            <div class="row">
                <div
                    class="col-lg-4 col-md-6 col-xs-12"
                    v-for="(item, i) in companies"
                    :key="i"
                >
                    <company-item
                        :item="item"
                        :addButton="true"
                        :removeButton="false"
                        @addButton="addToMyCompany(item)"
                        class="mb-2 mt-2"
                    ></company-item>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import debounce from "./../mixins/debounce.js";
import CompanyItem from "./CompanyItem.vue";
export default {
    components: {
        CompanyItem
    },
    data() {
        return {
            search: "",
            companies: [],
            t: null
        };
    },
    mounted() {
        this.fetchAllCompanies();
    },
    watch: {
        search: debounce(function(val) {
            if (val !== "") {
                this.fetchCompanies(val);
            } else {
                this.fetchAllCompanies();
            }
        }, 200)
    },
    methods: {
        async fetchCompanies(val) {
            try {
                const companies = await this.axios.get("/api/companies/" + val);
                this.$store.commit("setErrors", "");
                this.companies = companies.data || [];
            } catch (e) {
                this.$store.commit(
                    "setErrors",
                    e.response.data.message || "Not Found"
                );
            }
        },
        async fetchAllCompanies() {
            try {
                const companies = await this.axios.get("/api/allcompanies/");
                this.companies = companies.data || [];
            } catch (e) {
                this.$store.commit(
                    "setErrors",
                    e.response.data.message || "Not Found"
                );
            }
        },
        async addToMyCompany(company) {
            try {
                const param = {
                    id: company.id
                };
                await this.axios.post("/api/addmycompany", param);
                this.$store.commit(
                    "setInfo",
                    company.company_name +
                        " has been added to your company list"
                );
                clearTimeout(this.t);
                this.t = setTimeout(() => {
                    this.$store.commit("setInfo", "");
                }, 3000);
            } catch (e) {
                this.$store.commit("setErrors", e.response.data || "Not Found");
            }
        }
    }
};
</script>
