<script setup>
import {ref} from "vue";
import {toast} from "vue3-toastify";
import axios from "axios";

const info = defineProps(['user']);
const user = ref(info.user);


const form = ref({
    'user_id': user.value.id,
    'card_number': '',
    'shaba_number': '',
    'bank_name': '',
    'image': '',
})
const index = ref(0)
const SaveCard = () => {
    if (form.value.card_number == '' || form.value.shaba_number == '' || form.value.card_number.length != 16 || form.value.shaba_number.length != 24) {
        return toast.error('در تکمیل کردن تمام قسمت ها دقت کنید', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    }
    const cards_number = ['', '603799', '589210', '627648', '627961', '603770', '628023', '627760', '502908', '627412', '622106', '502229', '627488', '621986', '639346', '639607', '636214', '502806', '502938', '603769', '610433', '627353', '589463', '627381', '639370','606256']
    const banks_name = ['', 'بانک ملی ایران', 'بانک سپه', 'بانک توسعه صادرات', 'بانک صنعت و معدن', 'بانک کشاورزی', 'بانک مسکن', 'پست بانک ایران', 'بانک توسعه تعاون', 'بانک اقتصاد نوین', 'بانک پارسیان', 'بانک پاسارگاد', 'بانک کارآفرین', 'بانک سامان', 'بانک سینا', 'بانک سرمایه', 'بانک تات', 'بانک شهر', 'بانک دی', 'بانک صادرات', 'بانک ملت', 'بانک تجارت', 'بانک رفاه', 'بانک انصار', 'بانک مهر اقتصاد','بانک ملل']
    const num = ref(form.value.card_number.substring(0, 6))
    for (let i = 0; i < cards_number.length; i++) {
        if (num.value == cards_number[i]) {
            index.value = i;
        }
    }
    if (index.value == 0) {
        return toast.error('بانک مورد نظر یافت نشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    } else {
        let img = document.getElementById('img')
        form.value.bank_name = banks_name[index.value]
        form.value.image = img.src
        axios.post('/admin/bankcard', form.value).then(res => {
        })
    }
}
</script>

<template>
    <div class="modal fade addBankMdl" id="addBankMdl1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="bankMdlRght">
                    <div class="bankMdlHed">
                        <h1>اضافه کردن کارت بانکی جدید</h1>
                        <p>لطفا شماره کارت خود و شماره شبا کارت را وارد کنید</p>
                        <span> کارت باید به نام صاحب حساب ریوو باشد </span>
                    </div>
                    <form>
                        <div class="frmInputBx mb-3">
                            <span class="icon-Vector-1091"></span>
                            <div class="position-relative">
                                <label for="inpt01" class="transitionCls">شماره کارت خود را وارد کنید</label>
                                <input type="text" id="inpt01" maxlength="16" class="transitionCls creditCrd_inpt"
                                       required v-model="form.card_number"/>
                            </div>
                        </div>
                        <div class="frmInputBx mb-5">
                            <span class="icon-Vector-402"></span>
                            <div class="position-relative">
                                <label for="inpt02" class="transitionCls">شماره شبا کارت را وارد کنید</label>
                                <input type="text" id="inpt02" class="transitionCls" maxlength="24"
                                       v-model="form.shaba_number"/>
                            </div>
                        </div>
                    </form>
                    <button data-bs-target="#addBankMdl2" data-bs-toggle="modal" @click="SaveCard"
                            v-if="(form.shaba_number!=''&&form.card_number!='')&&(form.shaba_number.length>23&&form.card_number>15)">
                        ثبت کارت جدید
                    </button>
                    <button @click="SaveCard"
                            v-if="(form.shaba_number==''||form.card_number=='')||(form.shaba_number.length<24||form.card_number<16)">
                        ثبت کارت جدید
                    </button>
                </div>
                <div class="bankMdlLft position-relative">
                    <div class="bankCardBx">
                        <div class="bankCardHed">
                            <div class="bankName">
                                <img src="../../../../../public/img/bank/shaparak.png" alt="" id="img"/>
                                <p>بانک</p>
                            </div>
                            <img class="shetabIcon" src="../../../../../public/img/shetab.png" alt="img"/>
                        </div>
                        <div class="bankNumber" id="bankNumber" v-if="form.card_number==''">....&nbsp;&nbsp;&nbsp; ....&nbsp;&nbsp;&nbsp;
                            ....&nbsp;&nbsp;&nbsp;
                            ....
                        </div>
                        <div class="bankNumber" id="bankNumber" v-if="form.card_number!=''">
                            {{ form.card_number.match(/.{1,4}/g).join().replaceAll(',', '    ') }}
                        </div>
                        <strong>{{ user.fullname }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade addBankMdl" id="addBankMdl2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="bankMdlRght">
                    <div class="addBnkReslt">
                        <div><span class="icon-Vector-103"></span></div>
                        <strong>درخواست شما ثبت شد</strong>
                        <p>شما میتوانید وضعیت درخواست خود را در بخش کیف پول مشاهده کنید</p>
                        <button data-bs-dismiss="modal" aria-label="Close">متوجه شدم</button>
                    </div>
                </div>
                <div class="bankMdlLft position-relative">
                    <div class="bankCardBx">
                        <div class="bankCardHed">
                            <div class="bankName">
                                <img :src="form.image" alt="img"/>
                                <p>{{ form.bank_name }}</p>
                            </div>
                            <img class="shetabIcon" src="../../../../../public/img/shetab.png" alt="img"/>
                        </div>
                        <div class="bankNumber bankNumber_fulled">
                            <div class="fulled">
                                <span class="position-relative filled" v-if="form.card_number!=''">{{
                                        form.card_number.match(/.{1,4}/g).join().replaceAll(',', '    ')
                                    }}</span>
                            </div>
                        </div>
                        <strong>{{ user.fullname }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
