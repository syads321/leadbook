<template>
    <div>
        <div class="row">
            <input
                type="search"
                class="form-control ds-input form-control-lg"
                id="search-input"
                placeholder="Type keyword..."
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
            <company-item
                v-for="(item, i) in companies"
                :key="i"
                :item="item"
                :addButton="true"
                :removeButton="false"
                class="col-lg-4 col-md-6 col-xs-12 mr-2 mb-2 mt-2"
                @addButton="addToMyCompany(item)"
            ></company-item>
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
        };
    },
    watch: {
        search: debounce(function(val) {
            if (val !== "") {
                this.fetchCompanies(val);
            } else {
                this.companies = [];
            }
        }, 200)
    },
    methods: {
        async fetchCompanies(val) {
            try {
                const companies = await this.axios.get("/api/companies/" + val);
                 this.$store.commit(
                    "setErrors",
                    ""
                );
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
