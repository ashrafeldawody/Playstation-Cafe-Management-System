<template>
    <v-card class="mx-auto m-3 elevation-4" width="400">
        <v-card-header>
            <div class="d-flex justify-content-between w-100">
                <p class="text-h4 text--primary">
                    {{ device.name }}
                </p>
                <div class="rounded-circle" :class="device.active_bill ? 'bg-danger':'bg-success'" style="width: 2rem;height: 2rem"></div>
            </div>
        </v-card-header>
        <v-card-text>
            <div class="display-1 text-center">
                <v-badge location="bottom start"
                         v-if="activeBill"
                         :content="device.active_bill && device.active_bill.time_limit > 0 ? formatTime(device.active_bill.time_limit) : 'مفتوح'"
                         :color="device.active_bill && device.active_bill.time_limit > 0 ? 'error':'success'">
                    {{ timeLabel}}
                </v-badge>
                <span v-else>{{ timeLabel}}</span>
            </div>
            <v-table v-if="activeBill">
                <thead>
                <tr>
                    <th class="text-right">
                        بدء
                    </th>
                    <th class="text-right">
                        انتهاء
                    </th>
                    <th class="text-right">
                        النوع
                    </th>
                    <th class="text-right">
                        التكلفة
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="session in activeBill.sessions"
                    :key="session.id"
                >
                    <td>{{ prettyTime(session.start_time) }}</td>
                    <td v-if="session.end_time">{{prettyTime(session.end_time)}}</td>
                    <td v-else>
                        <v-progress-linear
                            color=" accent-4"
                            indeterminate
                            rounded
                            height="6"
                        ></v-progress-linear>
                    </td>
                    <td>{{ session.is_multi ? 'مالتي':'عادي' }}</td>
                    <td>{{ calculateSessionCost(session) }}</td>
                </tr>
                </tbody>

                <tfoot>
                <td colspan="2"></td>
                <td class="text-right">
                    <strong>المجموع</strong>
                </td>
                <td>
                    <strong>{{ totalCost }} جنيه</strong>
                </td>
                </tfoot>
            </v-table>
        <div>

        <v-dialog v-model="cartDialog" width="70%" height="90%" persistent fullscreen>
            <DeviceCart @closeCartDialog ="cartDialog = false" :bill="device.active_bill" :categories="items"></DeviceCart>
        </v-dialog>

        <v-dialog v-model="checkoutDialog" width="70%" height="90%" persistent fullscreen>
            <Checkout :bill="activeBill"></Checkout>
        </v-dialog>

        </div>
        </v-card-text>
        <v-card-actions v-if="!device.active_bill" >
            <v-switch
                v-model="multi"
                hide-details
                inset
                color="indigo"
                :label="`${multi ? 'مالتي':'عادي'}`"
            ></v-switch>

            <v-menu >
                <template v-slot:activator="{ props }">
                    <v-btn color="primary" v-bind="props">بدء وقت</v-btn>
                </template>
                <v-list>
                    <v-list-item @click="this.startTime(0)">
                        <v-list-item-title >وقت مفتوح</v-list-item-title>
                    </v-list-item>
                    <v-list-item v-for="index in 8" key="index" link @click="this.startTime(index*1800)">
                        <v-list-item-title >{{this.formatTime(index*1800)}}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>


        </v-card-actions>
        <v-card-actions v-else >
            <div class="d-flex justify-content-between w-100">

            <v-btn color="primary" @click="this.toggleMulti" :disabled="this.activeBill.sessions.length >= 3" variant="outlined">{{ activeSession.is_multi ? 'تحويل عادي':'تحويل مالتي' }}</v-btn>
            <v-btn color="warning" @click="cartDialog=true" variant="outlined">الكافيه</v-btn>
            <v-btn color="warning" @click="this.finishAndPay" variant="outlined">دفع</v-btn>
            <v-menu >
                <template v-slot:activator="{ props }">
                    <v-btn color="primary"  variant="outlined" v-bind="props">تغيير الوقت</v-btn>
                </template>
                <v-list>
                    <v-list-item @click="this.changeTimeLimit(0)">
                        <v-list-item-title >وقت مفتوح</v-list-item-title>
                    </v-list-item>
                    <v-list-item v-for="index in 8" key="index" link @click="this.changeTimeLimit(index*1800)">
                        <v-list-item-title v-if="activeBill">{{this.formatTime(index*1800)}}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            </div>

        </v-card-actions>

    </v-card>
</template>

<script>
import Timeline from "./Timeline";
import DeviceCart from "./DeviceCart";
import axios from "axios";
import moment from "moment";
import Checkout from "./Checkout";
export default {
    name: "Device",
    components: {Checkout, Timeline,DeviceCart},
    data: () => ({
        cartDialog: false,
        checkoutDialog:true,
        multi: false,
        timeDiff: 0,
        activeSessionDiff: 0,
    }),

    props: {
        device: Object,
        items: Array
    },
    methods: {
        prettyTime(time) {
            let date = new Date(time);
            return date.toLocaleTimeString('ar-EG', {
                hour: '2-digit',
                minute:'2-digit'
            });
        },
        formatTime(time,include_seconds=false) {
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor((time - hours * 3600) / 60);
            let seconds = time - hours * 3600 - minutes * 60;
            let time_str = `${hours<10 ? '0'+hours:hours}:${minutes<10 ? '0'+minutes:minutes}`;
            if(include_seconds)
                time_str = `${time_str}:${seconds<10 ? '0'+seconds:seconds}`;
            return time_str;
        },
        startTime(time_limit) {
            axios.post('/api/play/start', {
                device_id: this.device.id,
                is_multi: this.multi,
                time_limit: time_limit
            }).then(response => {
                this.device.active_bill = response.data;
                this.startTimer()
            });
        },
        startTimer(){
            if(this.device.active_bill)
                setInterval(()=>{
                    this.timeDiff = moment().diff(moment(this.device.active_bill.sessions[0].start_time),'seconds');
                    this.activeSessionDiff = moment().diff(moment(this.activeSession.start_time),'minutes');
                },1000)
        },
        changeTimeLimit(time_limit) {
            axios.post(`/api/play/change_limit/${this.device.id}/${time_limit}`)
                .then(response => {
                    this.device.active_bill.time_limit = time_limit;
                });
        },
        toggleMulti(){
            if(this.activeBill.sessions.length >= 3) return;
            axios.post(`/api/play/toggle_multi/${this.device.id}`)
                .then(response => {
                    this.device.active_bill = response.data;
                });
        },
        finishAndPay(){
            console.log('finishAndPay');
        },
        calculateSessionCost(session){
            let price = session.is_multi ? this.device.category.multi_price : this.device.category.price;
            let diff = (session.end_time ? moment(session.end_time).diff(moment(session.start_time),'minutes') : this.activeSessionDiff) / 60 ;
            return Math.round(price * diff * 100) / 100;
        }
    },
    computed: {
        activeBill() {
            return this.device.active_bill;
        },
        activeSession() {
            return this.activeBill ? this.activeBill.sessions[this.activeBill.sessions.length - 1] : null;
        },
        timeLabel() {
            return this.activeBill ? this.formatTime(this.timeDiff,true) : '00:00:00';
        },
        totalCost() {
            return this.activeBill ? this.activeBill.sessions.reduce((total,session)=>{
                return total + this.calculateSessionCost(session);
            },0) : 0;
        }
    },

     mounted() {
        this.startTimer();
    }
}
</script>

<style >

</style>
