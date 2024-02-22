<script setup>
import {inject, ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";
import VueCountdown from "@chenfengyuan/vue-countdown";

const wallet = defineProps(['money', 'id', 'user', 'paymentcondition', 'ispaid']);

if (wallet.ispaid == 'success') {
    toast.success('مبلغ شما با موفقیت افزایش یافت', {
        autoClose: 3000,
        position: toast.POSITION.BOTTOM_RIGHT,
    })
}
const user = ref(wallet.user)
const PaymnetCondition = ref(wallet.paymentcondition)
const money = ref(wallet.money.money);
const CheckMoney = ref(parseInt(money.value.toString().replace(/,/g, '')))
const id = ref(wallet.id);
const CardIndexNumber = ref('')
money.value = money.value.toString().replace(/(\d)(?=(?:\d{3})+$)/g, '$1,')
// money.value = money.toLocaleString();
const MoneyAdding = ref('0')

const GetMoneyWithComma = (value) => {
    MoneyAdding.value = value
}

const form = ref({
    'user_id': id.value,
    'money': '',
    'giveMoney': '',
    'cardNumber': '',
})

const AddUserMoney = () => {
    form.value.money = MoneyAdding.value;
    axios.post('/user/add/money', form.value).then(res => {
        if (res.data == 200)
            toast.success('مبلغ شما با موفقیت افزایش یافت', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        else if (res.data == 0)
            toast.error('مبلغ نباید صفر وارد شود', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        else if (res.data == 100)
            toast.error('مبلغ وارد شده نباید بیشتر از 10 میلیون باشد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
    }).catch(err => {
        toast.error(err.message, {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    })
}
const GiveMoney = ref('0')
const GiveUserMoney = () => {
    if (CardIndexNumber.value) {
        if (parseInt(GiveMoney.value.toString().replace(/\D/g, "")) != 0) {
            if (CheckMoney.value >= parseInt(GiveMoney.value.toString().replace(/\D/g, ""))) {
                form.value.giveMoney = parseInt(GiveMoney.value.toString().replace(/\D/g, ""));
                form.value.cardNumber = CardIndexNumber.value;
                axios.post('/admin/set/give/money', form.value).then(res => {
                    if (res.data == 200) {
                        toast.success('درخواست شما برای ادمین ارسال شد', {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        })
                    } else {
                        toast.error('درخواست شما ثبت نشد', {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        })
                    }
                })
            } else {
                toast.error('موجودی شما کمتر از مبلغ درخواستی می باشد', {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                })
            }
        } else {
            toast.error('مبلغ نباید صفر وارد شود', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        }
        // axios.post('/user/give/money', form.value).then(res => {
        //     if (res.data == 200)
        //         toast.success('مبلغ شما با موفقیت برداشت شد', {
        //             autoClose: 3000,
        //             position: toast.POSITION.BOTTOM_RIGHT,
        //         })
        //     else if (res.data == 400)
        //         toast.error('موجودی شما کمتر از مبلغ درخواستی است', {
        //             autoClose: 3000,
        //             position: toast.POSITION.BOTTOM_RIGHT,
        //         })
        //     else if (res.data == 0)
        //         toast.error('مبلغ نباید صفر وارد شود', {
        //             autoClose: 3000,
        //             position: toast.POSITION.BOTTOM_RIGHT,
        //         })
        //     else if (res.data == 100)
        //         toast.error('مبلغ وارد شده نباید بیشتر از 10 میلیون باشد', {
        //             autoClose: 3000,
        //             position: toast.POSITION.BOTTOM_RIGHT,
        //         })
        // }).catch(err => {
        //     toast.error(err.message, {
        //         autoClose: 3000,
        //         position: toast.POSITION.BOTTOM_RIGHT,
        //     })
        // })
    } else {
        toast.error('ابتدا کارت خود را انتخاب کنید', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    }
}
const Cards = ref()
axios.post('/admin/bankcard/get_card', form.value).then(res => {
    if (res.data == 100) {
        toast.error('کارت پیدا نشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else {
        Cards.value = res.data
    }
})
const is_sms_chane = () => {
    IsSms.value = true
}
const IsSms = ref(true)

//
//
//
const formMobile = ref({
    mobile: user.value.mobile
})
const send_sms = () => {
    StartTimer.value = true
    axios.post('/send-sms', formMobile.value).then(res => {
        SmsValue.value = res.data
    }).catch(err => {
        toast.error(err.response.data.message, {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    })
}
const resendCode = async () => {
    sec.value = 60;
    await axios.post('/send-sms', form.value).then(res => {
        SmsValue.value = res.data
    }).catch(err => {
        if (err.response.data.message == 'Too Many Attempts.') {
            toast.error('درخواست ناموفق بود بعد از چند دقیقه تلاش کنید', {
                position: toast.POSITION.BOTTOM_RIGHT,
                autoClose: 3000,
            })
        } else
            toast.error(err.response.data.message, {
                position: toast.POSITION.BOTTOM_RIGHT,
                autoClose: 3000,
            })
    });
}
const CheckSmsValue = () => {
    if (UserSms.value.toString().toUpperCase() === SmsValue.value.toString()) {
        toast.success('اکنون می توانید موجودی خود را افزایش دهید', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
        IsSms.value = false
    } else {
        toast.error('کد وارد شده نادرست می باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    }
}
const UserSms = ref('')
const sec = ref(10)
const StartTimer = ref(false)
const SmsValue = ref();
</script>

<template>
    <div class="WalletBalanc">
        <div class="dshBalncRght">
            <span class="icon-Vector-1091"></span>
            <div class="dshBalncDiv">
                <p>موجودی کیف پول</p>
                <div>
                    <i>موجودی</i>
                    <strong>{{ money }}</strong>
                    <img src="../../../../public/img/toman.png" alt="img"/>
                </div>
            </div>
        </div>
        <div class="dshBalancLnk">
            <a href="#" class="transitionCls"
               data-bs-target="#increaseMdl"
               data-bs-toggle="modal"
            >افزایش موجودی</a>
            <a href="#" class="transitionCls" data-bs-target="#withdrawMdl"
               data-bs-toggle="modal">برداشت از حساب</a>
        </div>
    </div>

    <div class="modal fade increaseMdl" id="increaseMdl" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="get" :action="`/admin/payment/money/${MoneyAdding+'0'}`">
                <div class="modal-content">
                    <div class="incresMdlHed">
                        <h1>افزایش موجودی کیف پول</h1>
                        <p>لطفا مبلغ مورد نظر خود را انتخاب کنید و یا مبلغ دلخواه خود را در فیلد زیر وارد کنید</p>
                    </div>
                    <div class="chargAmount">
                        <p>انتخاب مبلغ قابل شارژ</p>
                        <div class="chrgAmontChk">
                            <div class="form-check transitionCls position-relative"
                                 @click="GetMoneyWithComma('200000')">
                                <input class="form-check-input" type="radio" name="numRadio" id="numRadio01"/>
                                <label class="form-check-label" for="numRadio01">200,000</label>
                            </div>
                            <div class="form-check transitionCls position-relative"
                                 @click="GetMoneyWithComma('300000')">
                                <input class="form-check-input" type="radio" name="numRadio" id="numRadio02"/>
                                <label class="form-check-label" for="numRadio02">300,000</label>
                            </div>
                            <div class="form-check transitionCls position-relative"
                                 @click="GetMoneyWithComma('400000')">
                                <input class="form-check-input" type="radio" name="numRadio" id="numRadio03"/>
                                <label class="form-check-label" for="numRadio03">400,000</label>
                            </div>
                            <div class="form-check transitionCls position-relative"
                                 @click="GetMoneyWithComma('500000')">
                                <input class="form-check-input" type="radio" name="numRadio" id="numRadio04"/>
                                <label class="form-check-label" for="numRadio04">500,000</label>
                            </div>
                            <div class="form-check transitionCls position-relative"
                                 @click="GetMoneyWithComma('600000')">
                                <input class="form-check-input" type="radio" name="numRadio" id="numRadio05"/>
                                <label class="form-check-label" for="numRadio05">600,000</label>
                            </div>
                        </div>
                    </div>
                    <div class="typeAmount">
                        <div class="frmInputBx mb-4">
                            <span class="icon-Vector-1091"></span>
                            <div class="position-relative">
                                <label for="inpt100" class="transitionCls">مبلغ مورد نظر خود را وارد کنید</label>
                                <input type="text" id="inpt100" class="transitionCls" v-model="MoneyAdding"/>
                            </div>
                        </div>
                        <button data-bs-dismiss="modal" aria-label="Close" type="submit" v-if="MoneyAdding!=0">افزایش
                            موجودی
                        </button>
                        <button data-bs-dismiss="modal" aria-label="Close" type="button" v-else @click="()=>{
                            toast.error('مبلغ نباید صفر باشد',{
                                autoClose:3000,
                                position:toast.POSITION.BOTTOM_RIGHT
                            })
                        }">افزایش موجودی
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Ticket Modal -->

    <div class="modal fade increaseMdl withdrawMdl" id="withdrawMdl" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="methdMdlTop">
                    <h1>برداشت از کیف پول</h1>
                    <p>لطفا مبلغ مورد نظر خود را برای برداشت وارد کنید</p>
                </div>
                <div class="frmInputBx mb-3">
                    <span class="icon-Vector-1091"></span>
                    <div class="position-relative">
                        <label for="inpt10" class="transitionCls">مبلغ مورد نظر خود را وارد کنید</label>
                        <input type="text" id="inpt10" class="transitionCls" v-model="GiveMoney"/>
                    </div>
                </div>
                <div class="methdMdlTxt">
                    <p>یکی از کارت های خود را انتخاب کنید</p>
                    <span>( مبلغ درخواستی به این کارت ارسال خواهد شد)</span>
                </div>
                <div class="payMthdMdl">
                    <div class="form-check transitionCls" v-for="card in Cards">
                        <input class="form-check-input" type="radio" name="cartRadio" id="cartRadio01"
                               @change="CardIndexNumber=card.cardnumber"/>
                        <label class="form-check-label" for="cartRadio01">
                            <img :src="card.image" alt="img"/>
                            <div>
                                <strong>{{ card.bankname }}</strong>
                                <p>{{ card.cardnumber }}</p>
                            </div>
                        </label>
                    </div>
                </div>
                <!--                #withdrawMdl1-->
                <!--                modal-->
                <button @click="GiveUserMoney" data-bs-dismiss="modal" aria-label="Close" data-bs-target=""
                        data-bs-toggle=""
                        v-if="CardIndexNumber!=''"
                >ثبت درخواست
                </button>
                <button @click="GiveUserMoney" v-else> ثبت درخواست
                </button>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
