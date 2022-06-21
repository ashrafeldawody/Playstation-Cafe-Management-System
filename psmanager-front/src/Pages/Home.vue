<template>
    <Layout>
        <v-card width="100%" style="margin: 2rem auto">
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <Device v-for="device in devices" :items="items" :device="device" :key="device.id"></Device>
                </div>
        </v-card>
    </Layout>
</template>


<script>
import Layout from '../Layout/Layout.vue'
import Device from "../components/Device";
import axios from '../plugins/axios';
export default {
    name: "Home",

    data() {
        return {
            devices: Array,
            items: Array
        }
    },
    components: {
        Layout,
        Device
    },
    methods: {

    },
    mounted() {
        axios.get('/api/play/devices')
            .then(response => {
                this.devices = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        axios.get('/api/cafe/items')
            .then(response => {
                this.items = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    }

}
</script>

<style scoped>

</style>
