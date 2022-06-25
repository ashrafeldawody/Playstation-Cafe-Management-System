<template>
    <v-app>
        <v-app-bar app color="blue" >
            <div class="d-flex justify-content-between w-100">
            <div>
                <v-tab to="/" class="h-100 px-3" color="white">الأجهزة</v-tab>
                <v-tab class="h-100 px-3" color="white" to="/cafe">الكافيه</v-tab>
                <v-tab class="h-100 px-3" color="white" to="/income">الفواتير</v-tab>
                <v-tab class="h-100 px-3" color="white" to="/inventory">المخزون</v-tab>
                <v-tab class="h-100 px-3" color="white" to="/expense">المصاريف</v-tab>
                <v-tab class="h-100 px-3" color="white" to="/summary">ملخص اليوم</v-tab>
                <v-tab class="h-100 px-3" color="white" to="/overtime">الاوفر تايم</v-tab>
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

