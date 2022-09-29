<template>
    <div class="card">
        <div class="card-body">
            <h3 class="w-100 text-center">
                <i class="fa fa-gamepad mx-3"></i>
                <span>تفاصيل اللعب</span>
                <i class="fa fa-gamepad mx-3"></i>
            </h3>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">البداية</th>
                    <th scope="col">النهاية</th>
                    <th scope="col">النوع</th>
                    <th scope="col">المدة</th>
                    <th scope="col">التكلفة</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="session in bill?.sessions">
                    <td>{{prettyTime(session.start_time) }}</td>
                    <td v-if="session.end_time">{{prettyTime(session.end_time)}}</td>
                    <td v-else><div class="spinner-border text-primary" role="status"> <span class="sr-only">جارية...</span> </div></td>
                    <td>{{session.is_multi ? 'مالتي':'عادي'}}</td>
                    <td>{{ session === activeSession ? activeSessionDiff : Math.round(session.duration / 60) }} دقيقة</td>
                    <td>{{ session === activeSession ? calculateSessionCost(session): session.cost}} {{currency }}</td>
                </tr>

                </tbody>

            </table>
            <div v-if="bill?.temp_items.length > 0">

            <h3 class="w-100 text-center mt-3">
                <i class="fa fa-coffee mx-3"></i>
                <span>تفاصيل الكافيه</span>
                <i class="fa fa-coffee mx-3"></i>
            </h3>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">المنتج</th>
                    <th scope="col">السعر</th>
                    <th scope="col">الكمية</th>
                    <th scope="col">الاجمالي</th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="item in bill?.temp_items">
                    <td>{{item.item.name}}</td>
                    <td>{{item.price}} {{currency }}</td>
                    <td>{{item.quantity}}</td>
                    <td>{{item.quantity * item.price}} {{currency }}</td>
                </tr>

                </tbody>

            </table>

            </div>
            <table class="table mt-2">
                <tr>
                    <th colspan="4">مجموع اللعب</th>
                    <th>{{ totalPlayCost }} {{currency }}</th>
                </tr>
                <tr  v-if="bill?.temp_items.length > 0">
                    <th colspan="4">مجموع الكافيه</th>
                    <th>{{ totalCafeCost }} {{currency }}</th>
                </tr>
                <tr>
                    <th colspan="4">الاجمالي</th>
                    <th>{{ totalCost }} {{currency }}</th>
                </tr>
                <tr>
                    <th colspan="4">المبلغ المدفوع</th>
                    <th class="p-0">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">{{currency }}</span>
                            </div>
                            <input type="number" class="form-control" v-model="paid">

                        </div>

                    </th>
                </tr>
                <tr>
                    <th colspan="4">الخصم</th>
                    <th>{{ discount }} {{currency }}</th>
                </tr>

            </table>
        </div>
        <div class="card-footer text-left">
            <button class="btn btn-primary mx-3" @click="finishAndPay">دفع</button>
            <button class="btn btn-danger" @click="this.$emit('close')">اغلاق</button>
        </div>
    </div>
</template>

<script>
import axios from "./plugins/axios";

export default {
    name: "PayBill",
    data: () => ({
        paid: 0,
    }),
    props: {
        bill: Object,
        totalPlayCost: Number,
        totalCafeCost: Number,
        totalCost: Number,
        currency: String,
        activeSession: Object,
        calculateSessionCost: Function,
        prettyTime: Function,
        activeSessionDiff: Number,
    },
    methods: {
        finishAndPay() {
            // if the diffrence between the paid and the total is more then 5
            // then we need to ask the user to confirm the payment
            if (Math.abs(this.paid - this.totalCost) >= 5) {
                this.$toast.warning("المبلغ المدفوع لا يساوي المجموع الكلي");
                return;
            }
            if (this.paid < 5 && this.totalPlayCost > 0) {
                this.$toast.warning("المبلغ المدفوع لا يمكن ان يكون اقل من 5 جنيه");
                return;
            }
            if (this.paid < this.totalCafeCost) {
                this.$toast.warning("المبلغ المدفوع لا يمكن ان يكون اقل من المجموع الكلي للسلع");
                return;
            }
            axios.post(`/play/finish`, {
                bill_id: this.bill.id,
                printRecipt: false,
                paid: this.paid,
            }).then(response => {
                this.$toast.open({
                    message: "تم تسجيل الفاتوره",
                    type: "success",
                    position: "bottom-left"
                });
                this.$emit('paid');
                this.$emit('close');
            }).catch(error => {
                this.$emit('close');
                this.$toast.open({
                    message: "حدث خطأ اثناء تسجيل الفاتوره",
                    type: "error",
                    position: "bottom-left"
                });
        });
        }

    },
    mounted() {
        this.paid = this.totalCost;
    },
    computed: {
        discount() {
            return this.paid > this.totalCost ? 0 : this.totalCost - this.paid;
        }
    }
}
</script>

<style scoped>

</style>
