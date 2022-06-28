<template>
    <ul class="list-group m-3">
        <li class="list-group-item" v-for="item in items">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>{{ item.item_name }} * {{ item.quantity }}</strong>
                </div>
                <div>
                    <strong>{{ item.price * item.quantity }} جنيه</strong>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
import moment from "moment";

export default {
    name: "CafeItemsTable",
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    methods: {

    }
}
</script>

<style scoped>

</style>
