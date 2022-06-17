<template>
    <v-card
        class="mx-auto"
    >
        <v-card-text>
            <div>جهاز 1</div>
            <p class="text-h4 text--primary">
                تفاصيل الفاتورة
            </p>
            <p class="text-h6 text-center">
                تفاصيل اللعب
            </p>
            <v-table max-height="300px">
                <thead>
                <tr>
                    <th class="text-right">
                        النوع
                    </th>
                    <th class="text-right">
                        وقت البدايه
                    </th>
                    <th class="text-right">
                        وقت النهايه
                    </th>
                    <th class="text-right">
                        المدة
                    </th>
                    <th class="text-right">
                        التكلفة
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in bill.sessions" :key="item.name">
                    <td>{{ item.is_multi ? 'مالتي':'عادي' }}</td>
                    <td>{{ prettyTime(item.start_time) }}</td>
                    <td>{{ prettyTime(item.end_time) }}</td>
                    <td>{{ 50 }}</td>
                    <td>{{ 10 }}</td>
                </tr>
                </tbody>
            </v-table>
            <p class="text-h6 text-center">
                تفاصيل اللعب
            </p>
            <v-table max-height="300px">
                <thead>
                <tr>
                    <th class="text-right">
                        النوع
                    </th>
                    <th class="text-right">
                        وقت البدايه
                    </th>
                    <th class="text-right">
                        وقت النهايه
                    </th>
                    <th class="text-right">
                        المدة
                    </th>
                    <th class="text-right">
                        التكلفة
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in bill.sessions" :key="item.name">
                    <td>{{ item.is_multi ? 'مالتي':'عادي' }}</td>
                    <td>{{ prettyTime(item.start_time) }}</td>
                    <td>{{ prettyTime(item.end_time) }}</td>
                    <td>{{ 50 }}</td>
                    <td>{{ 10 }}</td>
                </tr>
                </tbody>
            </v-table>

        </v-card-text>
        <v-card-actions>
            <v-btn
                text
                color="deep-purple accent-4"
            >
                Learn More
            </v-btn>
        </v-card-actions>
    </v-card>

</template>

<script>
export default {
    name: "Checkout",
    props: {
        bill: {
            type: Object,
            required: true
        }
    },
     methods: {
         prettyTime(time) {
             let date = time ? new Date(time) : new Date();
             return date.toLocaleTimeString('ar-EG', {
                 hour: '2-digit',
                 minute:'2-digit'
             });
         },
     }
}
</script>

<style scoped>

</style>
