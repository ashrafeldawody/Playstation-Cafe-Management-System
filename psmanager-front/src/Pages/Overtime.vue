<template>
    <v-card>
        <v-card-header>
            <v-toolbar-title>
                    <span class="headline">شيفتات الشهر</span>
            </v-toolbar-title>
        </v-card-header>
        <v-table class="table table-striped">
            <thead>
            <tr>
                <th class="text-right">
                    وقت البدء
                </th>
                <th class="text-right">
                    وقت الانتهاء
                </th>
                <th class="text-right">
                    المده
                </th>
                <th class="text-right">
                    الاوفر تايم
                </th>
                <th class="text-right">
                    التكلفه
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="shift in shifts" :key="shift.id">
                <td>{{ formatDateTime(shift.start_time) }}</td>
                <td>{{ formatDateTime(shift.end_time) }}</td>
                <td>{{ formatDuration(shift.duration) }}</td>
                <td>
                    <v-chip :color="shift.overtime > 0 ? 'green':'red'">
                        {{ shift.overtime > 0 ? formatDuration(shift.overtime) : 'خصم' }}
                    </v-chip>
                </td>
                <td>
                    <v-chip :color="shift.overtimePrice > 0 ? 'green':'red'">
                        {{ Math.abs(shift.overtimePrice) }}
                        <span class="mr-3">جنيه</span>
                    </v-chip>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4"></td>
                <td>
                    المجموع:
                    <strong class="mx-3">
                        {{ totalBonus }}
                    </strong>
                    جنيه
                </td>
            </tr>
            </tfoot>
        </v-table>
    </v-card>
</template>

<script>
import axios from "@/plugins/axios";
import moment from "moment";

export default {
    name: "Overtime",
    data() {
        return {
            shifts: [],
        }
    },
    mounted() {
        axios.get('/stats/overtime')
            .then(response => {
                this.shifts = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        formatDateTime(date) {
            moment.locale("ar");
            return moment(date).format("YYYY-MM-DD hh:mm:ss a");
        },
        formatDuration(duration) {
            return moment.duration(duration, 'minutes').humanize();
        },
    },
    computed: {
        totalBonus() {
            return this.shifts.reduce((acc, shift) => {
                return acc + shift.overtimePrice;
            }, 0);
        }
    }
}
</script>

<style scoped>

</style>
