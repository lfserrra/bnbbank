<template>
    <div>
        <nav :class="{'open': showMenu}" class="sidebar">
            <div class="sidebar-header">BNB Bank</div>

            <a href="#" class="sidebar-item" @click.prevent="routeGo('/')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'balance'}"/>
                </div>

                <span>Balances</span>
            </a>

            <a href="#" class="sidebar-item disabled" @click.prevent="routeGo('/')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'income'}"/>
                </div>

                <span>Incomes</span>
            </a>

            <a href="#" class="sidebar-item" @click.prevent="routeGo('/expenses')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'expenses'}"/>
                </div>

                <span>Expenses</span>
            </a>

            <a href="#" class="sidebar-item" @click.prevent="routeGo('/checks')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'checks'}"/>
                </div>

                <span>Checks</span>
            </a>

            <a href="#" class="sidebar-item disabled" @click.prevent="routeGo('/')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'notifications'}"/>
                </div>

                <span>Notifications</span>
            </a>

            <a href="#" class="sidebar-item disabled" @click.prevent="routeGo('/')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'user'}"/>
                </div>

                <span>Profile</span>
            </a>

            <a href="#" class="sidebar-item disabled" @click.prevent="routeGo('/')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'settings'}"/>
                </div>

                <span>Settings</span>
            </a>

            <a href="#" class="sidebar-item disabled" @click.prevent="routeGo('/')">
                <div class="sidebar-item-icon">
                    <Icon :icon="{ name: 'help'}"/>
                </div>

                <span>Help</span>
            </a>
        </nav>

        <div v-if="showMenu" class="sidebar-overlay" @click="closeMenu"></div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Icon from "./Icon.vue";

export default defineComponent({
    components: {Icon},
    computed: {
        showMenu(): boolean {
            return this.$store.state.showMenu;
        }
    },

    methods: {
        closeMenu(): void {
            this.$store.commit('toggleMenu');
        },

        routeGo(route: string): void {
            this.closeMenu();

            this.$router.push(route);
        }
    }
});
</script>
