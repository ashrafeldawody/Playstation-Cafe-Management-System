<template>
        <v-card height="100%" class="overflow-hidden">
                <v-row class="h-100">
                    <v-col cols="9" class="px-0 h-100">
                        <v-card height="100%">
                            <v-tabs v-model="category" background-color="primary">
                                <v-tab v-for="category in categories" :value="category.id">{{ category.name }}</v-tab>
                            </v-tabs>

                            <v-card-text class="h-100">
                                <div class="d-flex justify-content-between align-content-start flex-wrap gap-4 overflow-auto p-2 h-100">
                                    <v-card
                                        class="mx-auto"
                                        width="200px"
                                        height="fit-content"
                                        v-if="activeCategory"
                                        v-for="item in activeCategory.items"
                                        @click="addToCart(item)"
                                    >
                                        <v-img :src="require('../assets/images/' + item.image)" style="height: 200px"></v-img>                                        <v-card-title class="flex-column align-start">
                                            <p class=" mb-2">
                                                {{ item.name }}
                                            </p>
                                            <p class=" font-weight-regular text-grey">
                                                {{ item.price }} جنيه
                                            </p>
                                        </v-card-title>

                                    </v-card>

                                </div>
                            </v-card-text>
                        </v-card>

                    </v-col>
                    <v-col cols="3" class="px-0 h-100">
                        <div class="d-flex flex-column justify-content-between align-content-between h-100">
                            <div class="text-h5 p-2 pb-3 bg-gray">
                                <v-list>
                                    <v-list-item title="طلبات الجهاز"></v-list-item>
                                </v-list>
                            </div>
                            <v-card class="m-0 flex-grow-1 h-100 overflow-y-auto">
                                <v-list-item v-for="item in bill.temp_items" :key="item.id">
                                    <v-list-item-header>
                                        <v-list-item-title>
                                            <div class="d-flex justify-content-between py-1 pl-2">
                                                <span>{{ item.item_name }}</span>
                                                <span>
                                                    <v-btn icon="mdi-plus" @click="cartAdd(item)" size="x-small" color="primary"></v-btn>
                                                    {{item.quantity}}
                                                    <v-btn icon="mdi-minus" @click="cartRemove(item)" size="x-small" color="primary"></v-btn>
                                                </span>
                                            </div>
                                        </v-list-item-title>
                                        <v-list-item-subtitle>{{ item.price * item.quantity }} جنيه</v-list-item-subtitle>
                                    </v-list-item-header>
                                </v-list-item>
                            </v-card>
                            <div>
                                <v-card>
                                    <v-card-title class="text-center">
                                        <span>إجمالي الطلب</span>
                                    </v-card-title>
                                    <v-card-text class="text-center">
                                        <span>{{ cartTotal }} جنيه</span>

                                    </v-card-text>
                                    <v-card-actions class="text-center">
                                        <v-btn color="primary" block @click="closeCartDialog">حفظ</v-btn>
                                    </v-card-actions>

                                </v-card>
                            </div>
                        </div>

                    </v-col>

                </v-row>
        </v-card>

</template>

<script>
import axios from "../plugins/axios";

export default {
    name: "DeviceCart",
    props: {
        bill: {
            type: Object,
            required: true
        }
        },
    data() {
        return {
            category: null,
            categories: [],
        }
    },
    methods: {
        closeCartDialog() {
            axios.post(`/api/play/update_cart/${this.bill.id}`, {
                items: this.bill.temp_items
            });
            this.$emit("closeCartDialog");
        },
        addToCart(item) {
            let found = this.bill.temp_items.find(i => i.item_id === item.id);
            if (found) {
                found.quantity++;
            } else {
                this.bill.temp_items.push({
                    item_name: item.name,
                    item_id: item.id,
                    price: item.price,
                    quantity: 1
                });
            }
        },
        cartAdd(item) {
            item.quantity++;
        },
        cartRemove(item) {
            if (item.quantity > 1) {
                item.quantity--;
            } else {
                this.bill.temp_items.splice(this.bill.temp_items.indexOf(item), 1);
            }
        },
    },
    computed: {
        activeCategory() {
            return this.category ? this.categories.find(category => category.id === this.category) :this.categories[0];
        },
        cartTotal() {
            return this.bill.temp_items ? this.bill.temp_items.reduce((total, item) => total + item.price * item.quantity, 0) : 0;
        }
    },
    mounted() {
        if(!this.bill.temp_items)
            this.bill.temp_items = [];
        axios.get('/api/cafe/items')
            .then(response => {
                this.categories = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    }
}
</script>

<style scoped>

</style>
