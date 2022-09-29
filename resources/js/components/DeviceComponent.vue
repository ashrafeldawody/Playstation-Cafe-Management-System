<template>
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card text-center">
            <div class="p-2 bg-gray-light d-flex justify-content-between align-content-center">
                <h3>{{ device.name }}</h3>
                <button class="btn btn-primary" @click="currentDialog = 'timeSwap'" v-if="activeBill()">
                    <i class="fas fa-exchange-alt"></i>
                </button>
            </div>
            <div class="w-100 h-100 position-absolute text-white" style="background-color:rgb(0,0,0,0.6);z-index:111"
                v-if="this.device.active_bill?.time_limit > 0 && (timeDiff/60) > this.device.active_bill?.time_limit">
                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                    <h3>انتهي الوقت</h3>
                    <div class="row my-3 w-100 px-2">
                        <div class="col-8">
                            <select class="form-control" name="time_limit" v-model="time_limit">
                                <option v-for="time in timesList" :value="time.minutes">
                                    {{ time.label }}
                                </option>
                            </select>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-success" @click="extendTime">
                                <i class="fas fa-plus"></i>
                                اضافة وقت
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-success w-50" @click="currentDialog = 'payBill'">
                        <span>دفع</span>
                        <i class="fas fa-check mr-3"></i>
                    </button>

                </div>
            </div>
            <div class="card-body">

                <div>
                    <span class="display-1">{{ timeLabel() }}</span>
                    <span v-if="activeBill() && activeBill().time_limit > 0"
                          class="badge badge-danger">{{ formatTime(activeBill().time_limit * 60) }}</span>
                    <span v-if="activeBill() && activeBill().time_limit === 0" class="badge badge-success">مفتوح</span>
                </div>
                <div v-if="device.active_bill">
                    <table class="table">
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

                        <tr v-for="session in device.active_bill?.sessions">
                            <td>{{ prettyTime(session.start_time) }}</td>
                            <td v-if="session.end_time">{{ prettyTime(session.end_time) }}</td>
                            <td v-else>
                                <div class="spinner-border text-primary" role="status"><span
                                    class="sr-only">جارية...</span></div>
                            </td>
                            <td>{{ session.is_multi ? 'مالتي' : 'عادي' }}</td>
                            <td>{{ session === activeSession() ? activeSessionDiff : Math.round(session.duration / 60) }} دقيقة</td>
                            <td>{{ session === activeSession() ? calculateSessionCost(session) : session.cost }}
                                {{ currency }}
                            </td>
                        </tr>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="4">مجموع اللعب</th>
                            <th>{{ totalPlayCost() }} {{ currency }}</th>
                        </tr>
                        <tr>
                            <th colspan="4">مجموع الكافيه</th>
                            <th>{{ totalCafeCost() }} {{ currency }}</th>
                        </tr>
                        <tr>
                            <th colspan="4">الاجمالي</th>
                            <th>{{ totalCost() }} {{ currency }}</th>
                        </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row" v-if="device.active_bill">
                    <div class="col-2">
                        <button class="btn btn-danger btn-block" @click="delete_bill">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="col-4">
                        <button :class="['btn','btn-primary','btn-block']" :disabled="togglingMulti"
                                @click="this.toggleMulti">
                            <i :class="['fas',lastSession().is_multi ? 'fa-user': 'fa-users']"></i>
                            <span class="mx-1">
                                {{ lastSession().is_multi ? 'عادي' : 'مالتى' }}
                            </span>
                        </button>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-warning btn-block" @click="currentDialog = 'cart'">
                            <span>الكافيه</span>
                            <i class="fas fa-coffee"></i>
                        </button>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-success btn-block" @click="currentDialog = 'payBill'">
                            <span>دفع</span>
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="col-6">
                        <select class="form-control" name="time_limit" v-model="time_limit">
                            <option v-for="time in timesList" :value="time.minutes">
                                {{ time.label }}
                            </option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-warning btn-block" @click="startTime(true)">
                            <i class="fas fa-play ml-2"></i>
                            مالتي
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success btn-block" @click="startTime()">
                            <i class="fas fa-play ml-2"></i>
                            عادي
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="currentDialog" class="modal fade show " id="exampleModalLong" tabindex="-1"
         aria-labelledby="exampleModalLongTitle" style="display: block; padding-right: 17px;" aria-modal="true"
         role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ device.name }}</h5>
                </div>
                <div class="modal-body">
                    <DeviceCart v-if="currentDialog === 'cart'" :device="device" @close="currentDialog = null"
                                @CartSaved="cartSaved"></DeviceCart>
                    <TimeSwap v-if="currentDialog === 'timeSwap'" :bill_id="activeBill().id"
                              @close="currentDialog = null"></TimeSwap>
                    <PayBill v-if="currentDialog === 'payBill'"
                             :bill="activeBill()"
                             :totalPlayCost="totalPlayCost()"
                             :totalCafeCost="totalCafeCost()"
                             :totalCost="totalCost()"
                             :prettyTime="prettyTime"
                             :activeSession="activeSession()"
                             :calculateSessionCost="calculateSessionCost"
                             :currency="currency"
                             :activeSessionDiff="activeSessionDiff"
                             @paid="device.active_bill = null"
                             @close="currentDialog = null"></PayBill>
                </div>
            </div>
        </div>
    </div>
    <div v-if="currentDialog" class="modal-backdrop fade show"></div>
</template>

<script>
import axios from "./plugins/axios";
import moment from "moment";
import DeviceCart from "./DeviceCart";
import TimeSwap from "./TimeSwap";
import PayBill from "./PayBill";

export default {
    name: "DeviceComponent",
    components: {
        DeviceCart,
        TimeSwap,
        PayBill
    },
    data: () => ({
        timeDiff: 0,
        currency: 'جنيه',
        selected_item: 0,
        time_limit: 0,
        currentDialog: null,
        activeSessionDiff: 0,
        togglingMulti: false,
    }),

    props: {
        device: Object,
        items: Array,
        timesList: Array,
    },
    methods: {
        extendTime() {
            if(this.time_limit < 0) return;
            let limit = this.time_limit === 0 ? 0 : this.activeBill().time_limit + this.time_limit;
            axios.post(`/play/change_limit/${this.device.id}/${limit}`)
                .then(() => {
                    if(this.time_limit === 0) {
                        this.activeBill().time_limit = 0;
                    } else {
                        this.activeBill().time_limit += this.time_limit;
                    }
                });
        },
        delete_bill() {
            this.$swal({
                title: 'هل انت متاكد؟',
                text: "لن تستطيع استعادة الفاتورة مرة اخرى!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/play/delete_bill/${this.device.active_bill.id}`)
                        .then(() => {
                            this.$toast.success('تم حذف الفاتورة بنجاح');
                            location.reload();
                        }).catch((e) => {
                            this.$swal('حدث خطأ!', e.response.data.message, 'error')
                        })
                }

            });
    },
    cartSaved() {
        this.currentDialog = false;
        this.$forceUpdate()
    },
    prettyTime(time) {
        let date = new Date(time);
        return date.toLocaleTimeString('ar-EG', {
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    formatTime(time, include_seconds = false) {
        let hours = Math.floor(time / 3600);
        let minutes = Math.floor((time - hours * 3600) / 60);
        let seconds = time - hours * 3600 - minutes * 60;
        let time_str = `${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}`;
        if (include_seconds)
            time_str = `${time_str}:${seconds < 10 ? '0' + seconds : seconds}`;
        return time_str;
    },
    startTime(is_multi = false) {
        axios.post('/play/start', {
            device_id: this.device.id,
            is_multi,
            time_limit: this.time_limit
        }).finally(() => {
            location.reload();
        });
    },
    startTimer() {
        if (!this.device.active_bill) return;
        let timer = setInterval(() => {
            if (!this.device.active_bill)
                clearInterval(timer);
            this.timeDiff = moment().diff(moment(this.device.active_bill.sessions[0].start_time), 'seconds');
            this.activeSessionDiff = moment().diff(moment(this.activeSession().start_time), 'minutes');
            if (this.activeBill().time_limit > 0 && this.timeDiff > this.activeBill().time_limit && !this.timeDialog && !this.checkoutDialog)
                this.timeDialog = true;
        }, 1000)
    },
    changeTimeLimit(time_limit) {
        if (time_limit < 0) return;
        let limit = time_limit === 0 ? 0 : this.activeBill().time_limit + time_limit;
        axios.post(`/play/change_limit/${this.device.id}/${limit}`)
            .then(() => this.device.active_bill.time_limit = limit);
    },
    toggleMulti(e) {
        this.togglingMulti = true;
        axios.post(`/play/toggle_multi/${this.device.id}`)
            .then(response => {
                this.device.active_bill = response.data;
                this.$forceUpdate()
            }).finally(() => {
            this.togglingMulti = false
        });
    },

    calculateSessionCost(session) {
        let price = session.is_multi ? this.device.category.multi_price : this.device.category.price;
        let diff = (session.end_time ? moment(session.end_time).diff(moment(session.start_time), 'minutes') : this.activeSessionDiff) / 60;
        let cost = price * diff;
        return Math.round(cost);
    },
    timeLimitChanged(time_limit) {
        this.timeDialog = false
        this.changeTimeLimit(time_limit);
    },
    lastSession() {
        return this.activeBill()?.sessions[this.activeBill()?.sessions.length - 1];
    },
    activeBill() {
        return this.device.active_bill;
    },
    activeSession() {
        return this.activeBill() ? this.activeBill().sessions[this.activeBill().sessions.length - 1] : null;
    },
    timeLabel() {
        return this.activeBill() ? this.formatTime(this.timeDiff, true) : '00:00:00';
    },
    totalCafeCost() {
        if (!this.activeBill()) return 0;
        return this.activeBill().temp_items.reduce((acc, item) => acc + (parseInt(item.quantity) * parseFloat(item.price)), 0);
    },
    totalPlayCost() {
        if (!this.activeBill()) return 0;
        let cost = this.activeBill().sessions.reduce((total, session) => total + parseFloat(session.cost), 0);
        cost += this.calculateSessionCost(this.activeSession());
        console.log(this.activeBill().sessions)
        return cost < 5 ? 5 : cost;
    },
    totalCost() {
        return this.totalCafeCost() + this.totalPlayCost();
    },

}
,
computed: {
}
,
mounted()
{
    this.startTimer();
}
}
</script>

<style>

</style>
