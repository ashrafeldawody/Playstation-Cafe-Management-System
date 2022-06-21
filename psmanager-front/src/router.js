import { createWebHistory, createRouter } from "vue-router";
import Home from "@/Pages/Home";
import Cafe from "@/Pages/Cafe";

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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
