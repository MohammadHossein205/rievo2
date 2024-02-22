<script setup>
import {onBeforeMount, onMounted, ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";

const proop = defineProps(['user', 'tax'])
const IsDam = ref(false)
const dams = ref([])
const Taxs = ref(proop.tax)
const Types = ref([])
const IsBuying = ref(false)
onMounted(async () => {
    const damsToBuy = []
    const typesToBuy = []
    await axios.get('/get/cart').then(res => {
        res.data.map((item) => {
            damsToBuy.push(item.dam_id)
            typesToBuy.push(item.dam_type)
            dam_count.value.push(item.dam_count)
        })
    })
    for (let i = 0; i < dam_count.value.length; i++) {
        if (dam_count.value[i] > 1)
            decreas_dam.value[i] = true
    }
    const damId = ref({
        'id': '',
        'type': '',
    })
    for (let i = 0; i < damsToBuy.length; i++) {
        damId.value.id = damsToBuy[i]
        if (damsToBuy[i] != 'null' && typesToBuy[i] == 'App\\Models\\Dam') {
            damId.value.type = typesToBuy[i]
            await axios.post('/user/get/dam', damId.value).then(res => {
                dams.value.push(res.data.data[0])
                dam_count.value.push(1)
                decreas_dam.value.push(false)
                dams.value[i].price = dams.value[i].price.toString().replace(/,/g, "")
                all_money.value.push(dam_count.value[i] * dams.value[i].price)
                dams.value[i].price = dams.value[i].price.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                IsDam.value = true;
                sum_money.value += all_money.value[i]
                five_percent.value = PercentOfMoney(Taxs.value.commission)
                nine_percent.value = PercentOfMoney(Taxs.value.tax)
                Money();
                localStorage.setItem('money', Dams_sum_money.value)
                dam_count.value.push('1')
                localStorage.setItem('dam_count', dam_count.value)
            })
        } else if (damsToBuy[i] != 'null' && typesToBuy[i] == 'App\\Models\\Damvizhe') {
            damId.value.type = typesToBuy[i]
            await axios.post('/user/get/dam/vizhe', damId.value).then(res => {
                dams.value.push(res.data.data[0])
                dam_count.value.push(1)
                decreas_dam.value.push(false)
                dams.value[i].price = dams.value[i].price.toString().replace(/,/g, "")
                all_money.value.push(dam_count.value[i] * parseInt(dams.value[i].disount_price.toString().replace(/,/g, "")))
                dams.value[i].price = dams.value[i].price.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                IsDam.value = true;
                sum_money.value += all_money.value[i]
                five_percent.value = PercentOfMoney(Taxs.value.commission)
                nine_percent.value = PercentOfMoney(Taxs.value.tax)
                Money();
                localStorage.setItem('money', Dams_sum_money.value)
                dam_count.value.push(1)
                localStorage.setItem('dam_count', dam_count.value)
            })
        }
    }
})

const dam_count = ref([])
const decreas_dam = ref([])
const index = ref()

const damForm = ref({
    dam_id: '',
    dam_count: '',
    type: '',
})

const add_Dam = (index) => {
    dam_count.value[index]++;
    dams.value[index].price = dams.value[index].disount_price ? dams.value[index].disount_price.toString().replace(/,/g, "") : dams.value[index].price.toString().replace(/,/g, "")
    all_money.value[index] = dam_count.value[index] * parseInt(dams.value[index].price)
    sum_money.value = 0
    dams_money()
    five_percent.value = PercentOfMoney(Taxs.value.commission)
    nine_percent.value = PercentOfMoney(Taxs.value.tax)
    dams.value[index].price = dams.value[index].price.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (dam_count.value[index] > 1)
        decreas_dam.value[index] = true
    Money();
    damForm.value.dam_id = dams.value[index].id
    damForm.value.dam_count = dam_count.value[index]
    damForm.value.type = dams.value[index].model_type
    axios.post('/edit/cart', damForm.value).then(res => {
    })
}
const minez_dam = (index) => {
    if (dam_count.value[index] > 1) {
        dam_count.value[index]--;
        if (dam_count.value[index] == 1)
            decreas_dam.value[index] = false
        dams.value[index].price = dams.value[index].disount_price ? dams.value[index].disount_price.toString().replace(/,/g, "") : dams.value[index].price.toString().replace(/,/g, "")
        all_money.value[index] = dam_count.value[index] * parseInt(dams.value[index].price)
        sum_money.value = 0
        dams_money()
        five_percent.value = PercentOfMoney(Taxs.value.commission)
        nine_percent.value = PercentOfMoney(Taxs.value.tax)
        dams.value[index].price = dams.value[index].price.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        Money();
        damForm.value.dam_id = dams.value[index].id
        damForm.value.dam_count = dam_count.value[index]
        damForm.value.type = dams.value[index].model_type
        axios.post('/edit/cart', damForm.value).then(res => {
        })
    }

}
const change_dam_count = (index) => {

    if (dam_count.value[index] <= 1) {
        decreas_dam.value[index] = false
        dam_count.value[index] = 1
    }
    if (dam_count.value[index] > 1) {
        decreas_dam.value[index] = true
    }
    dams.value[index].price = dams.value[index].disount_price ? dams.value[index].disount_price.toString().replace(/,/g, "") : dams.value[index].price.toString().replace(/,/g, "")
    all_money.value[index] = dam_count.value[index] * parseInt(dams.value[index].price)
    sum_money.value = 0
    dams_money()
    five_percent.value = PercentOfMoney(Taxs.value.commission)
    nine_percent.value = PercentOfMoney(Taxs.value.tax)
    dams.value[index].price = dams.value[index].price.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    Money();
    damForm.value.dam_id = dams.value[index].id
    damForm.value.dam_count = dam_count.value[index]
    damForm.value.type = dams.value[index].model_type
    axios.post('/edit/cart', damForm.value).then(res => {
    })
}

const remove_dam = async (index) => {
    damForm.value.dam_id = dams.value[index].id
    damForm.value.dam_count = dam_count.value[index]
    damForm.value.type = dams.value[index].model_type
    if (damForm.value.type == 'App\\Models\\Dam') {
        await axios.delete(`/delete/cart/${damForm.value.dam_id}/normal`).then(res => {
            toast.success('دام حذف شد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        })
    } else {
        await axios.delete(`/delete/cart/${damForm.value.dam_id}/vizhe`).then(res => {
            toast.success('دام حذف شد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        })
    }
    setInterval(refresh, 2000)

}
const refresh = () => {
    window.location.reload()
}
const all_money = ref([])
const sum_money = ref(0)
const five_percent = ref(0)
const nine_percent = ref(0)
//
//                                          money
//
const Dams_sum_money = ref(0)
const dams_money = () => {
    for (let i = 0; i < all_money.value.length; i++) {
        sum_money.value += all_money.value[i]
    }
}
const PercentOfMoney = (percent) => {
    const money = ref((sum_money.value * percent) / 100)
    return Math.floor(money.value)
}
const Money = () => {
    Dams_sum_money.value = sum_money.value + five_percent.value + nine_percent.value
}

const form = ref({
    'user_id': proop.user.id,
    'dam': '',
    'dam_count': '',
    'factor': '',
    'dam_type': '',
})
const IsFactor = ref(false)
const Success = ref(false)
const Makefactor = async () => {
    if (!IsFactor.value) {
        IsBuying.value = true;
        // for (let i = 0; i < dams.value.length; i++) {
        // form.value.dam_id = dams.value[i].id
        // form.value.dam_count = dam_count.value[i]

        await axios.post('/user/create/factor', form.value).then(res => {
            form.value.factor = res.data;
            form.value.factor = form.value.factor.id
        })
        for (let i = 0; i < dams.value.length; i++) {
            form.value.dam = dams.value[i].id
            form.value.dam_count = dam_count.value[i]
            form.value.dam_type = dams.value[i].model_type
            await axios.post('/user/create/factor_detail', form.value).then(res => {
                if (res.data == 200) {
                    Success.value = true;
                    IsFactor.value = true;
                    localStorage.clear();
                } else {
                    Success.value = false
                }
            })
        }
        if (Success.value) {
            const deleteForm = ref({
                id: '',
                type: '',
            })
            for (let i = 0; i < dams.value.length; i++) {
                deleteForm.value.id = dams.value[i].id
                deleteForm.value.type = dams.value[i].model_type
                await axios.post('/delete/all/cart', deleteForm.value).then(res => {
                })
            }

            toast.success('در خواست شما برای ادمین ارسال شد و پس از تایید فاکتور صادر می شود', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
            setInterval(refresh, 2000)
        } else {
            toast.error('دام شما ثبت نشد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
        }
    } else {
        toast.error('دام شما قبلا ثبت شده است', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    }
}
</script>

<template>
    <section class="breadcrumbSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li><a href="#" class="transitionCls">سبد خرید</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="cartSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cartSecBx position-relative">
                        <div class="cartSecRght">
                            <div class="cartSecTtl mb-3">
                                <span class="icon-Vector-781"></span>
                                <h2>سبد خرید شما</h2>
                            </div>
                            <div class="cartSecCrd" v-for="(dam,index) in dams" v-if="IsDam">
                                <div class="cartCrdRght">
                                    <img
                                        :src="dam.image.length!=0?dam.image[0].url:''"
                                        class="cartCardImg"
                                        :alt="dam.name"
                                    />
                                    <div class="cartCrdInfo">
                                        <h2>{{ dam.name }}</h2>
                                        <ul>
                                            <li>
                                                <span>نژاد</span>
                                                <p>{{ dam.group_company_id }}</p>
                                            </li>
                                            <li>
                                                <span>جنسیت</span>
                                                <p>{{ dam.gender }}</p>
                                            </li>
                                            <li>
                                                <span>سن</span>
                                                <p>{{ dam.ageYear }} سال و {{ dam.ageMonth }} ماه</p>
                                            </li>
                                        </ul>
                                        <div class="cartCrdPric">
                                            <span>قیمت</span>
                                            <p class="position-relative">
                                                <img src="../../../../../public/img/toman.png" alt="img"/>
                                                {{ dam.disount_price ? dam.disount_price : dam.price }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item_Num_box">
                                    <span class="plus">تعداد</span>
                                    <input min="1" type="number" disabled id="num00" v-model="dam_count[index]"/>
                                    <button class="inpuSetZero" v-if="!decreas_dam[index]" @click="remove_dam(index)">
                                        <i class="icon-Vector-516"></i>
                                    </button>
                                    <!--                                    <span onclick="this.parentNode.querySelector('input[type=number]').stepDown()"-->
                                    <!--                                          class="" v-if="decreas_dam[index]" @click="minez_dam(index)"></span>-->
                                </div>
                            </div>
                        </div>
                        <div class="cartSecLeft">
                            <div class="cartSecTtl mb-3">
                                <span class="icon-Vector-781"></span>
                                <h2>مبلغ قابل پرداخت</h2>
                            </div>
                            <div class="PayInfoBx">
                                <div class="PayInfoHed">
                                    <strong>اطلاعات پرداخت</strong>
                                    <p>(تمامی قیمت ها به تومان می باشد)</p>
                                </div>
                                <ul>
                                    <li>
                                        <span> جمع نهایی دام ها </span>
                                        <p>
                                            {{
                                                sum_money.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span>{{ Taxs.tax }}% مالیات ارزش افزوده</span>
                                        <p>
                                            {{
                                                nine_percent.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span>{{ Taxs.commission }}% کمیسیون سیستم</span>
                                        <p>
                                            {{
                                                five_percent.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                            }}
                                        </p>
                                    </li>
                                </ul>
                                <strong>مبلغ نهایی قابل پرداخت</strong>
                                <p class="payInfoPric position-relative">
                                    <img src="../../../../../public/img/toman.png" alt="img"/>
                                    {{
                                        Dams_sum_money.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                    }}
                                </p>
                                <button class="transitionCls" @click="Makefactor" :disabled="IsBuying"
                                        v-if="parseInt(Dams_sum_money.toString())!=0">تایید و
                                    پرداخت
                                </button>
                                <button class="transitionCls" :disabled="!IsBuying" v-else>تایید و
                                    پرداخت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
