<template>
    <div class="transactions">
        <h2 v-if="showTitle">Transactions</h2>

        <ul>
            <li v-if="isLoading" class="loading">
                <IconLoading/>

                Loading...
            </li>

            <li v-if="!isLoading && transactions.length === 0 && isAdmin">
                Congratulations!<br>
                Everything is correct, no checks to be analyzed.
            </li>

            <li v-if="!isLoading && transactions.length === 0 && !isAdmin">
                No checks found
            </li>

            <li v-for="transaction in transactions" @click="handleTransaction(transaction)">
                <div>
                    <h3>{{ transaction.description }}</h3>
                    <span>{{ transaction.date_formatted }}</span>
                </div>

                <div class="value" :class="{'negative-value': transaction.amount < 0}">
                    ${{ transaction.amount_formatted }}
                </div>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import type {PropType} from 'vue'
import axios from "../services/axios";
import IconLoading from "./IconLoading.vue";
import {TransactionTypeDTO} from "../dtos/Transaction.dto";
import {FiltersTypeDTO} from "../dtos/Filters.dto";


export default defineComponent({
    components: {IconLoading},

    props: {
        showTitle: {
            type: Boolean,
            required: false,
            default: true
        },

        filters: {
            type: Object as PropType<FiltersTypeDTO>,
            required: false,
            default: {} as FiltersTypeDTO
        }
    },

    computed: {
        isAdmin(): boolean {
            return this.$store.state.user.is_admin;
        }
    },

    mounted() {
        this.load(this.filters);
    },

    data() {
        return {
            transactions: <TransactionTypeDTO[]>[],

            isLoading: false
        }
    },

    methods: {
        load(filters: FiltersTypeDTO): void {
            const params = new URLSearchParams(filters as Record<string, string>).toString();
            this.isLoading = true;

            axios.get('/api/transactions?' + params).then((response) => {
                this.transactions = <TransactionTypeDTO[]>response.data.data;

                this.isLoading = false;
            });
        },

        handleTransaction(transaction: TransactionTypeDTO) {
            this.$emit('handleTransaction', transaction);
        }
    }
})
</script>
