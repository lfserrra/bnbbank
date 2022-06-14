import {createWebHistory, createRouter} from "vue-router";
import {RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
    {
        path: "/auth/login",
        name: "login",
        component: () => import("../components/AuthLogin.vue"),
    },
    {
        path: "/auth/register",
        name: "register",
        component: () => import("../components/AuthRegister.vue"),
    },
    {
        path: "/",
        name: "index",
        component: () => import("../components/Home.vue"),
    },
    {
        path: "/home2",
        name: "home2",
        component: () => import("../components/Home2.vue"),
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
