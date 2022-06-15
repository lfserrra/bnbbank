<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">EXPENSES</span>

            <div class="header-info">
                <div class="header-month">
                    <span>August, 2021</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <Transactions/>

        <FloatButton @click.prevent="goToPurchase"/>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Transactions from "../components/Transactions.vue";
import MenuButton from "../components/MenuButton.vue";
import FloatButton from "../components/FloatButton.vue";

export default defineComponent({
    components: {FloatButton, MenuButton, Transactions},

    methods: {
        goToPurchase(): void {
            this.$router.push('/purchase');
        }
    }
})
</script>
