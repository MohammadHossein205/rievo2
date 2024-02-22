<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";


const props = defineProps(['payment'])
const payments = ref(props.payment)
const payment_details = ref([])
const paymentable_id = ref([])
const paymentable_id_vizhe = ref([])
const paymentable_type = ref([])
const dams = ref([])
const IsSell = ref([])

const form = ref({
    id: ''
})

onMounted(async () => {
    {
        let PaymentDetailArray = []
        for (let i = 0; i < payments.value.length; i++) {
            PaymentDetailArray.push(payments.value[i].id)
        }
        await axios.post('/user/payment_detail/resource/array', PaymentDetailArray).then(res => {
            // console.log(res.data)
            for (let i = 0; i < res.data.data.length; i++) {
                payment_details.value.push(res.data.data[i])
                paymentable_type.value.push(res.data.data[i].paymentable_type)
                if (paymentable_type.value == 'App\\Models\\Dam') {
                    paymentable_id.value.push(res.data.data[i].paymentable_id_org)
                } else {
                    paymentable_id_vizhe.value.push(res.data.data[i].paymentable_id_org)
                }
            }
            // res.data.data.map((item) => {
            //
            // })
        })
    }
    if (paymentable_id.value.length != 0) {
        await axios.post('/user/dam', paymentable_id.value).then(res => {
            res.data.data.map((item) => {
                dams.value.push(item)
                IsSell.value.push(false)
            })
        })
    }
    if (paymentable_id_vizhe.value.length != 0) {
        await axios.post('/user/dam/vizhe', paymentable_id_vizhe.value).then(res => {
            res.data.data.map((item) => {
                dams.value.push(item)
                IsSell.value.push(false)
            })
        })
    }
    for (let i = 0; i < dams.value.length; i++) {
        form.value.id = dams.value[i].id
        if (paymentable_type.value[i] == 'App\\Models\\Dam') {
            await axios.post('/user/check/sell', form.value).then(res => {
                if (res.data == true)
                    IsSell.value[i] = true
            })
        } else {
            await axios.post('/user/check/sell/vizhe', form.value).then(res => {
                if (res.data == true)
                    IsSell.value[i] = true
            })
        }
    }
})
</script>

<template>
    <div class="dshHistryTbl">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">نام</th>
                    <th scope="col">کد دام</th>
                    <th scope="col">نوع عملیات</th>
                    <th scope="col">تاریخ عملیات</th>
                    <th scope="col">توضیحات</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(dam,index) in dams">
                    <td>
                        <p>{{ dam.name }}</p>
                    </td>
                    <td>
                        <p>{{ dam.code }}</p>
                    </td>
                    <td>
                        <strong class="red" v-if="IsSell[index]">درخواست فروش</strong>
                        <strong class="green" v-else>تایید نهایی</strong>
                    </td>
                    <td>
                        <p>{{ payment_details[index].updated_at }}</p>
                    </td>
                    <td>
                        <strong class="red" v-if="IsSell[index]">فروش</strong>
                        <strong class="green" v-else>خرید</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>
