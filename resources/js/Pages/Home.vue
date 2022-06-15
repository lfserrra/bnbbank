<template>
    <div>
        <div class="header relative">
            <MenuButton class="absolute top-0 left-0"/>

            BNB Bank

            <div class="header-info">
                <div>
                    <span class="header-info-title">Current balance</span>
                    <span class="header-info-value">{{ formatValue(6320) }}</span>
                </div>

                <div class="header-month">
                    <span>August, 2021</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <HeaderTotalTransaction title="Incomes" :value="7100" button_text="Deposit a check" @handleButton="deposit"/>
            <HeaderTotalTransaction title="Expenses" :value="780" button_text="Purchase" class="expenses" @handleButton="purchase"/>
        </div>

        <Transactions/>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import HeaderTotalTransaction from "../components/HeaderTotalTransaction.vue";
import Transactions from "../components/Transactions.vue";
import {formatValue} from "../utils/formarValue";
import MenuButton from "../components/MenuButton.vue";

export default defineComponent({
    components: {MenuButton, Transactions, HeaderTotalTransaction},

    methods: {
        deposit(): void {
            this.$router.push('/deposit');
        },

        purchase(): void {
            this.$router.push('/purchase');
        },

        formatValue
    }
})
</script>
