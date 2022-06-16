<template>
    <div>
        <div class="header relative header-light">
            <MenuButton class="absolute top-0 left-0"/>

            <span class="header-title">Checks</span>

            <div class="header-info">
                <div class="header-month">
                    <span>August, 2021</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <ul class="header-status">
                <li :class="{'active': status_id === 1}" @click.prevent="changeTab(1)">PENDING</li>
                <li :class="{'active': status_id === 2}" @click.prevent="changeTab(2)">ACCEPTED</li>
                <li :class="{'active': status_id === 3}" @click.prevent="changeTab(3)">REJECTED</li>
            </ul>
        </div>

        <Transactions v-if="showTransaction" ref="transactions" :show-title="false" :filters="{type_id: 1, status_id: status_id}"/>

        <FloatButton @click.prevent="goToDeposit"/>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Transactions from "../components/Transactions.vue";
import MenuButton from "../components/MenuButton.vue";
import FloatButton from "../components/FloatButton.vue";

export default defineComponent({
    components: {FloatButton, MenuButton, Transactions},

    data() {
        return {
            status_id: 2,
            showTransaction: true
        }
    },

    methods: {
        goToDeposit(): void {
            this.$router.push('/deposit');
        },

        changeTab(status_id: number) {
            this.status_id = status_id;
            this.showTransaction = false;

            this.$nextTick(() => {
                this.showTransaction = true;
            })
        }
    }
})
</script>
