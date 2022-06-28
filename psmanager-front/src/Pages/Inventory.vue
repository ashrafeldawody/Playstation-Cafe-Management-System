<template>
    <v-card class="p-3">
        <v-card-header>
            <v-toolbar-title>
                <div class="d-flex justify-content-between w-100">
                    <span class="headline">المخزون</span>
                    <v-btn color="primary" variant="outlined" @click="addInventoryDialog = true">اضافة مخزون</v-btn>
                </div>
            </v-toolbar-title>
        </v-card-header>
    <v-table class="table table-striped">
        <thead>
        <tr>
            <th class="text-right">
                المنتج
            </th>
            <th class="text-right">
                السعر
            </th>
            <th class="text-right">
                الكميه المتاحة
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in items"
            :key="item.id"
        >
            <td>{{ item.name }}</td>
            <td>{{ item.price }} جنيه</td>
            <td>{{ item.quantity }}</td>
        </tr>
        </tbody>
    </v-table>
        <v-dialog v-model="addInventoryDialog" persistent @click:outside="addInventoryDialog=false">
            <AddInventory @closeDialog="addInventoryDialog = false" @added="loadInventory"></AddInventory>
        </v-dialog>
        </v-card>
</template>

<script>
import axios from "../plugins/axios";
import AddInventory from "@/components/AddInventory";

export default {
    name: "Inventory",
    components: {AddInventory},
    data() {
        return {
            items: [],
            addInventoryDialog: false,
        };
    },
    methods: {
        loadInventory() {
            axios.get("/api/cafe/inventory").then(res => {
                this.items = res.data;
            });
        },
    },
    mounted() {
        this.loadInventory();
    }
}
</script>

<style scoped>

</style>
