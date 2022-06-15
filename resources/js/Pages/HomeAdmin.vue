<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">Checks Control</span>
        </div>

        <Transactions :show-title="false" @handleTransaction="goToCheckDatail"/>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Transactions from "../components/Transactions.vue";
import MenuButton from "../components/MenuButton.vue";

export default defineComponent({
    components: {MenuButton, Transactions},

    methods: {
        goToCheckDatail(transaction: any): void {
            this.$router.push('/admin/check-details');
        }
    }
})
</script>
