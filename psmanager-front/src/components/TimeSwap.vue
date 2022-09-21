<template>
    <v-card class="px-16 py-2 text-center align-items-center">
        <v-card-title>
            تغيير وقت
            -
            {{ device_name}}
        </v-card-title>
    <v-card-content>
        <v-row>
            <v-col cols="12">
                <v-select
                    v-model="selected_device"
                    :items="devices"
                    item-title="name"
                    item-value="id"
                    label="الوقت"
                    type="time"
                    required
                ></v-select>
                <v-btn color="primary" @click="swapTime">تغيير الوقت</v-btn>
            </v-col>
        </v-row>
    </v-card-content>
    </v-card>
</template>

<script>
import axios from "@/plugins/axios";

export default {
    name: "Timeout",
    data: () => ({
        devices: [],
        selected_device: null,
    }),
    props: {
        bill_id: Number,
        device_name: String,
    },
    methods: {
        swapTime() {
            axios.post("/bill/swap", {
                device_id: this.selected_device,
                bill_id: this.bill_id,
            })
                .then((response) => {
                    console.log(response);
                    location.reload();

                })
                .catch((error) => {
                    console.log(error);
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
