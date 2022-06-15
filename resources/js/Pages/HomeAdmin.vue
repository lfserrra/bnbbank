<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">Checks Control</span>

            <FilterButton class="absolute top-1 right-0"/>
        </div>

        <Transactions :show-title="false" @handleTransaction="goToCheckDatail"/>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Transactions from "../components/Transactions.vue";
import MenuButton from "../components/MenuButton.vue";
import FilterButton from "../components/FilterButton.vue";

export default defineComponent({
    components: {FilterButton, MenuButton, Transactions},

    methods: {
        goToCheckDatail(transaction: any): void {
            this.$router.push('/admin/check-details');
        }
    }
})
</script>
