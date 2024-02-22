<script setup>
import {inject, onMounted, ref} from "vue";
import axios from "axios";
import {toast} from 'vue3-toastify';

const Id = defineProps(['user_id', 'ispay'])

const IsPaid = ref(false)
const payment = ref({
    payment_id: '',
    dam_id: '',
    dam_count: '',
    type: '',
    IsMonthly: '',
    payment_type: 'کارت',
    payment_discount: ''
})
if (Id.ispay != null) {
    IsPaid.value = true
    payment.value.payment_id = Id.ispay.split(':')[1]
}


const Money = ref(localStorage.getItem('allMoney'))
const damformlocal = ref(localStorage.getItem('dams_id'))
const dam_count = ref(localStorage.getItem('dam_count').split(','))
const dams = ref(damformlocal.value.toString().split(','))
const types = ref(localStorage.getItem('dam_type').toString().split(','))
if (localStorage.getItem('discount_price')) {
    payment.value.payment_discount = localStorage.getItem('discount_price')
}
const dam = ref([])
onMounted(async () => {

    const Id = ref({
        id: '',
        type: ''
    })
    // console.log(dams.value)
    for (let i = 0; i < dams.value.length; i++) {
        Id.value.id = dams.value[i]
        Id.value.type = types.value[i]
        await axios.post('/user/get/dam', Id.value).then(res => {
            dam.value.push(res.data.data[0])
        })
    }
})

const Pay_Way = ref('');
const form = ref({
    'user_id': Id.user_id,
    'money': '',
    'giveMoney': Money.value,
    'paymentable_id': '',
    'paymentable_type': '',
    'payment_type': '',
    'dam_count': '',
    'factor_id': localStorage.getItem('factor_id'),
    'discount_code': '',
    'discount_price': 0,
    'payment_time': 0,
    'payment_id': 0,
    'IsMonthly': localStorage.getItem('IsMonthly'),
    'dam_id': [],
})
console.log(localStorage.getItem('IsMonthly'))
const User_Money = ref(0)
const Continue = ref(true)
const pay_money = async () => {
    if (Pay_Way.value == 'wallet') {
        form.value.payment_type = 'کیف پول';
        await axios.post('/user/get/money', form.value).then(res => {
            User_Money.value = res.data
            if (User_Money.value >= Money.value) {
                axios.post('/user/give/money', form.value).then(res => {
                    if (res.data == 200) {
                        toast.success("مبلغ شما با موفقیت برداشت شد", {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        });
                        localStorage.clear()
                        setInterval(reload, 2000)
                    } else if (res.data == 'TimeError') {
                        toast.error("بدیل تغییر رمز عبور تا 24 ساعت نمیتوانید خرید کنید", {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        });
                    } else if (res.data == 400) {
                        toast.error("موجودی شما کمتر از مبلغ درخواستی است", {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        });
                        Continue.value = false
                    } else if (res.data == 0) {
                        toast.error("مبلغ نباید صفر وارد شود", {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        });
                        Continue.value = false
                    }
                })
            } else {
                toast.error("موجودی شما کافی نیست", {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
                Continue.value = false
            }
        }).catch(err => {
            form.value.money = Money.value;
            axios.post('/user/add/money', form.value).then(res => {
            })
        })
        if (Continue.value)
            for (let i = 0; i < dams.value.length; i++) {
                form.value.paymentable_id = dams.value[i]
                form.value.dam_count = dam_count.value[i]
                form.value.paymentable_type = types.value[i]
                await axios.post('/user/payment/money', form.value).then(res => {
                    form.value.payment_time = 1
                    form.value.payment_id = res.data
                })
            }

    } else if (Pay_Way.value == 'zarin') {
    } else {
        toast.error('نحوه پرداخت باید مشخص شود', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    }
}
const success = ref('false')

const PaymentDetail = async () => {///////////////////////////////////////////////////////
    for (let i = 0; i < dams.value.length; i++) {
        payment.value.dam_id = dams.value[i]
        payment.value.dam_count = dam_count.value[i]
        payment.value.type = dam.value[i].model_type
        payment.value.IsMonthly = localStorage.getItem('IsMonthly')
        console.log(payment.value.IsMonthly)
        await axios.post('/user/payment/payment_detail', payment.value).then(res => {
            if (res.data == 200) {
                success.value = 'true'
            }
        })
    }
    await axios.post('/user/factor/status', form.value)
    if (success.value) {
        toast.success('دام شما با موفقیت ثبت شد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
        localStorage.clear();
        setInterval(reload, 2000)
    } else {
        toast.error('دام ثبت نشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    }
}
const reload = () => {
    window.location.reload()
}
const form_url = ref(`/admin/payment/`)
const form_method = ref('get');
const discount_money = ref()
const IsDiscount = ref(false)
const IsDiscountOn = ref(false)
const CheckDiscount = () => {
    if (form.value.discount_code == '') {
        toast.error('ابتدا کد تخفیف را وارد کنید', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    } else
        axios.post('/user/CheckDiscount', form.value).then(res => {
            if (res.data == 'error_id') {
                toast.error("کد تخفیفی به نام شما ثبت نشده", {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
            } else if (res.data == 'wrong_code') {
                toast.error("کد وارد شده اشتباه است", {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
            } else {
                form.value.discount_price = res.data
                localStorage.setItem('discount_price', form.value.discount_price.toString())
                // discount_money.value = res.data.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                discount_money.value = new Intl.NumberFormat().format(parseInt(res.data.toString().replace(/\D/g, "")))
                IsDiscount.value = true
                IsDiscountOn.value = true
            }
        })
}

const discount_confirmation = (value) => {
    if (value == true) {
        if (parseInt(discount_money.value.toString().replace(/,/g, "")) < parseInt(Money.value)) {
            Money.value = (parseInt(Money.value) - parseInt(discount_money.value.toString().replace(/,/g, ""))).toString()
        } else {
            toast.error('مبلغ تخفیف شما از مبلغ اصلی بیشتر است', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT
            })
            discount_confirmation(false)
        }
        form.value.giveMoney = Money.value


    } else {
        IsDiscountOn.value = false
        form.value.discount_code = ''
        axios.put('/user/add/discount')
    }
    IsDiscount.value = false
}
</script>

<template>
    <section class="breadcrumbSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li><a href="#" class="transitionCls">سبد خرید</a></li>
                        <li>
                            <span>/</span>
                        </li>
                        <li><a href="#" class="transitionCls">تایید نهایی</a></li>
                        <li>
                            <span>/</span>
                        </li>
                        <li>
                            <a href="" class="transitionCls"> پرداخت </a>
                        </li>
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
                        <div class="payMetdRght">
                            <div class="cartSecTtl mb-3">
                                <span class="icon-Vector-781"></span>
                                <h2>انتخاب نحوه پرداخت</h2>
                            </div>
                            <form :action="Pay_Way=='zarin'? form_url + Money+0 : ''"
                                  :method="Pay_Way=='zarin'?form_method:''"
                                  class="payMethdFrm">
                                <div class="form-check transitionCls" v-if="!IsPaid">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="cartRadio"
                                        id="cartRadio01"
                                        @change="Pay_Way='wallet'"
                                    />
                                    <label class="form-check-label" for="cartRadio01">
                                        <img src="../../../../../public/img/wallet.png" alt="img"/>
                                        <p>پرداخت کیف پول</p>
                                    </label>
                                </div>
                                <div class="form-check transitionCls" v-if="!IsPaid">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="cartRadio"
                                        id="cartRadio02"
                                        @change="Pay_Way='zarin'"
                                    />
                                    <label class="form-check-label" for="cartRadio02">
                                        <img src="../../../../../public/img/bank01.png" alt="img"/>
                                        <p>سرویس پرداخت زیبال</p>
                                    </label>
                                </div>
                                <div class="form-check transitionCls" v-if="!IsDiscountOn && !IsPaid">
                                    <label class="form-check-label" for="cartRadio02">
                                        <p>کد تخفیف</p>
                                    </label>
                                    <input
                                        class="discount"
                                        type="text"
                                        maxlength="10"
                                        v-model="form.discount_code"
                                    />
                                </div>
                                <div class="form-check transitionCls" v-if="IsDiscount">
                                    <label class="form-check-label" for="cartRadio02">
                                        <p>مبلغ تخفیف شما {{ discount_money }} تومان است
                                            آیا مطمین به اعمال تخفیف هستید؟</p>
                                    </label>
                                </div>
                                <div class="form-button transitionCls" v-if="IsDiscount">
                                    <button class="button-discount confirm" type="button"
                                            @click="discount_confirmation(true)">بله
                                    </button>
                                    <button class=" button-discount confirm
                                    " type="button" @click="discount_confirmation(false)">
                                        خیر
                                    </button>
                                </div>
                                <button class="button-discount" type="button" @click="CheckDiscount"
                                        v-if="!IsDiscountOn && !IsPaid">
                                    اعمال تخفیف
                                </button>
                                <div class="payMethdBtn" v-if="!IsPaid">
                                    <button class="transitionCls" type="submit" v-if="Pay_Way=='zarin'">پرداخت</button>
                                    <button class="transitionCls" type="button" v-else @click="pay_money">پرداخت
                                    </button>
                                    <div>
                                        <strong>مبلغ نهایی قابل پرداخت</strong>
                                        <p class="position-relative">
                                            <img src="../../../../../public/img/toman.png" alt="img"/>
                                            {{
                                                // Money.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                                new Intl.NumberFormat().format(parseInt(Money.toString().replace(/\D/g, "")))
                                            }}
                                        </p>
                                    </div>
                                </div>
                                <div class="payMethdBtn">
                                    <button class="transitionCls" type="button" @click="PaymentDetail" v-if="IsPaid">
                                        ثبت نهایی
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="payMetdLeft">
                            <div class="cartSecTtl mb-3">
                                <span class="icon-Vector-781"></span>
                                <h2>لیست دام ها</h2>
                            </div>
                            <div class="livstockCrd" v-for="(dams,index) in dam">
                                <div class="livstckInfo">
                                    <img :src="dams.image.length!=0?dams.image[0].url:''"
                                         :alt="dams.name"/>
                                    <div>
                                        <h2>{{ dams.name }}</h2>
                                        <ul>
                                            <li>
                                                <span>نژاد</span>
                                                <p>{{ dams.group_company_id }}</p>
                                            </li>
                                            <li>
                                                <span>جنسیت</span>
                                                <p>{{ dams.gender }}</p>
                                            </li>
                                            <li>
                                                <span>سن</span>
                                                <p>{{ dams.ageYear }} سال و {{ dams.ageMonth }} ماه</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="livstockPric">
                                    <strong> {{ dam_count[index] }} راس</strong>
                                    <div>
                                        <span>قیمت</span>
                                        <p class="position-relative">
                                            <img src="../../../../../public/img/toman.png" alt="img"/>
                                            {{ dams.disount_price ? dams.disount_price : dams.price }}
                                        </p>
                                    </div>
                                </div>
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
