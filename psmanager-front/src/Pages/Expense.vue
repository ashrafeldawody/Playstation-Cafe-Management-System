<template>
    <v-card>
        <v-card-header>
        <v-toolbar-title>
            <div class="d-flex justify-content-between w-100">
                <span class="headline">المصاريف</span>
                <v-btn color="primary" variant="outlined" @click="addDialog=true">تسجيل مصاريف</v-btn>
            </div>
        </v-toolbar-title>
    </v-card-header>
        <v-table class="table table-striped">
        <thead>
        <tr>
            <th class="text-right">
                التاريخ
            </th>
            <th class="text-right">
                السبب
            </th>
            <th class="text-right">
                التفاصيل
            </th>
            <th class="text-right">
                خصم من ايراد اليوم
            </th>
            <th class="text-right">
                القيمة
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="expense in expenses" :key="expense.id">
            <td>{{ formatDateTime(expense.created_at) }}</td>
            <td>{{ expense.type }}</td>
            <td>{{ expense.description }}</td>
            <td>{{ expense.take_from_dialy_income ? 'نعم':'لا' }}</td>
            <td>{{ expense.amount }} جنيه</td>
        </tr>
        </tbody>
            <tfoot>
            <tr>
                <td colspan="4"></td>
                <td>
                    المجموع:
                    <strong class="mx-3">
                        {{ totalExpense }}
                    </strong>
                    جنيه
                </td>
            </tr>
            </tfoot>
    </v-table>
    </v-card>
    <v-dialog v-model="addDialog" persistent @click:outside="addDialog=false">
        <AddExpense @closeDialog="addDialog = false" @added="addedExpense"></AddExpense>
    </v-dialog>
</template>

<script>
import axios from "../plugins/axios";
import moment from "moment";
import AddExpense from "@/components/AddExpense";
export default {
    name: "Expense",
    components: {AddExpense},
    data() {
        return {
            expenses: [],
            addDialog: false,
        };
    },
    methods: {
        formatDateTime(date) {
            moment.locale("ar");
            return moment(date).format("YYYY-MM-DD hh:mm:ss a");
        },
        addedExpense(expense) {
            this.expenses.push(expense);
            this.addDialog = false;
        }
    },
    computed: {
        totalExpense() {
            return this.expenses.reduce((total, expense) => {
                return total + parseFloat(expense.amount);
            }, 0);
        }
    },
    mounted() {
        axios.get('/api/expense')
            .then(response => {
                this.expenses = response.data;
            });
    }
}
</script>

<style scoped>

</style>
