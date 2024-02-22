<script setup>
import {controlledRef} from "@vueuse/core";
import {inject, ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";

const user = defineProps(['id'])
const form = ref({
    'id': user.id,
})

const settingForm = ref({
    'email_notification': 0,
    'new_order_accept_sms': 0,
    'new_order_cancel_sms': 0,
    'id': form.value.id,
})

const fillSettings = (str, value) => {
    if (str == 'email_notification') {
        settingForm.value.email_notification = value
    } else if (str == 'new_order_accept_sms') {
        settingForm.value.new_order_accept_sms = value
    } else if (str == 'new_order_cancel_sms') {
        settingForm.value.new_order_cancel_sms = value
    }
}
const IsSetting = ref(false)
const setting = ref()
axios.post('/get-user-notification-setting', form.value).then(res => {
    setting.value = res.data;
    settingForm.value.email_notification = setting.value.email_notification;
    settingForm.value.new_order_accept_sms = setting.value.new_order_accept_sms;
    settingForm.value.new_order_cancel_sms = setting.value.new_order_cancel_sms;
    IsSetting.value = true
})


const UpdateSetting = () => {
    axios.post('/edit-user-notification-setting', settingForm.value).then(res => {
        if (res.data == 200) {
            toast.success('تنظیمات شما با موفقیت ویرایش شد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        }
    }).catch(err => {
        toast.error('تنظیمات شما ویرایش نشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    })
}
</script>

<template>
    <div
        class="modal fade editUsrMdl"
        id="editNtfMdl"
        tabindex="-1"
        aria-hidden="true"
        v-if="IsSetting"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="editNtfFrm">
                    <div class="modalHedr">
                        <h1 class="modal-title">تنظیمات اطلاع رسانی</h1>
                        <button type="button" @click="UpdateSetting" data-bs-dismiss="modal" aria-label="Close">
                            ثبت تغییرات
                        </button>
                    </div>
                    <ul>
                        <li>
                            <strong>
                                از طریق ایمیل وضعیت حساب، دامداری و اطلاع رسانی های مدیریت را
                                دریافت میکنم
                            </strong>
                            <div class="editNtfChk">
                                <div class="form-check position-relative yesInput"
                                     @click="fillSettings('email_notification',1)">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="radio01"
                                        id="editRadio1"
                                        :checked="setting.email_notification==1"
                                    />
                                    <label class="form-check-label" for="editRadio1">
                                        بله
                                    </label>
                                </div>
                                <div class="form-check position-relative noInput"
                                     @click="fillSettings('email_notification',0)">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="radio01"
                                        id="editRadio2"
                                        :checked="setting.email_notification==0"
                                    />
                                    <label class="form-check-label" for="editRadio2">
                                        خیر
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <strong>
                                درصورت ثبت سفارش جدید، درخواست تایید سفارش را ارسال کن
                            </strong>
                            <div class="editNtfChk">
                                <div class="form-check position-relative yesInput"
                                     @click="fillSettings('new_order_accept_sms',1)">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="radio02"
                                        id="editRadio3"
                                        :checked="setting.new_order_accept_sms==1"
                                    />
                                    <label class="form-check-label" for="editRadio3">
                                        بله
                                    </label>
                                </div>
                                <div class="form-check position-relative noInput"
                                     @click="fillSettings('new_order_accept_sms',0)">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="radio02"
                                        id="editRadio4"
                                        :checked="setting.new_order_accept_sms==0"
                                    />
                                    <label class="form-check-label" for="editRadio4">
                                        خیر
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li>
                            <strong>
                                درصورت ثبت سفارش جدید، درخواست لغو سفارش را ارسال کن
                            </strong>
                            <div class="editNtfChk">
                                <div class="form-check position-relative yesInput"
                                     @click="fillSettings('new_order_cancel_sms',1)">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="radio03"
                                        id="editRadio5"
                                        :checked="setting.new_order_cancel_sms==1"
                                    />
                                    <label class="form-check-label" for="editRadio5">
                                        بله
                                    </label>
                                </div>
                                <div class="form-check position-relative noInput"
                                     @click="fillSettings('new_order_cancel_sms',0)">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="radio03"
                                        id="editRadio6"
                                        :checked="setting.new_order_cancel_sms==0"
                                    />
                                    <label class="form-check-label" for="editRadio6">
                                        خیر
                                    </label>
                                </div>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
