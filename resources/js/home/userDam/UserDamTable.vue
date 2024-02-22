<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";

const props = defineProps(['payment'])
const payments = ref(props.payment)

const dams = ref([])
const form = ref({
    id: '',
    payment_id: '',
    group_id: '',
    type: '',
    dam_id: [],
    dam_id_vizhe: [],
    buy_time: [],
})
const sumMoney = ref([])
const currentMoney = ref([])
const Percent = ref([])
const IsZian = ref([])
onMounted(async () => {

    let PaymentDetailId = []
    for (let i = 0; i < payments.value.length; i++) {
        if (payments.value[i].buyorsell == 1) {
            PaymentDetailId.push(payments.value[i].id)
        }
    }
    if (PaymentDetailId.length != 0)
        await axios.post('/user/payment_detail/resource/array', PaymentDetailId).then(res => {
            for (let j = 0; j < res.data.data.length; j++) {
                form.value.type = res.data.data[j].paymentable_type
                if (form.value.type == 'App\\Models\\Dam') {
                    form.value.dam_id.push(res.data.data[j].paymentable_id_org)
                } else {
                    form.value.dam_id_vizhe.push(res.data.data[j].paymentable_id_org)
                }
                form.value.buy_time.push(res.data.data[j].created_at)
            }
        })

    if (PaymentDetailId.length != 0) {
        await axios.post('/user/dam', form.value.dam_id).then(res => {
            res.data.data.map((item) => {
                dams.value.push(item)
            })
        })
        await axios.post('/user/dam/vizhe', form.value.dam_id_vizhe).then(res => {
            res.data.data.map((item) => {
                dams.value.push(item)
            })
        })
        {
            let groupId = []
            for (let i = 0; i < dams.value.length; i++) {
                groupId.push(dams.value[i].group_id_org)
            }

            await axios.get('/user/dam/FillChart/Array/All').then(res => {
                for (let j = 0; j < groupId.length; j++) {
                    for (let i = res.data.length - 1; i >= 0; i--) {
                        if (res.data[i].group_id == groupId[j]) {
                            sumMoney.value.push(res.data[i].price.toString().replace(/,/g, ""))
                            break;
                        }
                    }
                }
                for (let i = 0; i < dams.value.length; i++) {
                    currentMoney.value.push((parseInt(sumMoney.value[i]) * parseInt(dams.value[i].weight)).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                    Percent.value.push(Math.round((parseInt(currentMoney.value[i].toString().replace(/\D/g, "")) - parseInt(dams.value[i].disount_price ? dams.value[i].disount_price.toString().replace(/\D/g, "") : dams.value[i].price.toString().replace(/\D/g, ""))) / ((parseInt(dams.value[i].disount_price ? dams.value[i].disount_price.toString().replace(/\D/g, "") : dams.value[i].price.toString().replace(/\D/g, "")) + parseInt(currentMoney.value[i].toString().replace(/\D/g, ""))) / 2) * 100))
                    if (Percent.value[i] >= 0) {
                        IsZian.value.push(true)
                    } else {
                        IsZian.value.push(false)
                    }
                }
            })
        }
    }
})

</script>

<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">عکس</th>
            <th scope="col">کد دام</th>
            <th scope="col">تاریخ خرید</th>
            <th scope="col">ارزش اولیه</th>
            <th scope="col">ارزش فعلی</th>
            <th scope="col">درصد</th>
            <th scope="col">وضعیت</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(dam,index) in dams">
            <td>
                <img :src="dam.image.length!=0?dam.image[0].url:''" :alt="dam.name"/>
            </td>
            <td>
                <p>{{ dam.code }}</p>
            </td>
            <td>
                <p>{{ form.buy_time[index] }}</p>
            </td>
            <td>
                <p>{{ dam.disount_price ? dam.disount_price : dam.price }}</p>
            </td>
            <td>
                <p>{{ currentMoney[index] }}</p>
            </td>
            <td>
                <strong :class="{colorgreen:Percent[index]>=0 , colorred:Percent[index]<0}">{{
                        Percent[index]
                    }}%</strong>
            </td>
            <td>
                <strong class="colorgreen" v-if="IsZian[index]">سود</strong>
                <strong class="colorred" v-else>ضرر</strong>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
