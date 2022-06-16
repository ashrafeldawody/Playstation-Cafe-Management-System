<template>
    <Layout>
        <v-card width="100%" style="margin: 2rem auto">
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <Device v-for="device in devices" :device="device" :key="device.id"></Device>
                </div>
        </v-card>
    </Layout>
</template>


<script>
import Layout from '../Layout/Layout.vue'
import Device from "../Components/Device";
export default {
    name: "Home",
    props: {
        devices: Array
    },
    data() {
        return {
            timeList: [],
        }
    },
    components: {
        Layout,
        Device
    },
    methods: {

    }

}
</script>

<style scoped>

</style>
