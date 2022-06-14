<template>
    <router-view></router-view>
</template>

<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    computed: {
        teste(): string {
            return this.$store.state.helloMessage;
        }
    },

    methods: {
        testeChange(): void {
            this.$store.commit('testeChange', 'TTTTT')
            //this.$axios.post('auth/login');
        }
    }
})
</script>
