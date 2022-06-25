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
                <v-btn variant="outlined" color="white">
                    انهاء الشيفت
                    <v-dialog
                        v-model="confirmDialog"
                        activator="parent"
                    >
                        <v-card>
                            <v-card-text>
                                هل انت متأكد انك تريد انهاء الشيفت الحالي؟
                                <p class="text-danger">
                                    {{ shiftElapsed < (8*60*60) ? 'يرجي العلم انه لم تمر 8 ساعات، سيتم خصم المتبقي من المرتب' : '' }}
                                </p>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="confirmDialog = false">لا</v-btn>
                                <v-btn color="primary" @click="finishShift">نعم</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-btn>
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
            timer: null,
            confirmDialog: false,
            now: moment()
        }
    },
    props: {
        shift: Object,
    },
    methods: {
        finishShift() {
            this.$emit('endShift')
            clearInterval(this.timer)
            this.confirmDialog=false;
        },
    },
    mounted() {
        this.timer = setInterval(() => {
            this.now = moment()
        }, 1000);
    },
    computed: {
        shiftElapsedFormatted() {
            return moment.utc(this.shiftElapsed * 1000).format('HH:mm:ss');
        },
        shiftElapsed() {
            return this.now.diff(moment(this.shift.start_time), 'seconds');
        },
    }

}
</script>

<style scoped>

</style>

