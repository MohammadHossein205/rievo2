<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import index from "@chenfengyuan/vue-countdown";
import {toast} from "vue3-toastify";
//
const proop = defineProps(['payments', 'factor', 'tax'])
const payments = ref(proop.payments)
const factors = ref(proop.factor)
const tax = ref(proop.tax)
const temp = ref([])
const factor_details = ref([])
const paymenttable_id = ref([])
const paymenttable_id_vizhe = ref([])
const dams = ref([])
const types = ref([])
//
const ninePercent = ref([])
const twoPercent = ref([])
const monthlyMoney = ref([])
//
const form = ref({
    id: '',
    group_id: '',
    type: ''
})
const current_dam_money = ref([])
const sode_money = ref([])
const IsZian = ref([])
const Percent = ref([])

onMounted(async () => {
    // Get Factor Detail

    let factorArr = []
    for (let i = 0; i < factors.value.length; i++) {
        factorArr.push(factors.value[i].id)
    }
    axios.post('/user/factor_detail', factorArr).then(res => {
        factor_details.value.push(res.data)
    })
    // Get Payment Detail
    {
        let paymentArr = []
        for (let i = 0; i < payments.value.length; i++) {
            paymentArr.push(payments.value[i].id)
        }
        await axios.post('/user/payment_detail/array', paymentArr).then(res => {
            res.data.map((item) => {
                temp.value.push(item)
            })
        })

    }
    // Get User Dam
    {
        temp.value.map((item) => {
            if (item.paymentable_type == 'App\\Models\\Dam') {
                paymenttable_id.value.push(item.paymentable_id)
                types.value.push('normal')
            } else {
                paymenttable_id_vizhe.value.push(item.paymentable_id)
                types.value.push('vizhe')
            }
        })
        await axios.post('/user/dam', paymenttable_id.value).then(res => {
            res.data.data.map((item) => {
                dams.value.push(item);
                TypeOfDam.value.push('normal')
            })
        })
        if (paymenttable_id_vizhe.value.length != 0) {
            await axios.post('/user/dam/vizhe', paymenttable_id_vizhe.value).then(res => {
                res.data.data.map((item) => {
                    dams.value.push(item);
                    TypeOfDam.value.push('vizhe')
                })
            })
        }
    }

    // Get Fill Chart
    {
        let group_id = []
        for (let i = 0; i < dams.value.length; i++) {
            group_id.push(dams.value[i].group_id_org)
        }
        // await axios.post('/user/dam/group_id', form.value).then(res => {
        //     form.value.group_id = res.data;
        // console.log(res.data)
        await axios.get('/user/dam/FillChart/Array/All').then(resp => {
            for (let i = 0; i < dams.value.length; i++) {
                for (let j = resp.data.length - 1; j >= 0; j--) {
                    if (parseInt(resp.data[j].group_id) == parseInt(group_id[i])) {
                        current_dam_money.value.push((parseInt(resp.data[j].price.toString().replace(/\D/g, "")) * parseInt(dams.value[i].weight)))
                        sode_money.value.push(current_dam_money.value[i] - parseInt(dams.value[i].disount_price ? dams.value[i].disount_price_org : dams.value[i].price_org))
                        if (sode_money.value[i] <= 0) {
                            IsZian.value.push(false)
                        } else {
                            IsZian.value.push(true)
                        }
                        Percent.value.push(parseInt((parseInt(current_dam_money.value[i].toString().replace(/\D/g, "")) - parseInt(dams.value[i].disount_price ? dams.value[i].disount_price : dams.value[i].disount_price_org))) / ((parseInt(dams.value[i].disount_price ? dams.value[i].disount_price_org : dams.value[i].price_org) + parseInt(current_dam_money.value[i].toString().replace(/\D/g, ""))) / 2) * 100)
                        break;
                    }
                }
            }
        })
    }
    //
    {
        for (let i = 0; i < dams.value.length; i++) {
            IsSell.value.push(false)
            ninePercent.value[i] = parseInt((dams.value[i].disount_price ? dams.value[i].disount_price_org : dams.value[i].price_org * parseFloat(tax.value.tax)) / 100)
            twoPercent.value[i] = parseInt((dams.value[i].disount_price ? dams.value[i].disount_price_org : dams.value[i].price_org * parseFloat(tax.value.commission)) / 100)

            if (factor_details.value[0][i]) {
                monthlyMoney.value.push(factor_details.value[0][i].monthly_money)
            } else {
                monthlyMoney.value.push(0)
            }
        }
        let DamId = []
        for (let i = 0; i < dams.value.length; i++) {
            form.value.id = dams.value[i].id
            if (TypeOfDam.value[i] == 'normal') {
                axios.post('/user/check/sell', form.value).then(res => {
                    if (res.data == true) {
                        IsSell.value[i] = true;
                    }
                })
                axios.post('/user/check/sell/confirmed', form.value).then(res => {
                    IsSellConfirmed.value.push(res.data)
                })
            } else {
                axios.post('/user/check/sell/vizhe', form.value).then(res => {
                    if (res.data == true) {
                        IsSell.value[i] = true;
                    }
                })
                axios.post('/user/check/sell/confirmed/vizhe', form.value).then(res => {
                    IsSellConfirmed.value.push(res.data)
                })
            }
        }
    }

    IsDam.value = true;
})

const IsDam = ref(false)
// sell
const IndexOfDam = ref(-1)
const TypeOfDam = ref([])
const IsSell = ref([])
const IsSellConfirmed = ref([])

const Sell = (index) => {
    IsSell.value[index] = true;
    form.value.id = dams.value[index].id;
    form.value.type = TypeOfDam.value[index]
    axios.post('/user/sell', form.value).then(res => {
        if (res.data == 100) {
            toast.error('درخواست شما ناموفق بود', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
        } else {
            toast.success("درخواست شما ثبت شد", {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
        }
    }).catch(err => {
        if (err.response.data.message == "") {
            toast.error('بدلیل تغییر رمز عبور تا 24 ساعت نمی توانید خرید و فروش کنید', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
            CancelSell(index)
        }
    })
}
const CancelSell = (index) => {
    IsSell.value[index] = false;
    form.value.id = dams.value[index].id
    axios.delete(`/user/cancel/sell/${form.value.id}`).then(res => {
        if (res.data == 200) {
            toast.success("درخواست شما برای فروش لغو شد", {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
        }
    })
}


</script>

<template>
    <div class="dashListCard" v-for="(dam,index) in dams" v-if="IsDam">
        <div class="dashListNotf red" v-if="IsSell[index]">
            <p>
                این دام برای فروش قرار داده شده است. پس از بررسی توسط
                تیم ریوو در صفحه فروشگاه لیست خواهد شد
            </p>
            <button class="transitionCls" @click="CancelSell(index)" v-if="IsSellConfirmed[index]==0">لغو درخواست فروش
            </button>
        </div>
        <div class="dshLstCrdHed">
            <div class="dshCrdSldr">
                <div
                    thumbsSlider=""
                    class="swiper AdSwiper1"
                    id="AdSwiper1"
                >
                    <div class="swiper-wrapper husbandry-swiper">
                        <div class="swiper-slide" v-for="(items,indexs) in dam.image">
                            <img :src="items.url" :alt="dam.name"/>
                        </div>
                    </div>
                </div>
                <div class="swiper AdSwiper2" id="AdSwiper2">

                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <img :src="dam.image.length!=0?dam.image[1].url:''" :alt="dam.name"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dshCrdInfo">
                <div class="crdInfoTop">
                    <div>
                        <h1>
                            <strong>دام، {{ dam.name }} {{ dam.haveMilk }}</strong>
                            <i>این دام به مدت {{ dam.dam_time }} ماه در دامداری شماست</i>
                        </h1>
                        <p>
                            <small>سن این دام</small>
                            <span>{{ dam.ageYear }} سال و {{ dam.ageMonth }} ماه</span>
                        </p>
                    </div>
                </div>
                <div class="dshCrdInfoUl">
                    <span>مشخصات دام</span>
                    <ul>
                        <li>
                            <strong> نژاد </strong>
                            <div>
                                <p>{{ dam.group_company_id }}</p>
                                <i class="orange">{{ dam.group_english }}</i>
                            </div>
                        </li>
                        <li>
                            <strong> جنسیت </strong>
                            <div>
                                <p>{{ dam.gender }}</p>
                            </div>
                        </li>
                        <li>
                            <strong>وزن</strong>
                            <div>
                                <p>{{ dam.weight }} کیلوگرم</p>
                                <i class="orange">KG</i>
                            </div>
                        </li>
                        <li>
                            <strong>نوع</strong>
                            <div>
                                <p>{{ dam.haveMilk }}</p>
                            </div>
                        </li>
                        <li>
                            <strong>رنگ پوست</strong>
                            <div>
                                <p>{{ dam.color }}</p>
                                <i class="orange">{{ dam.color_english }}</i>
                            </div>
                        </li>
                        <li>
                            <strong>تولید شیر</strong>
                            <div>
                                <p>{{ dam.milk_amount }} کیلوگرم</p>
                                <i class="green">روزانه</i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="dshLstCrdBdy">
            <div class="dashCrdRght">
                <div class="dshCrdBtmHed">
                    <h3>هزینه های نگهداری دارم</h3>
                    <p>(تمامی قیمت ها به تومان می باشد)</p>
                </div>
                <ul>
                    <li>
                        <span> {{ tax.tax }}% مالیات ارزش افزوده </span>
                        <p>{{
                                // ninePercent[index].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                new Intl.NumberFormat().format(ninePercent[index].toString().replace(/\D/g, ""))
                            }}</p>
                    </li>
                    <li>
                        <span>{{ tax.commission }}% کمیسیون سیستم</span>
                        <p>{{
                                // twoPercent[index].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                new Intl.NumberFormat().format(twoPercent[index].toString().replace(/\D/g, ""))
                            }}</p>
                    </li>
                    <li>
                        <span>هزینه ماهیانه</span>
                        <p>{{
                                // monthlyMoney[index].toString().replace(/\D/g, "")
                                //     .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                new Intl.NumberFormat().format(monthlyMoney[index].toString().replace(/\D/g, ""))
                            }}</p>
                    </li>
                </ul>
                <div class="dshCrdBtmfee">
                    <p>جمع کل</p>
                    <strong class="position-relative">
                        {{
                            // (ninePercent[index] + twoPercent[index] + monthlyMoney[index]).toString()
                            //     .replace(/\D/g, "")
                            //     .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            new Intl.NumberFormat().format((ninePercent[index] + twoPercent[index] + monthlyMoney[index]).toString()
                                .replace(/\D/g, ""))
                        }}
                    </strong>
                </div>
            </div>
            <div class="dashBdyLeft">
                <div class="crdChartHed">
                    <h3>نمودار سود</h3>
                    <div>
                        <p>سود شما از این دام</p>
                        <strong :class="{colorgreen : sode_money[index]>=0 ,  colorred : sode_money[index]<0}">{{
                                sode_money[index].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            }}</strong>
                        <img src="../../../../public/img/toman.png" alt="img"/>
                    </div>
                </div>
                <ul>
                    <li>
                        <span class="icon-Vector-1091"></span>
                        <div>
                            <p>ارزش اولیه</p>
                            <strong>{{ dam.disount_price ? dam.disount_price : dam.price }}</strong>
                        </div>
                    </li>
                    <li>
                        <span class="icon-Vector-838"></span>
                        <div>
                            <p>ارزش فعلی</p>
                            <strong>{{
                                    current_dam_money[index].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                }}</strong>
                        </div>
                    </li>
                    <li>
                        <span class="icon-Vector-852"></span>
                        <div>
                            <p>درصد تغییرات</p>
                            <strong :class="{colorgreen : sode_money[index]>=0 ,  colorred : sode_money[index]<0}">{{
                                    Math.round(Percent[index])
                                }}
                                <i>%</i>
                            </strong>
                        </div>
                    </li>
                </ul>
                <div class="hidden-undefined"></div>
                <user-chart :dam="dam" :payment="payments[index]"></user-chart>
            </div>
        </div>
        <button
            class="dshLstCrdBtn transitionCls"
            data-bs-target="#sellingMdl"
            data-bs-toggle="modal"
            @click="()=>{
                IndexOfDam=index
            }"
            v-if="!IsSell[index]"
        >
            <span class="icon-Vector-315"></span>
            <i>فروش این دام</i>
        </button>
    </div>
    <div
        class="modal fade sellingMdl"
        id="sellingMdl"
        tabindex="-1"
        aria-hidden="true"
        v-if="IndexOfDam!=-1"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="sellModlBox">
                    <div class="sellMdlRght">
                        <h1>فروش دام</h1>
                        <p class="">
                            لطفا بعد از برسی کامل اقدام به فروش دام خود نمایید لطفا دقت
                            فرمایید که قیمت گذاری نهایی توسط ریوو انجام خواهد شد و قابل
                            تغییر نخواهد بود
                        </p>
                        <p>
                            شما میتوانید میزان سود خود از این دام را در پنل سمت چپ مشاهده
                            نمایید
                        </p>
                        <!--                        <div class="sellMdlfee">-->
                        <!--                            <span>قیمت نهایی فروش</span>-->
                        <!--                            <strong class="position-relative"> 15,500,000 </strong>-->
                        <!--                        </div>-->
                        <button
                            class="transitionCls"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="Sell(IndexOfDam)"
                        >
                            تایید و ثبت فروش
                        </button>
                    </div>
                    <div class="sellMdlLeft">
                        <div class="sellPrdctCod">
                            <img :src="dams[IndexOfDam].image.length!=0?dams[IndexOfDam].image[0].url:''"
                                 :alt="dams[IndexOfDam].name"/>
                            <div>
                                <p>کد شناسایی این دام</p>
                                <strong>{{ dams[IndexOfDam].code }}</strong>
                            </div>
                        </div>
                        <div class="selPrdctName">
                            <div>
                                <strong>دام، {{ dams[IndexOfDam].group_company_id }}</strong>
                                <i>این دام به مدت {{ dams[IndexOfDam].dam_time }} ماه در دامداری شماست</i>
                            </div>
                            <div>
                                <small>سن این دام</small>
                                <span>{{ dams[IndexOfDam].ageYear }} سال و {{ dams[IndexOfDam].ageMonth }} ماه</span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <span class="icon-Vector-1091"></span>
                                <div>
                                    <p>ارزش اولیه</p>
                                    <strong>{{
                                            // dams[IndexOfDam].discount_price ? dams[IndexOfDam].discount_price : dams[IndexOfDam].price
                                            dams[IndexOfDam].disount_price ? dams[IndexOfDam].disount_price : dams[IndexOfDam].price
                                        }}</strong>
                                </div>
                            </li>
                            <li>
                                <span class="icon-Vector-838"></span>
                                <div>
                                    <p>ارزش فعلی</p>
                                    <strong>{{
                                            current_dam_money[IndexOfDam].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        }}</strong>
                                </div>
                            </li>
                            <li>
                                <span class="icon-Vector-852"></span>
                                <div>
                                    <p>درصد تغییرات</p>
                                    <strong
                                        :class="{colorgreen:Percent[IndexOfDam]>=0 , colorred:Percent[IndexOfDam]<0}"
                                        v-if="dams[IndexOfDam].disount_price"
                                    >{{
                                            (parseInt(current_dam_money[IndexOfDam]) - parseInt(dams[IndexOfDam].disount_price.toString().replace(/\D/g, ""))).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        }} ({{ Math.round(Percent[IndexOfDam]) }} <i>%</i>) </strong>
                                    <strong
                                        :class="{colorgreen:Percent[IndexOfDam]>=0 , colorred:Percent[IndexOfDam]<0}"
                                        v-else
                                    >{{
                                            (parseInt(current_dam_money[IndexOfDam]) - parseInt(dams[IndexOfDam].price.toString().replace(/\D/g, ""))).toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                        }} ({{ Math.round(Percent[IndexOfDam]) }} <i>%</i>) </strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
