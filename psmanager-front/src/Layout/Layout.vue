<template>
    <v-app>
        <v-app-bar app color="indigo" >
            <div class="d-flex justify-content-between w-100">
            <div>
                <router-link class="v-btn v-btn--flat v-theme--light text-white v-btn--density-default v-btn--size-default v-btn--variant-outlined mx-3" :to="{path:'/'}">الأجهزة</router-link>
                <router-link class="v-btn v-btn--flat v-theme--light text-white v-btn--density-default v-btn--size-default v-btn--variant-outlined mx-3" :to="{path:'cafe'}">الكافيه</router-link>
                <router-link class="v-btn v-btn--flat v-theme--light text-white v-btn--density-default v-btn--size-default v-btn--variant-outlined mx-3" :to="{path:'income'}">تفاصيل الشيفت</router-link>
            </div>
            <div>
                <span class="h5 text-white mx-5">
                    {{ shiftElapsedFormatted }}
                </span>
                <v-btn variant="outlined" color="white" @click="finishShift">انهاء الشيفت</v-btn>
            </div>
            </div>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid class="p-3 h-100 w-100">
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>

</template>
<script>
import moment from 'moment';
export default {
    name: "Layout",
    data() {
        return {
            shiftElapsed: null,
            timer: null,
        }
    },
    props: {
        shift: Object,
    },
    methods: {
        finishShift() {
            this.$emit('endShift')
            clearInterval(this.timer)
        },
    },
    mounted() {
        this.timer = setInterval(() => {
            this.shiftElapsed = moment().diff(moment(this.shift.start_time), 'seconds');
        }, 1000);
    },
    computed: {
        shiftElapsedFormatted() {
            return moment.utc(this.shiftElapsed * 1000).format('HH:mm:ss');
        }
    }

}
</script>

<style scoped>

</style>

