<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ item.company_name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                {{ item.address }}
            </h6>
            <button
                v-if="addButton"
                type="button"
                class="btn btn-primary"
                @click="$emit('addButton')"
            >
                Add To My Company List
            </button>
            <button
                v-if="removeButton"
                type="button"
                class="btn btn-primary"
                @click="$emit('addButton')"
            >
                Remove from My Company List
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            default() {
                return {};
            },
            type: Object
        },
        addButton: {
            type: Boolean,
            default: false
        },
        removeButton: {
            type: Boolean,
            default: false
        }
    }
};
</script>
