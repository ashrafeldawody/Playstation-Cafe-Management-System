<template>
        <v-card width="90vw" height="90vh">
            <div class="overflow-hidden">
                <v-row>
                    <v-col cols="8">
                        <v-card>
                            <v-tabs
                                v-model="category"
                                background-color="primary"
                            >
                                <v-tab value="one">Item One</v-tab>
                                <v-tab value="two">Item Two</v-tab>
                                <v-tab value="three">Item Three</v-tab>
                            </v-tabs>

                            <v-card-text>
                                <div class="d-flex justify-content-between flex-wrap gap-4 overflow-auto" style="height: 70vh">
                                    <v-card
                                        class="mx-auto"
                                        width="200px"
                                        v-for="index in 20"
                                        @click="alert('clicked')"
                                    >
                                        <v-img
                                            src="https://cdn.vuetifyjs.com/images/cards/house.jpg"
                                            cover
                                            :aspect-ratio="16/9"
                                        >
                                        </v-img>
                                        <v-card-title class="flex-column align-start">
                                            <p class=" mb-2">
                                                منتج رائع
                                            </p>
                                            <p class=" font-weight-regular text-grey">
                                                20 جنيه
                                            </p>
                                        </v-card-title>

                                    </v-card>

                                </div>
                            </v-card-text>
                        </v-card>

                    </v-col>
                    <v-col cols="4">
                        <v-card class="mx-auto" max-width="300">
                            <v-list :items="items"></v-list>
                        </v-card>

                    </v-col>

                </v-row>
            </div>

            <v-card-actions>
                <v-btn color="primary" block @click="closeCartDialog()">إغلاق</v-btn>
            </v-card-actions>
        </v-card>

</template>

<script>
export default {
    name: "DeviceCart",
    props: {
        device: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            category: null,
        }},
    methods: {
        closeCartDialog() {
            this.$emit("closeCartDialog");
        },
    }
}
</script>

<style scoped>

</style>
