<template>
    <div class="mb-2">
    <v-timeline align="end" side="end" direction="horizontal">

        <v-timeline-item vis hide-dot="1"></v-timeline-item>
        <v-timeline-item :dot-color="getRandomColor()" v-for="session in sessions" :key="session.id">
            <div>
                <strong>{{ formatTime(session.start_time) }}</strong>
                <div class="text-caption">
                    {{ session.is_multi ? 'مالتي' : 'عادي' }}
                </div>
            </div>
        </v-timeline-item>
        <v-timeline-item hide-dot="1"></v-timeline-item>
    </v-timeline>
    </div>
</template>

<script>
export default {
    name: "Timeline",
    props: {
        sessions: Array
    },
    methods: {
        formatTime(time) {
            let date = new Date(time);
            return date.toLocaleTimeString('ar-EG', {
                hour12: true,
                hour: "numeric",
                minute: "numeric"
            });
        },
        getRandomColor() {
            let letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    }
}
</script>

<style >
.v-timeline {
    justify-content: right;
}
</style>
