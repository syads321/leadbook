<template>
    <div class="card">
        <div class="card">
            <input
                type="search"
                class="form-control ds-input"
                id="search-input"
                placeholder="Search..."
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
            <div class="card" style="width: 18rem;">
                <div class="card" v-for="(item, i) in companies" :key="i">
                    <div class="card-body">
                        <h5 class="card-title">{{ item.company_name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ item.address }}
                        </h6>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="addToMyCompany(item)"
                        >
                            Add To My Company List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            companies: [],
            mycompanies: []
        };
    },
    watch: {
        search(val) {
            if (val.length > 0) {
                this.fetchCompanies(val);
            } else {
                this.companies = [];
            }
        }
    },
    methods: {
        async fetchCompanies(val) {
            try {
                const companies = await this.axios.get("/api/companies/" + val);
                this.companies = companies.data;
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
