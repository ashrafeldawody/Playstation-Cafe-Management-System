<template>
        <v-card width="100%" style="margin: 1rem auto">
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <Device v-for="device in devices" :device="device" :key="device.id"></Device>
                </div>
        </v-card>
</template>


<script>
import Device from "../components/Device";
import axios from '../plugins/axios';
export default {
    name: "Home",

    data() {
        return {
            devices: Array,
        }
    },
    components: {
        Device
    },
    methods: {

    },
    mounted() {
        axios.get('/play/devices')
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
