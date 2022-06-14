<template>
    <v-app>
        <v-app-bar app color="indigo" class="">
            <v-btn variant="outlined" color="white" href="/devices">الأجهزة</v-btn>
            <v-btn variant="outlined" color="white" href="/cafe">الكافيه</v-btn>
            <v-btn variant="outlined" color="white" href="/income">الايراد</v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid class="p-3">
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>

</template>
<script>

export default {
    name: "Layout",
    onMounted() {
        alert('Layout mounted');
        this.$vuetify.rtl = true
    },

}
</script>

<style scoped>

</style>

