import { createWebHistory, createRouter } from "vue-router";
import Home from "@/Pages/Home";
import Cafe from "@/Pages/Cafe";
import Income from "@/Pages/Income";
const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/cafe",
        name: "Cafe",
        component: Cafe,
    },
    {
        path: "/income",
        name: "Income",
        component: Income,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
