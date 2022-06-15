import {createWebHistory, createRouter} from "vue-router";
import {RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
    {
        path: "/auth/login",
        name: "login",
        component: () => import("../Pages/AuthLogin.vue"),
    },
    {
        path: "/auth/register",
        name: "register",
        component: () => import("../Pages/AuthRegister.vue"),
    },
    {
        path: "/",
        name: "index",
        component: () => import("../Pages/Home.vue"),
    },
    {
        path: "/expenses",
        name: "expenses",
        component: () => import("../Pages/Expenses.vue"),
    },
    {
        path: "/purchase",
        name: "purchase",
        component: () => import("../Pages/Purchase.vue"),
    },
    {
        path: "/checks",
        name: "checks",
        component: () => import("../Pages/Checks.vue"),
    },
    {
        path: "/deposit",
        name: "deposit",
        component: () => import("../Pages/Deposit.vue"),
    },
    {
        path: "/deposit-completed",
        name: "deposit-completed",
        component: () => import("../Pages/DepositCompleted.vue"),
    },
    {
        path: "/admin",
        name: "admin",
        component: () => import("../Pages/HomeAdmin.vue"),
    },

    {
        path: "/admin/check-details",
        name: "check-details",
        component: () => import("../Pages/CheckDatail.vue"),
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
