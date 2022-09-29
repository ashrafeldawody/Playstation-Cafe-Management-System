<template>
    <div class="card" v-if="devices.length > 0">
        <div class="card-header">
            <h4> تحويل الوقت الي جهاز آخر</h4>
        </div>
        <div class="card-body">
            <div class="row form-group">
                <label for="devices" class="col-3 col-form-label">الجهاز</label>
                <div class="col-6">
                    <select class="form-control" id="devices" v-model="selected_device">
                        <option v-for="device in devices" :value="device.id">{{ device.name }}</option>
                    </select>

                </div>
            </div>
        </div>
        <div class="card-footer text-left">
            <button class="btn btn-primary mx-3" @click="swapTime">تحويل</button>
            <button class="btn btn-danger" @click="this.$emit('close')">اغلاق</button>
        </div>
    </div>
    <div class="alert alert-danger text-center text-3xl" v-else>
        <p>جميع الجهازات مشغولة حاليا</p>
        <button class="btn btn-danger" @click="this.$emit('close')">اغلاق</button>
    </div>
</template>

<script>
import axios from "./plugins/axios";
export default {
    name: "TimeSwap.vue",
    data: () => ({
        devices: [],
        selected_device: null,
    }),
    props: {
        bill_id: Number,
    },
    methods: {
        swapTime() {
            axios.post("/bill/swap", {
                device_id: this.selected_device,
                bill_id: this.bill_id,
            })
            .then((response) => {
                location.reload();
            })
            .catch((error) => {
                console.log(error);
            }).finally(() => {
                this.$emit("close");
            });
        },
    },
    mounted() {
        axios.get('/play/devices/available')
            .then(response => {
                this.devices = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    }
}
</script>

<style scoped>

</style>
