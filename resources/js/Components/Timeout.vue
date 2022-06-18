<template>
    <v-card class="px-16 py-2 text-center align-items-center">
        <v-card-title>{{device.name}}</v-card-title>
        <v-progress-circular
            :size="70"
            :width="7"
            color="purple"
            class="my-3"
            indeterminate
        ></v-progress-circular>
        <span class="text-h5 text-center text-uppercase text-primary my-3">انتهي الوقت</span>
        <div class="d-flex justify-content-center w-100 mb-3 gap-3">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn color="primary" variant="outlined" v-bind="props">زيادة وقت</v-btn>
                </template>
                <v-list>
                    <v-list-item @click="$emit('timeChanged',0)">
                        <v-list-item-title>وقت مفتوح</v-list-item-title>
                    </v-list-item>
                    <v-list-item v-for="index in 8" key="index" link @click="$emit('timeChanged',index*1800)">
                        <v-list-item-title>{{ this.formatTime(index * 1800) }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-btn color="green accent-4" @click="$emit('showPay')" variant="outlined">دفع</v-btn>

        </div>
    </v-card>
</template>

<script>
export default {
    name: "Timeout",
    props: {
        device: Object,
    },
    methods: {
        formatTime(time, include_seconds = false) {
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor((time - hours * 3600) / 60);
            let seconds = time - hours * 3600 - minutes * 60;
            let time_str = `${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}`;
            if (include_seconds)
                time_str = `${time_str}:${seconds < 10 ? '0' + seconds : seconds}`;
            return time_str;
        },
    }
}
</script>

<style scoped>

</style>
