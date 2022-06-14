<template>
    <Layout>
        <v-card width="100%" style="margin: 2rem auto">
            <v-card-header>
                <v-card-header-text>
                    <v-card-title>This is a title</v-card-title>
                    <v-card-subtitle>This is a subtitle</v-card-subtitle>
                </v-card-header-text>
            </v-card-header>

            <v-card-text>
                This is content
            </v-card-text>
        </v-card>
    </Layout>
</template>


<script>
import Layout from '../Layout/Layout.vue'
export default {
    name: "Home",
    components: {
        Layout,
    },

}
</script>

<style scoped>

</style>
