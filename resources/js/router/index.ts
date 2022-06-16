import {createWebHistory, createRouter} from "vue-router";
import {RouteRecordRaw} from "vue-router";
import {store} from '../store/index'

const routes: Array<RouteRecordRaw> = [
    {
        path: "/auth/login",
        name: "login",
        component: () => import("../Pages/AuthLogin.vue"),
        meta: {requiresAuth: false}
    },
    {
        path: "/auth/register",
        name: "register",
        component: () => import("../Pages/AuthRegister.vue"),
        meta: {requiresAuth: false}
    },
    {
        path: "/",
        name: "index",
        component: () => import("../Pages/Home.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
    {
        path: "/expenses",
        name: "expenses",
        component: () => import("../Pages/Expenses.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
    {
        path: "/purchase",
        name: "purchase",
        component: () => import("../Pages/Purchase.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
    {
        path: "/checks",
        name: "checks",
        component: () => import("../Pages/Checks.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
    {
        path: "/deposit",
        name: "deposit",
        component: () => import("../Pages/Deposit.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
    {
        path: "/deposit-completed",
        name: "deposit-completed",
        component: () => import("../Pages/DepositCompleted.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
    {
        path: "/admin",
        name: "admin",
        component: () => import("../Pages/AdminHome.vue"),
        meta: {requiresAuth: true, isAdmin: true}
    },

    {
        path: "/admin/check-details/:id(\\d+)",
        name: "check-details",
        component: () => import("../Pages/AdminCheckDatail.vue"),
        meta: {requiresAuth: true, isAdmin: true}
    },

    {
        path: "/admin/logout",
        name: "admin-logout",
        component: () => import("../Pages/Logout.vue"),
        meta: {requiresAuth: true, isAdmin: true}
    },

    {
        path: "/logout",
        name: "logout",
        component: () => import("../Pages/Logout.vue"),
        meta: {requiresAuth: true, isAdmin: false}
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.user.id > 0;
    const isAdmin = store.state.user.is_admin;

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({name: 'login'});
    } else if ((!to.meta.requiresAuth && isAuthenticated && !isAdmin) ||
        (to.meta.requiresAuth && isAuthenticated && to.meta.isAdmin && !isAdmin)) {
        next({name: 'index'});
    } else if ((!to.meta.requiresAuth && isAuthenticated && isAdmin) ||
        (to.meta.requiresAuth && isAuthenticated && !to.meta.isAdmin && isAdmin)) {
        next({name: 'admin'});
    } else {
        next()
    }
});

export default router;
