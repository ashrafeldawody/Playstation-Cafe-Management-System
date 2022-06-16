<template>
    <v-app>
        <v-app-bar app color="indigo" >
            <div class="d-flex justify-content-between w-100">
            <div>
                <v-btn variant="outlined" color="white" href="/">الأجهزة</v-btn>
                <v-btn variant="outlined" class="mx-2" color="white" href="/cafe">الكافيه</v-btn>
                <v-btn variant="outlined" color="white" href="/income">الايراد</v-btn>
            </div>
            <div>
                <v-btn variant="outlined" color="white" href="/admin">لوحة التحكم</v-btn>
            </div>
            </div>
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

