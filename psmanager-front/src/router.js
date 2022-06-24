import { createWebHistory, createRouter } from "vue-router";
import Home from "@/Pages/Home";
import Cafe from "@/Pages/Cafe";
import Income from "@/Pages/Income";
import Inventory from "@/Pages/Inventory";
import Expense from "@/Pages/Expense";
import Summary from "@/Pages/Summary";
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
    {
        path: "/inventory",
        name: "Inventory",
        component: Inventory,
    },
    {
        path: "/expense",
        name: "Expense",
        component: Expense,
    },
    {
        path: "/summary",
        name: "Summary",
        component: Summary,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
