<template>
    <v-card class="p-3" min-width="600">
        <v-card-title>
            <v-toolbar-title>
                <span class="headline">تسجيل مخزون</span>
            </v-toolbar-title>
        </v-card-title>
        <v-card-text>
            <v-form lazy-validation>
                <v-select v-model="inventory.item_id" :items="items" item-title="name" item-value="id" label="المنتج" required></v-select>
                <v-text-field v-model="inventory.quantity" label="الكميه" type="number" required></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="$emit('closeDialog')">اغلاق</v-btn>
            <v-btn color="primary" @click="submit">حفظ</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import axios from "@/plugins/axios";
import Select2 from 'vue3-select2-component';
export default {
    name: "AddInventory",
    components: {Select2},
    data() {
        return {
            items: [],
            inventory: {
                item_id: 1,
                quantity: 1,
            }
    }
    },
    mounted() {
        axios.get('/cafe/list')
            .then(response => {
                this.items = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        submit() {
            if(isNaN(this.inventory.quantity) || this.inventory.quantity === 0) {
                this.$toast.open({
                    message: "الكميه يجب ان تكون رقم اكبر من صفر",
                    type: "error",
                    position: "top-right",
                    duration: 5000
                });
                return;
            }
            axios.post('/cafe/inventory', this.inventory).then(response => {
                this.inventory= {
                    item_id: 1,
                    quantity: 1,
                }
                this.$toast.open({
                    message: "تم تسجيل المخزون بنجاح",
                    type: "success",
                    position: "top-right",
                    duration: 5000
                });
                this.$emit('added')
                this.$emit('closeDialog')
            });
        }
    }
}
</script>

<style scoped>

</style>
