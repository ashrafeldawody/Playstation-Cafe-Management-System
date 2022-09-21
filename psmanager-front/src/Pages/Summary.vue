<template>
    <v-card>
        <v-card-title>
            <span>ملخص اليوم</span>
        </v-card-title>
        <v-card-text v-if="stats">
            <div class="d-flex flex-wrap justify-content-center py-1 pl-2">
                <v-card class="p-3 w-25 m-3" v-for="stat of stats">
                    <v-card-title>
                        <span>{{ stat.label }}</span>
                    </v-card-title>
                    <v-card-text class="text-left">
                        <span class="mx-2 h5">{{ stat.value }}</span>
                        <span>{{ stat.unit }}</span>
                    </v-card-text>
                </v-card>
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
import axios from "@/plugins/axios";

export default {
    name: "Summary",
    data() {
        return {
            stats:null
        }
    },
    methods: {
        getStats() {
            axios.get('/stats')
                .then(response => {
                    this.stats = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.getStats();
    },

}

</script>

<style scoped>

</style>
