<template>
    <v-card class="p-3" min-width="600">
        <v-card-title>
            <v-toolbar-title>
                <span class="headline">تسجيل مصاريف</span>
            </v-toolbar-title>
        </v-card-title>
        <v-card-text>
            <v-form lazy-validation>
                <v-select v-model="expense.type" :items="items" label="النوع" required></v-select>
                <v-text-field v-model="expense.description" label="الوصف" required></v-text-field>
                <v-text-field v-model="expense.amount" label="القيمة" hide-details type="number" required></v-text-field>
                <v-checkbox v-model="expense.take_from_dialy_income" hide-details label="خصم من ايراد اليوم؟" required></v-checkbox>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="$emit('closeDialog')">اغلاق</v-btn>
            <v-btn color="primary" @click="submit">حفظ</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import axios from "@/plugins/axios";

export default {
    name: "AddExpense",
    data() {
        return {
            items: [
                'مرتب',
                'صيانة',
                'فواتير',
                'بضاعه',
                'أخرى'
            ],
            expense: {
                type: "",
                description: "",
                amount: 0,
                take_from_dialy_income: false,
            }
        };
    },
    methods: {
        submit() {
            if(this.expense.type === "") {
                this.$toast.open({
                    message: "يجب اختيار نوع المصاريف",
                    type: "error",
                    position: "top-right",
                    duration: 5000
                });
                return;
            }
            if(isNaN(this.expense.amount) || this.expense.amount === 0) {
                this.$toast.open({
                    message: "قيمة المصاريف يجب ان تكون رقم اكبر من صفر",
                    type: "error",
                    position: "top-right",
                    duration: 5000
                });
                return;
            }
            axios.post('/expense', this.expense).then(response => {
                this.$emit('added',response.data);
                this.expense = {
                    type: "",
                    description: "",
                    amount: "",
                    take_from_dialy_income: false,
                };
                this.$toast.open({
                    message: "تم تسجيل المصاريف بنجاح",
                    type: "success",
                    position: "top-right",
                    duration: 5000
                });
            });
        }
    }
}
</script>

<style scoped>

</style>
