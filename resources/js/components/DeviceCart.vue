<template>
    <div class="row" style="direction:ltr">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills justify-content-around">
                        <li class="nav-item" v-for="cat in categories">
                            <a :class="['nav-link', cat.id === category ?'active':'']" href="#" @click="chanceCategory(cat.id)">{{cat.name }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around flex-wrap overflow-auto">
                        <div class="card text-right mx-1" style="cursor: pointer" v-for="item in activeCategory?.items"
                             @click="addToCart(item)">
                            <img class="card-img-top" style="width: 120px;height:120px;" :src="'/uploads/' + item.image" alt="Card image cap">
                            <div class="card-body">
                                <h5>{{ item.name }}</h5>
                                <div class="badge badge-primary">{{ item.price }} جنيه </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card" style="min-height:80vh">
                <div class="card-header">
                    <h3>السلة</h3>
                </div>
                <div class="card-body h-100">
                    <ul class="list-group text-right p-0" dir="rtl">
                        <li href="#" class="list-group-item"  v-for="item in cart">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ item.item_name }}</h5>
                                <span class="text-bold">{{ item.quantity * item.price }} جنيه</span>
                            </div>
                            <p style="text-align-last: end">
                                <button class="btn btn-sm btn-danger" @click="cartRemove(item)">-</button>
                                {{ item.quantity }}
                                <button class="btn btn-sm btn-success" @click="cartAdd(item)">+</button>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-row-reverse justify-content-between">
                        <h5>الاجمالي</h5>
                        <h5> {{ cartTotal }} </h5>
                        <h5> جنيه </h5>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-12 col-md-6">
                        <button class="btn btn-danger btn-block" @click="this.$emit('close')">اغلاق</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button class="btn btn-success btn-block" @click="saveCart">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {MEDIA_URL} from "./plugins/config";
import axios from "./plugins/axios";

export default {
    name: "DeviceCart",
    data() {
        return {
            category: null,
            cart:[],
            categories:[]
        }
    },
    props: {
        device: Object,
    },
    methods: {
        image_url(image){
            return MEDIA_URL + image
        },
        addToCart(item) {
            let found = this.cart.find(i => i.item_id === item.id);
            if (found) {
                found.quantity++;
            } else {
                this.cart.push({
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
                this.cart.splice(this.cart.indexOf(item), 1);
            }
        },
        saveCart() {
            axios.post(`/play/update_cart/${this.device.active_bill.id}`, {
                items: this.cart
            }).then((res) => {
                this.device.active_bill = res.data;
                this.$toast.open({
                    message: "تم حفظ المنتجات بنجاح",
                    type: "success",
                    position: "top-right"
                });
                this.$emit('CartSaved');
            });
        },
        chanceCategory(id){
            this.category = id
        }
    },
    computed: {
        activeCategory() {
            return this.category ? this.categories.find(category => category.id === this.category) :this.categories[0];
        },
        cartTotal() {
            return this.cart ? this.cart.reduce((total, item) => total + item.price * item.quantity, 0) : 0;
        }
    },
    mounted() {
        this.cart = this.device.active_bill ?
            this.device.active_bill.temp_items.map(item => {
                return {
                    item_name: item.item.name,
                    item_id: item.item.id,
                    price: item.item.price,
                    quantity: item.quantity
                }
            }) : [];
        axios.get('/cafe/items')
            .then(response => {
                this.categories = response.data;
                if (this.categories.length > 0) {
                    this.category = this.categories[0].id;
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
}
</script>

<style scoped>

</style>
