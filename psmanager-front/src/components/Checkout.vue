<template>
    <v-card class="mx-auto p-3" v-if="device.active_bill">
        <v-card-text>
            <div>جهاز 1</div>
            <p class="text-h4 text--primary">
                تفاصيل الفاتورة
            </p>
            <p class="text-h6 text-center">تفاصيل اللعب</p>
            <v-table density="compact">
                <thead>
                <tr>
                    <th class="text-right">
                        النوع
                    </th>
                    <th class="text-right">
                        وقت البدايه
                    </th>
                    <th class="text-right">
                        وقت النهايه
                    </th>
                    <th class="text-right">
                        المدة
                    </th>
                    <th class="text-right">
                        التكلفة
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="session in device.active_bill.sessions" :key="session.name">
                    <td>{{ session.is_multi ? 'مالتي':'عادي' }}</td>
                    <td>{{ prettyTime(session.start_time) }}</td>
                    <td>{{ prettyTime(session.end_time) }}</td>
                    <td>{{ timeDiffInMinutes(session.start_time,session.end_time) }} دقيقة</td>
                    <td>{{ calculateSessionCost(session) }} جنيه</td>
                </tr>
                </tbody>
                <tfoot>
                <td colspan="4"></td>
                <td class="text-left">
                    <strong>المجموع: </strong>
                    <strong>{{ playTotal }} جنيه</strong>
                </td>
                </tfoot>

            </v-table>

            <p class="text-h6 text-center">الكافيه</p>
            <v-table density="compact">
                <thead>
                <tr>
                    <th class="text-right">
                        السلعه
                    </th>
                    <th class="text-right">
                        السعر
                    </th>
                    <th class="text-right">
                        الكميه
                    </th>
                    <th class="text-right">
                        الاجمالي
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in device.active_bill.temp_items" :key="item.name">
                    <td>{{ item.item_name }}</td>
                    <td>{{ item.price }} جنيه</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.price * item.quantity }} جنيه</td>
                </tr>
                </tbody>
                <tfoot>
                <td colspan="3"></td>
                <td class="text-left">
                    <strong>المجموع: </strong>
                    <strong>{{ cartTotal }} جنيه</strong>
                </td>
                </tfoot>

            </v-table>
        </v-card-text>
        <hr/>
        <v-card-content>
            <v-row justify="center" align-content="center">
                <v-col cols="2" class="align-self-center">
                    <strong>المجموع الكلي: </strong>
                </v-col>
                <v-col cols="3" class="text-center">
                    <strong>{{ this.cartTotal + this.playTotal }}</strong>
                    <span class="mx-2">جنيه</span>
                </v-col>
            </v-row>

            <v-row justify="center" align-content="center">
                <v-col cols="2" class="align-self-center">
                    <strong>الخصم</strong>
                </v-col>
                <v-col cols="3">
                    <v-text-field
                        v-model="discount"
                        label="الخصم"
                        suffix="جنيه"
                        :disabled="totalCost <= 5"
                        :rules="[v => v <= 5 || 'الخصم يجب ان يكون اقل من 5 جنيه']"
                        density="compact"
                    ></v-text-field>
                </v-col>
            </v-row>

            <v-row justify="center" align-content="center">
                <v-col cols="2" class="align-self-center">
                    <strong>المبلغ المطلوب: </strong>
                </v-col>
                <v-col cols="3" class="text-center">
                    <strong>{{ totalCost  }}</strong>
                    <span class="mx-2">جنيه</span>
                </v-col>
            </v-row>
            <div>


            </div>

        </v-card-content>
        <v-card-actions>
            <div class="d-flex justify-content-between w-100">
                <div>
                    <v-switch v-model="printRecipt" label="طباعة الايصال" color="red" hide-details></v-switch>
                </div>
                <div>
                    <v-btn variant="outlined" color="green accent-4" size="large" @click="finishAndPay">دفع</v-btn>
                    <v-btn variant="outlined" color="deep-purple accent-4" size="large" @click="$emit('closeCheckoutDialog')">اغلاق </v-btn>
                </div>
            </div>
        </v-card-actions>
    </v-card>

</template>

<script>
import moment from "moment";
import axios from "../plugins/axios";

export default {
    name: "Checkout",
    props: {
        device: {
            type: Object,
            required: true
        },
        activeSessionDiff: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            discount: 0,
            printRecipt: true,
        }
    },
    computed: {
        cartTotal() {
            return this.device.active_bill.temp_items ? this.device.active_bill.temp_items.reduce((total, item) => total + item.price * item.quantity, 0) : 0;
        },
        playTotal() {
            let cost = this.device.active_bill.sessions ? this.device.active_bill.sessions.reduce((total, session) => total + this.calculateSessionCost(session), 0) : 0;
            return cost < 5 ? 5 : cost;
        },
        validDiscount() {
            return (!isNaN(this.discount) && this.discount > 0 && this.discount <= 5) ? this.discount:0;
        },
        totalCost() {
            return this.cartTotal + this.playTotal - this.validDiscount;
        }
    },
     methods: {
         prettyTime(time) {
             let date = time ? new Date(time) : new Date();
             return date.toLocaleTimeString('ar-EG', {
                 hour: '2-digit',
                 minute:'2-digit'
             });
         },
         timeDiffInMinutes(start, end) {
             end = end ? new Date(end) : new Date();
             start = new Date(start);
             let diff = end - start;
             return Math.floor(diff / 60000);
         },
         calculateSessionCost(session){
             let price = session.is_multi ? this.device.category.multi_price : this.device.category.price;
             let diff = (session.end_time ? moment(session.end_time).diff(moment(session.start_time),'minutes') : this.activeSessionDiff) / 60 ;
             let cost = price * diff;
             return Math.round(cost * 2) / 2;
         },

         finishAndPay() {
             axios.post(`/api/play/finish`, {
                 bill_id: this.device.active_bill.id,
                 printRecipt: this.printRecipt,
                 discount: this.discount,
                 paid: this.totalCost,
             }).then(response => {
                 this.device.active_bill = null;
                 this.$toast.open({
                     message: "تم تسجيل الفاتوره",
                     type: "success",
                     position: "bottom-left"
                 });
                 this.$emit('closeCheckoutDialog');
             }).catch(error => {
                 console.log(error);
             });
         },

     }
}
</script>

<style scoped>

</style>
