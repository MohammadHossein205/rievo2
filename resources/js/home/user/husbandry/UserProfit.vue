<script setup>

import PriceChart from "@/home/user/husbandry/PriceChart.vue";
import axios from "axios";
import {onMounted, ref} from "vue";


const props = defineProps(['payment', 'today'])
const form = ref({
    payment: [],
    group_id_temp: [],
    group_id: '',
    id: '',
})
for (let i = 0; i < props.payment.length; i++) {
    if (props.payment[i].buyorsell == 1) {
        form.value.payment.push(props.payment[i])
    }
}
localStorage.setItem('today', props.today)

const dam_id = ref([])
const dam_vizhe_id = ref([])
const dam_weight = ref([])
const price_chart = ref([])
const chart_time = ref([])
const dam_price = ref(0)
const Percent = ref(0)
onMounted(async () => {
    for (let i = 0; i < form.value.payment.length; i++) {
        form.value.id = form.value.payment[i].id
        await axios.post('/user/payment_detail', form.value).then(res => {
            res.data.map((item) => {
                if (item.paymentable_type == 'App\\Models\\Dam')
                    dam_id.value.push(item.paymentable_id)
                else
                    dam_vizhe_id.value.push(item.paymentable_id)
            })
        })
    }
    await axios.post('/user/dam', dam_id.value).then(res => {
        res.data.data.map((item) => {
            form.value.group_id_temp.push(item.group_id_org)
            dam_weight.value.push(item.weight)
            dam_price.value += parseInt(item.price.toString().replace(/,/g, ""))
        })
    })
    await axios.post('/user/dam/vizhe', dam_vizhe_id.value).then(res => {
        res.data.data.map((item) => {
            form.value.group_id_temp.push(item.group_id_org)
            dam_weight.value.push(item.weight)
            dam_price.value += parseInt(item.disount_price.toString().replace(/,/g, ""))
        })
    })
    // console.log(form.value.group_id)
    for (let i = 0; i < form.value.group_id_temp.length; i++) {
        form.value.group_id = form.value.group_id_temp[i]
        await axios.post('/user/dam/FillChart', form.value).then(res => {
            for (let j = res.data.data.length - 1; j >= 0; j--) {
                price_chart.value.push(parseInt(res.data.data[j].price.toString().replace(/,/g, "")) * parseInt(dam_weight.value[i]))
                chart_time.value.push(res.data.data[j].created_at_chart)
                strPrice.value += price_chart.value[i] + ','
                strTime.value += chart_time.value[i] + ','
                fullMoney.value += price_chart.value[i]
                break;
            }
        })
    }
    Percent.value = ((parseInt(fullMoney.value.toString().replace(/\D/g, "")) - parseInt(dam_price.value.toString().replace(/\D/g, ""))) / ((parseInt(dam_price.value.toString().replace(/\D/g, "")) + parseInt(fullMoney.value.toString().replace(/\D/g, ""))) / 2) * 100)
    // strPrice.value.slice(0, strPrice.value.length - 2)
    // strTime.value.slice(0, strTime.value.length - 2)
    localStorage.setItem('time', strTime.value)
    localStorage.setItem('money', strPrice.value)
    IsMoney.value = true
})
const IsMoney = ref(false)
const strPrice = ref('')
const strTime = ref('')
const fullMoney = ref(0)
</script>

<template>
    <div class="dashChrtHed">
        <div class="dshHusRght">
            <span class="icon-Vector-1091"></span>
            <div class="dshHusRghtDiv">
                <p>سود شما از دامداری</p>
                <div>
                    <i>سود</i>
                    <strong>{{ fullMoney.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</strong>
                    <img src="../../../../../public/img/toman.png" alt="img"/>
                </div>
            </div>
        </div>
        <div class="dashHusLeft" v-if="Percent>0"><span>{{ Math.round(Percent) }}</span><i>%</i></div>
        <div class="dashHusLeft" v-else><span>0</span><i>%</i></div>
    </div>
    <div class="hidden-undefined"></div>
    <div class="chart-style">
        <price-chart :money="JSON.stringify(price_chart)" :time="chart_time" v-if="IsMoney"></price-chart>
    </div>
</template>

<style scoped>

</style>
