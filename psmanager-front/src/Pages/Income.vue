<template>
    <v-card>
        <v-card-header>
            <v-toolbar-title>
                <div class="d-flex justify-content-between w-100">
                    <span class="headline">فواتير الشيفت</span>
                </div>
            </v-toolbar-title>
        </v-card-header>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-right">
                الجهاز
            </th>
            <th class="text-right">
                نوع الجهاز
            </th>
            <th class="text-right">
                تفاصيل اللعب
            </th>
            <th class="text-right">
                الكافيه
            </th>
            <th class="text-right">
                وقت محدود؟
            </th>
            <th class="text-right">
                تكلفه اللعب
            </th>
            <th class="text-right">
                تكلفه الكافيه
            </th>
            <th class="text-right">
                الخصم
            </th>
            <th class="text-right">
                الاجمالي
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="bill in bills" :key="bill.id">
            <td>{{bill.device? bill.device.name:''}}</td>
            <td>{{bill.device? bill.device.category.name:''}}</td>
            <td><SessionsTable v-if="bill.device" :sessions="bill.sessions" /></td>
            <td><CafeItemsTable v-if="bill.items.length > 0" :items="bill.items" /></td>
            <td>
                <span v-if="bill.time_limit > 0">{{ bill.time_limit/60 }} دقيقة</span>
                <span v-if="bill.time_limit === 0">مفتوح</span>
            </td>
            <td>{{ parseFloat(bill.cafe_total) }} جنيه</td>
            <td>{{ parseFloat(bill.play_total) }} جنيه</td>
            <td>{{ parseFloat(bill.discount) }} جنيه</td>
            <td>{{ parseFloat(bill.cafe_total) + parseFloat(bill.play_total) - parseFloat(bill.discount) }} جنيه</td>
        </tr>
        </tbody>
    </table>
    </v-card>
</template>

<script>
import axios from '@/plugins/axios'
import moment from "moment";
import SessionsTable from "@/components/SessionsTable";
import CafeItemsTable from "@/components/CafeItemsTable";
export default {
    name: "Income",
    components: {SessionsTable,CafeItemsTable},
    data: function () {
        return {
            bills: []
        }
    },
    methods: {

    },
    mounted: function () {
        axios.get('/api/bill')
            .then(response => {
                this.bills = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
}
</script>

<style scoped>

</style>
