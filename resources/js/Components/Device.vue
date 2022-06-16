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
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="session in activeBill.sessions"
                    :key="session.id"
                >
                    <td>{{ new Date(session.start_time).toLocalTimeString() }}</td>
                    <td>{{ session.end_time }}</td>
                </tr>
                </tbody>
            </v-table>

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

            <v-btn color="primary" @click="this.toggleMulti" :disabled="this.activeBill.sessions.length === 3" variant="outlined">{{ activeSession.is_multi ? 'تحويل عادي':'تحويل مالتي' }}</v-btn>
            <v-btn color="warning" @click="this.finishAndPay" variant="outlined">ايقاف ودفع</v-btn>
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
import axios from "axios";
import moment from "moment";
export default {
    name: "Device",
    components: {Timeline},
    data: () => ({
        multi: false,
        timeDiff: 0,
    }),

    props: {
        device: Object
    },
    methods: {
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
                },1000)
        },
        changeTimeLimit(time_limit) {
            axios.post(`/api/play/change_limit/${this.device.id}/${time_limit}`)
                .then(response => {
                    this.device.active_bill.time_limit = time_limit;
                });
        },
        toggleMulti(){
            if(this.activeBill.sessions.length === 3) return;
            axios.post(`/api/play/toggle_multi/${this.device.id}`)
                .then(response => {
                    this.device.active_bill = response.data;
                });
        },
        finishAndPay(){
            console.log('finishAndPay');
        },
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
        }
    },

     mounted() {
        this.startTimer();
    }
}
</script>

<style scoped>

</style>
