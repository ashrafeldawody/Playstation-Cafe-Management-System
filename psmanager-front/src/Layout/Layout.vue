<template>
    <v-app>
        <v-app-bar app color="indigo" >
            <div class="d-flex justify-content-between w-100">
            <div>
                <Link class="v-btn v-btn--flat v-theme--light text-white v-btn--density-default v-btn--size-default v-btn--variant-outlined mx-3" href="/">الأجهزة</Link>


                <Link class="v-btn v-btn--flat v-theme--light text-white v-btn--density-default v-btn--size-default v-btn--variant-outlined mx-3" href="/cafe">الكافيه</Link>
                <Link class="v-btn v-btn--flat v-theme--light text-white v-btn--density-default v-btn--size-default v-btn--variant-outlined mx-3" href="/shift">اليوميه</Link>
            </div>
            <div>
                <v-btn variant="outlined" color="white" href="/admin">لوحة التحكم</v-btn>
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
import { Link } from '@inertiajs/inertia-vue3'

export default {
    name: "Layout",
    components: {
        Link
    },
    onMounted() {
        alert('Layout mounted');
        this.$vuetify.rtl = true
    },

}
</script>

<style scoped>

</style>

