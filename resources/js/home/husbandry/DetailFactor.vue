<script setup>
import {ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";

const proop = defineProps(['factors', 'user', 'tax'])
const factors = ref(proop.factors)
const user = ref(proop.user)
const tax = ref(proop.tax)


const detial_factor = ref([])
const dams = ref([])


const index_factor = ref(0)


const form = ref({
    factor_id: '',
    type: '',
    id: '',
})
const percent = (money, percent) => {
    return (money * percent) / 100
}
const IsDam = ref(false)
const ninePercent = ref([])
const twoPercent = ref([])
const monthlyMony = ref([])
const all_money = ref(0)
const dams_money = ref([])
const IsFactor = ref(false)
const detail = ref()
const types = ref([])
const IsMonthly = ref(false)
const GetDetailFactor = async (index) => {
    all_money.value = 0;
    ninePercent.value = []
    twoPercent.value = []
    dams_money.value = []
    IsMonthly.value = factors.value[index].IsMonthly
    index_factor.value = index;
    form.value.factor_id = factors.value[index].id
    await axios.post('/user/get/factor_detail', form.value).then(res => {
            if (res.data != 100) {
                IsFactor.value = true
                detail.value = res.data
                if (dams.value.length != 0) {
                    dams.value = []
                }
            } else {
                toast.error('فاکتور شما پیدا نشد', {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT
                })
            }
        }
    )
    if (IsFactor.value) {

        if (detial_factor.value.length != 0) {
            detial_factor.value.length = 0;
            monthlyMony.value.length = 0
            detial_factor.value.push(detail.value)
            for (let i = 0; i < detial_factor.value[0].length; i++) {
                form.value.id = detial_factor.value[0][i].factortable_id
                form.value.type = detial_factor.value[0][i].factortable_type
                types.value.push(detial_factor.value[0][i].factortable_type)
                await axios.post('/user/get/dam', form.value).then(res => {
                    dams.value.push(res.data.data)
                })
            }
        } else {
            detial_factor.value.length = 0;
            monthlyMony.value.length = 0
            detial_factor.value.push(detail.value)
            for (let i = 0; i < detial_factor.value[0].length; i++) {
                form.value.id = detial_factor.value[0][i].factortable_id
                form.value.type = detial_factor.value[0][i].factortable_type
                types.value.push(detial_factor.value[0][i].factortable_type)
                await axios.post('/user/get/dam', form.value).then(res => {
                    dams.value.push(res.data.data)
                })
            }

        }
    }
    for (let i = 0; i < dams.value.length; i++) {
        dams_money.value.push(dams.value[i][0].disount_price ? parseFloat(dams.value[i][0].disount_price_org) * parseFloat(detial_factor.value[0][i].count) : parseFloat(dams.value[i][0].price_org) * parseFloat(detial_factor.value[0][i].count))
        ninePercent.value.push(Math.round((parseFloat(dams_money.value[i]) * parseFloat(tax.value.tax)) / 100))
        twoPercent.value.push(Math.round((parseFloat(dams_money.value[i]) * parseFloat(tax.value.commission)) / 100))
        monthlyMony.value.push(parseFloat(detial_factor.value[0][i].monthly_money))
    }
    const frm = ref({
        damMoney: dams_money.value,
        tax: ninePercent.value,
        commission: twoPercent.value,
        MonthlyMoney: monthlyMony.value,
    })
    if (IsMonthly.value == false) {
        await axios.post('/user/sum/factor_detail', frm.value).then(res => {
            all_money.value = res.data
        })
    } else {
        await axios.post('/user/sum/monthly/factor_detail', frm.value).then(res => {
            all_money.value = res.data
        })
    }
    // for (let i = 0; i < dams.value.length; i++) {
    //     if (IsMonthly.value == false) {
    //         all_money.value += Math.round((parseFloat(dams_money.value[i]) + parseFloat(ninePercent.value[i]) + parseFloat(twoPercent.value[i])))
    //     } else {
    //         all_money.value += Math.round((parseFloat(ninePercent.value[i]) + parseFloat(twoPercent.value[i])))
    //     }
    // }
    // console.log(localStorage.getItem('dams'))
    const ids = ref('')
    const dams_count = ref('')

    // id
    dams.value.map((item) => {
        ids.value += item[0].id + ','
    })
    ids.value = ids.value.slice(0, ids.value.length - 1)
    localStorage.setItem('dams_id', ids.value)
    // count
    detial_factor.value[0].map((item) => {
        dams_count.value += item.count + ','
    })
    dams_count.value = dams_count.value.slice(0, dams_count.value.length - 1)
    localStorage.setItem('dam_count', dams_count.value)
    // moneys
    localStorage.setItem('allMoney', all_money.value)
    // Monthly
    localStorage.setItem('IsMonthly', IsMonthly.value)
    //factor id
    localStorage.setItem('factor_id', factors.value[index].id)
    //dams type
    localStorage.setItem('dam_type', types.value)
}
const IsPaid = ref(false)

</script>

<template>
    <div id="tabFour" class="tabcontent factorTab" v-if="factors.length!=0">
        <ul class="dshfactorLst" v-for="(factor,index) in factors">
            <li class="transitionCls">
                <div class="dshfactrItm">
                    <span class="icon-Vector-2321"></span>
                    <p>{{ factor.title }}</p>
                </div>
                <div class="dshfactrItm">
                    <span class="icon-Vector-876"></span>
                    <div>
                        <i>تاریخ صدور</i>
                        <strong>{{ factor.created_at }}</strong>
                    </div>
                </div>
                <div class="dshfactrItm">
                    <span class="icon-Vector-876"></span>
                    <div>
                        <i>پرداخت تا تاریخ</i>
                        <strong>{{ factor.expire_date }}</strong>
                    </div>
                </div>
                <div class="dshfactrLnk">
                    <div class="red" v-if="factor.status==0">نیاز به پرداخت</div>
                    <div class="green" v-if="factor.status==1">پرداخت شده</div>
                    <a href="#" class="transitionCls showFactrLnk" @click.prevent="GetDetailFactor(index)"
                    >مشاهده جزئیات</a
                    >
                </div>
            </li>
        </ul>
        <div class="factrDtailBx">
            <div class="factrBoxTop">
                <div>
                    <span class="icon-Vector-2321"></span>
                    <p>{{ factors[index_factor].title }}</p>
                </div>
                <i class="red" v-if="factors[index_factor].status==0">نیاز به پرداخت</i>
                <i class="green" v-if="factors[index_factor].status==1">پرداخت شده</i>
            </div>
            <div class="factrBxInfo">
                <ul>
                    <li>
                        <span class="icon-Vector-876"></span>
                        <div>
                            <p>تاریخ صدور</p>
                            <strong>{{ factors[index_factor].created_at }}</strong>
                        </div>
                    </li>
                    <li>
                        <span class="icon-Vector-876"></span>
                        <div>
                            <p>تاریخ صدور</p>
                            <strong>{{ factors[index_factor].created_at }}</strong>
                        </div>
                    </li>
                    <li>
                        <span class="icon-Vector-285"></span>
                        <div>
                            <p>توضیحات</p>
                            <strong>{{ factors[index_factor].description.slice(0, 50) }}</strong>
                        </div>
                    </li>
                    <li>
                        <span class="icon-Vector-5411"></span>
                        <div>
                            <p>صادر شده برای</p>
                            <strong>{{ user.fullname }} به کد ملی {{ user.nationalCode }}</strong>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="payableItems">
                <h2>موارد قابل پرداخت</h2>
                <div class="payablItmBx" v-for="(dam,index) in dams">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ردیف</th>
                                <th scope="col">کد دام</th>
                                <th scope="col">تاریخ خرید</th>
                                <th scope="col">تعداد</th>
                                <th scope="col">جمع</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <p>{{ index + 1 }}</p>
                                </td>
                                <td>
                                    <p>{{ dam[0].code }}</p>
                                </td>
                                <td>
                                    <p>{{
                                            new Date(detial_factor[0][index].created_at).toLocaleDateString('fa-IR', {
                                                year: 'numeric',
                                                month: 'numeric',
                                                day: 'numeric',
                                                hour: 'numeric',
                                                minute: 'numeric',
                                                second: 'numeric',
                                            })
                                        }}</p>
                                </td>
                                <td>
                                    <p>{{ detial_factor[0][index].count }}</p>
                                </td>
                                <td>
                                    <strong>{{
                                            // ((dam[0].disount_price ? parseInt(dam[0].disount_price.toString().replace(/,/g, '')) * parseInt(detial_factor[0][index].count) : parseInt(dam[0].price.toString().replace(/,/g, '')) * parseInt(detial_factor[0][index].count))).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                            dam[0].disount_price ? new Intl.NumberFormat().format(parseInt(dam[0].disount_price.toString().replace(/,/g, '')) * parseInt(detial_factor[0][index].count)) : new Intl.NumberFormat().format(parseInt(dam[0].price.toString().replace(/,/g, '')) * parseInt(detial_factor[0][index].count))
                                        }}</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="factrCostLst position-relative">
                        <strong>ریز هزینه ها</strong>
                        <i>(تمامی قیمت ها به تومان می باشد)</i>
                        <ul>
                            <li>
                                <span> {{ tax.tax }}% مالیات ارزش افزوده </span>
                                <p>{{
                                        // dam[0].disount_price ? (parseInt((dam[0].disount_price.toString().replace(/,/g, '') * detial_factor[0][index].count * tax.tax) / 100)).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") : (parseInt((dam[0].price.toString().replace(/,/g, '') * detial_factor[0][index].count * tax.tax) / 100)).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        dam[0].disount_price ? new Intl.NumberFormat().format(Math.round((parseInt(dam[0].disount_price.toString().replace(/,/g, '')) * detial_factor[0][index].count * parseFloat(tax.tax)) / 100)) : new Intl.NumberFormat().format(Math.round((parseInt(dam[0].price.toString().replace(/,/g, '')) * detial_factor[0][index].count * parseFloat(tax.tax)) / 100))
                                    }}</p>
                            </li>
                            <li>
                                <span>{{ tax.commission }}% کمیسیون سیستم</span>
                                <p>{{
                                        // dam[0].disount_price ? (parseInt((dam[0].disount_price.replace(/,/g, '') * detial_factor[0][index].count * tax.commission) / 100)).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") : (parseInt((dam[0].price.replace(/,/g, '') * detial_factor[0][index].count * tax.commission) / 100)).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        dam[0].disount_price ? new Intl.NumberFormat().format(Math.round((parseInt(dam[0].disount_price.toString().replace(/,/g, '')) * detial_factor[0][index].count * parseFloat(tax.commission)) / 100)) : new Intl.NumberFormat().format(Math.round((parseInt(dam[0].price.toString().replace(/,/g, '')) * detial_factor[0][index].count * parseFloat(tax.commission)) / 100))
                                    }}</p>
                            </li>
                            <li>
                                <span> هزینه ماهیانه </span>
                                <p>{{
                                        // detial_factor[0][index].monthly_money.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        new Intl.NumberFormat().format(detial_factor[0][index].monthly_money)
                                    }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="factrPayRow">
                <div class="factrTotal">
                    <div>
                        <p>جمع کل</p>
                        <strong class="position-relative">
                            <!--                            {{ all_money.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}-->
                            {{ new Intl.NumberFormat().format(all_money) }}
                        </strong>
                    </div>
                </div>
                <button class="transitionCls" v-if="factors[index_factor].status==0"><a href="/user/pay/dam"
                                                                                        class="teleport">پرداخت
                    فاکتور</a>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
