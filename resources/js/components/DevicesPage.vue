<template>
    <div class="row pt-1" dir="rtl">
        <DeviceComponent v-for="device in devices" :device="device" :items="items" :timesList="timesList"></DeviceComponent>
    </div>

</template>

<script>
import DeviceComponent from "./DeviceComponent";
export default {
    name: "DevicesPage.vue",
    components: {
        DeviceComponent
    },
    data() {
        return {
            timesList: [
                {label:'وقت مفتوح', minutes: 0},
                {label:'00:30', minutes: 30},
                {label:'01:00', minutes: 60},
                {label:'01:30', minutes: 90},
                {label:'02:00', minutes: 120},
                {label:'02:30', minutes: 150},
                {label:'03:00', minutes: 180},
                {label:'03:30', minutes: 210},
                {label:'04:00', minutes: 240},
                {label:'04:30', minutes: 270},
                {label:'05:00', minutes: 300},
            ],
        }
    },
    props: {
        devices: Array,
        user: Object,
        items: Array,
    },

}
</script>

<style scoped>

</style>
