<script setup>
import {inject, ref} from "vue";
import axios from "axios";
import {useDropzone} from "vue3-dropzone";
import {toast} from "vue3-toastify";
import DatePicker from "vue3-persian-datetime-picker";
import VueCountdown from '@chenfengyuan/vue-countdown';

const user = defineProps(['user', 'birthdate'])
const UserInfo = ref(user.user);

if (!UserInfo.value.image)
    UserInfo.value.image = 'http://localhost:8000/img/user.svg'

const GetUser = ref({
    'address': UserInfo.value.address,
    'fullName': UserInfo.value.fullname,
    'birthDate': user.birthdate,
    'email': UserInfo.value.email,
    'family': UserInfo.value.family,
    'homeNumber': UserInfo.value.homeNumber,
    'image': UserInfo.value.image,
    'mobile': UserInfo.value.mobile,
    'name': UserInfo.value.name,
    'nationalCode': UserInfo.value.nationalCode,
    'username': UserInfo.value.username,
    'id': UserInfo.value.id,
    'CurrentPassword': '',
    'NewPassword': '',
    'Password_Confirmation': '',
})
const SmsValue = ref();

const SaveUserPassword = ref(GetUser.value.CurrentPassword)


const fill_form = (userInfo) => {
    formData.append('address', userInfo.address)
    formData.append('fullName', userInfo.fullName)
    formData.append('birthDate', userInfo.birthDate)
    formData.append('email', userInfo.email)
    formData.append('family', userInfo.family)
    formData.append('homeNumber', userInfo.homeNumber)
    formData.append('mobile', userInfo.mobile)
    formData.append('name', userInfo.name)
    formData.append('nationalCode', userInfo.nationalCode)
    formData.append('username', userInfo.username)
    formData.append('id', userInfo.id)
    formData.append('CurrentPassword', userInfo.CurrentPassword)
    formData.append('NewPassword', userInfo.NewPassword)
    formData.append('Password_Confirmation', userInfo.Password_Confirmation)
}

const StartTimer = ref(false)

const SendCode = () => {
    if (GetUser.value.CurrentPassword != '') {
        if (GetUser.value.NewPassword != '') {
            if (GetUser.value.Password_Confirmation != '') {
                if (GetUser.value.NewPassword != GetUser.value.Password_Confirmation) {
                    toast.error('رمز عبور تاییدیه برابر نیست', {
                        autoClose: 3000,
                        position: toast.POSITION.BOTTOM_RIGHT,
                    })
                    return;
                } else {
                    fill_form(GetUser.value)
                    axios.post('/send-sms', GetUser.value).then(res => {
                        SmsValue.value = res.data
                    }).catch(err => {
                        toast.error(err.response.data.message, {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        })
                    });
                    return;
                }
            } else {
                toast.error('رمز عبور تاییدیه باید وارد شود', {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                })
                return
            }
        }
    }
    if (GetUser.value.address == '') {
        return toast.error('ادرس نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.fullName == '') {
        return toast.error('نام و نام خانوادگی نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.birthDate == '') {
        return toast.error('تاریخ تولد نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.email == '') {
        return toast.error('ایمیل نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.homeNumber == '') {
        return toast.error('شماره ثابت نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.mobile == '') {
        return toast.error('شماره موبایل نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.nationalCode == '') {
        return toast.error('کدملی نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else if (GetUser.value.username == '') {
        return toast.error('نام کاربری نمی تواند خالی باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    }
    StartTimer.value = true
    GetUser.value.NewPassword = '';
    GetUser.value.Password_Confirmation = '';
    fill_form(GetUser.value)
    axios.post('/send-sms', GetUser.value).then(res => {
        SmsValue.value = res.data
    }).catch(err => {
        toast.error(err.response.data.message, {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    });
    return;
}
const UserCode = ref();
const EditChecked = () => {
    if (UserCode.value.toUpperCase() == SmsValue.value) {
        axios.post('/user/dashboard/update', formData).then(res => {
            if (res.data == 200) {
                toast.success('کاربر با موفقیت ویرایش شد', {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                })
            } else if (res.data == 400) {
                toast.error('رمز عبور فعلی شما نادرست می باشد', {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                })
            }
        }).catch(error => {
            toast.error(error.response.data.message, {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        })
    } else {
        toast.error('کد وارد شده ی شما نادرست می باشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    }
}

const formData = new FormData();
const saveFiles = (files) => {
    for (var x = 0; x < files.length; x++) {
        // append files as array to the form, feel free to change the array name
        formData.append("image", files[x]);
    }
}

function onDrop(acceptFiles, rejectReasons) {
    saveFiles(acceptFiles); // saveFiles as callback
}

const {getRootProps, getInputProps, ...rest} = useDropzone({onDrop});


const resendCode = async () => {
    sec.value = 60;
    await axios.post('/send-sms', GetUser.value).then(res => {
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
const sec = ref(10)


</script>

<template>


    <div
        class="modal fade editUsrMdl"
        id="editUsrMdl"
        tabindex="-1"
        aria-hidden="true"

    >

        <div class="modal-dialog modal-xl" style="position:relative;">

            <div class="modal-content">
                <div class="modalHedr">
                    <h1>ویرایش اطلاعات کاربری</h1>
                    <button @click="SendCode"
                            v-if="GetUser.address==''||GetUser.fullName==''||GetUser.birthDate==''||GetUser.email==''||GetUser.homeNumber==''||GetUser.mobile==''||GetUser.nationalCode==''||GetUser.username==''">
                        ذخیره و ثبت اطلاعات
                    </button>
                    <button @click="SendCode" data-bs-target="#editUsrMdl2" data-bs-toggle="modal" v-else>
                        ذخیره و ثبت اطلاعات
                    </button>

                </div>
                <form>
                    <div class="editUsrFrm">
                        <div class="editMdlRght">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="mdlChangPic">
                                        <img
                                            :src="GetUser.image"
                                            id="uploadedImage"
                                            alt=""
                                        />
                                        <div v-bind="getRootProps()" class="uploadBtn position-relative">
                                            <span>تغییر تصویر کاربری</span>
                                            <input v-bind="getInputProps()"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="frmInputBx">
                                        <span class="icon-Vector-671"></span>
                                        <div class="position-relative">
                                            <label for="inpt01" class="transitionCls">ایمیل</label>
                                            <input type="email" id="inpt01" class="transitionCls"
                                                   v-model="GetUser.email"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="frmInputBx">
                                        <span class="icon-Vector-548"></span>
                                        <div class="position-relative">
                                            <label for="inpt03" class="transitionCls"
                                            >نام و نام خانوادگی</label
                                            >
                                            <input type="text" v-model="GetUser.fullName"
                                                   id="inpt03"
                                                   class="transitionCls"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="frmInputBx">
                                        <span class="icon-Vector-682"></span>
                                        <div class="position-relative">
                                            <label for="inpt04" class="transitionCls"
                                            >شماره ثابت</label
                                            >
                                            <input
                                                v-model="GetUser.homeNumber"
                                                type="text"
                                                maxlength="11"
                                                id="inpt04"
                                                class="transitionCls"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="frmInputBx">
                                        <span class="icon-Vector-682"></span>
                                        <div class="position-relative">
                                            <label for="inpt05" class="transitionCls"
                                            >شماره موبایل</label
                                            >
                                            <input
                                                v-model="GetUser.mobile"
                                                type="text"
                                                id="inpt05"
                                                maxlength="11"
                                                class="transitionCls"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 persian-date">
                                    <date-picker class="input-date" v-model="GetUser.birthDate"
                                                 color="#262930"></date-picker>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="frmInputBx mt-3">
                                        <span class="icon-Vector-5411"></span>
                                        <div class="position-relative">
                                            <label for="inpt07" class="transitionCls"
                                            >نام کاربری</label
                                            >
                                            <input type="text" v-model="GetUser.username " id="inpt07"
                                                   class="transitionCls"/>
                                        </div>
                                    </div>
                                    <div class="frmInputBx mt-3">
                                        <span class="icon-Vector-2321"></span>
                                        <div class="position-relative">
                                            <label for="inpt08" class="transitionCls">کد ملی</label>
                                            <input type="text" maxlength="10" v-model="GetUser.nationalCode" id="inpt08"
                                                   class="transitionCls"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="typeCmntBx mt-3">
                                        <div class="typeCmntLbl">
                                            <span class="icon-Vector-326"></span>
                                            <label for="text01">آدرس خود را وارد کنید</label>
                                        </div>
                                        <textarea
                                            v-model="GetUser.address"
                                            class="form-control"
                                            id="text01"
                                            rows="2"
                                            placeholder="ادرس شما"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="editMdlLeft">
                            <div class="mdlFrmTxt">
                                برای تغییر کلمه عبور نیاز است که رمز عبور فعلی خود را وارد
                                کنید
                            </div>
                            <div class="frmInputBx mb-4">
                                <span class="icon-Group-2105"></span>
                                <div class="position-relative">
                                    <label for="inpt001" class="transitionCls"
                                    >کلمه عبور فعلی</label>
                                    <input autocomplete="none" type="password" v-model="GetUser.CurrentPassword"
                                           id="inpt001"
                                           class="transitionCls"/>
                                </div>
                            </div>
                            <hr/>
                            <div class="frmInputBx mt-4 mb-3">
                                <span class="icon-Group-2105"></span>
                                <div class="position-relative">
                                    <label for="inpt002" class="transitionCls"
                                    >کلمه عبور جدید</label
                                    >
                                    <input type="password" v-model="GetUser.NewPassword" id="inpt002"
                                           class="transitionCls"/>
                                </div>
                            </div>
                            <div class="frmInputBx mb-3">
                                <span class="icon-Group-2105"></span>
                                <div class="position-relative">
                                    <label for="inpt003" class="transitionCls"
                                    >تکرار کلمه عبور</label
                                    >
                                    <input type="password" v-model="GetUser.Password_Confirmation" id="inpt003"
                                           class="transitionCls"/>
                                </div>
                            </div>
                            <div class="mdlFrmNtif">
                                درصورت تغییر رمز عبور، تا 24 ساعت امکان انجام تراکنش، خرید و
                                فروش را نخواهید داشت
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div
        class="modal fade editUsrMdl"
        id="editUsrMdl2"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="">
                    <div class="modalHedr">
                        <h1>ویرایش اطلاعات کاربری - تایید ویرایش جدید</h1>
                    </div>
                    <div class="mdlConfrmCod">
                        <strong>کد تایید</strong>
                        <p>
                            کد تایید ارسال شما به شماره موبایل یا ایمیل خود را وارد کنید
                        </p>
                    </div>
                    <div class="frmInputBx">
                        <span class="icon-Group-2300"></span>
                        <div class="position-relative">
                            <label for="codeInpt" class="transitionCls"
                            >کد تایید را وارد کنید</label
                            >
                            <input type="text" v-model="UserCode" id="codeInpt" class="transitionCls"/>
                        </div>
                    </div>
                    <div class="mdlNotRecivd">
                        <span>کدی دریافت نکرده اید؟ </span>
                        <button type="button" @click="resendCode" v-if="sec==1">
                            <div class="hidden">{{ SmsValue = null }}</div>
                            ارسال دوباره
                        </button>
                        <vue-countdown :time=" 60 * 1000" v-slot="{minutes, seconds }" v-if="sec!=1&&StartTimer">
                            <div class="hidden">{{ sec = seconds }}</div>
                            {{ seconds }} : 0{{ minutes }}

                        </vue-countdown>
                    </div>
                    <button
                        @click="EditChecked"
                        type="button"
                        class="btn mdlSaveBtn"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        ثبت و تغییر ایمیل
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
