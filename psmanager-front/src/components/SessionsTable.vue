<template>
    <ul class="list-group m-2">
        <li class="list-group-item" v-for="session in sessions">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>{{ session.name }}</strong>
                    <small>{{ formatTime(session.start_time) }} - {{ formatTime(session.end_time) }}</small>
                    <h5 class="d-inline"><span class="badge bg-primary text-white mx-2">{{ Math.round(session.duration / 60) }} دقيقه</span></h5>
                    <h5 class="d-inline"><span class="badge bg-primary text-white mx-2">{{ session.is_multi ? 'مالتي':'عادي'}}</span></h5>
                </div>
                <div>
                    <strong>{{ session.cost }} جنيه</strong>
                </div>
            </div>
        </li>
    </ul>

</template>

<script>
import moment from "moment";

export default {
    name: "SessionsTable",
    props: {
        sessions: {
            type: Array,
            required: true
        }
    },
    methods: {
        formatTime: function (time) {
            moment.locale('ar');
            return moment(time).format('hh:mm:ss a')
        },
    }
}
</script>

<style scoped>

</style>
