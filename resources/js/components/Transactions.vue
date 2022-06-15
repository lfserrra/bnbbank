<template>
    <div class="transactions">
        <h2 v-if="showTitle">Transactions</h2>

        <ul>
            <li v-for="transaction in transactions" @click="handleTransaction">
                <div>
                    <h3>{{ transaction.description }}</h3>
                    <span>{{ transaction.date }}</span>
                </div>

                <div class="value" :class="{'negative-value': transaction.value < 0}">
                    {{ formatValue(transaction.value) }}
                </div>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import {formatValue} from "../utils/formarValue";

type Transaction = {
    description: string;
    date: string;
    value: number;
}

export default defineComponent({
    props: {
        showTitle: {
            type: Boolean,
            required: false,
            default: true
        }
    },

    data() {
        return {
            transactions: <Transaction[]>[
                {description: 't-shirt', date: '08/08/2021, 02:25 PM', value: 400},
                {description: 't-shirt 2', date: '08/06/2021, 02:25 PM', value: -800},
                {description: 't-shirt 3', date: '08/05/2021, 02:25 PM', value: 1000},
                {description: 't-shirt 4', date: '08/02/2021, 02:25 PM', value: -650},
                {description: 't-shirt red', date: '08/01/2021, 02:25 PM', value: 85},
            ]
        }
    },

    methods: {
        handleTransaction(transaction: Transaction) {
            this.$emit('handleTransaction', transaction);
        },

        formatValue
    }
})
</script>
