<template>
    <v-overlay v-model="noShift" contained persistent class="align-center justify-center">
        <v-btn color="primary" class="mt-5" @click="start">
            <v-icon>mdi-clock-start</v-icon>
            <span>بدء الشيفت</span>
        </v-btn>
    </v-overlay>
    <Layout v-if="shift" @endShift="endShift" :shift="shift">
        <router-view></router-view>
    </Layout>
</template>

<script>

import axios from "@/plugins/axios";
import Layout from "@/Layout/Layout";

export default {
    name: 'App',
    components: {
        Layout,
    },
    data: () => ({
        noShift: null,
        shift: null,
    }),
    methods:{
        endShift(){
            axios.post('api/shift/end').then(()=>{
                this.noShift = true
            })
        },
        start() {
            axios.post('/api/shift/start').then(response => {
                this.noShift = false;
                this.shift = response.data;
            });
        }
    },
    beforeMount() {
        axios.get('/api/shift/check').then(response => {
            this.noShift = false;
            this.shift = response.data;
        }).catch(() => {
            this.noShift = true;
        });
    }
}
</script>

<style>
* {
    direction: rtl;
}
</style>
