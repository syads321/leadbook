<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <company-list></company-list>
            </div>
        </div>
    </div>
</template>

<script>
import CompanyList from "./../components/CompanyList.vue";
export default {
    components: {
        CompanyList
    }
};
</script>
