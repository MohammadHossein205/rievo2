<script setup>

import ModalGlobalGallery from "../modalGalleries/ModalGlobalGallery.vue";
import {showModal, btnShowModal, selectValue} from '../modalGalleries/Modal';
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import DatePicker from 'vue3-persian-datetime-picker'
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {user, roleData, userRole} = defineProps(['user', 'roleData', 'userRole'])

const swal = inject('$swal');
const form = ref({
    username: user.username,
    fullname: user.fullname,
    image: user.image,
    nationalCode: user.nationalCode,
    mobile: user.mobile,
    homeNumber: user.homeNumber,
    birthDate: user.birthDate,
    email: user.email,
    password: user.password,
    address: user.address,
    role_id: [],
});
const errorList = ref([]);

const updateUser = () => {
    form.value.image = selectValue.value;
    if (form.value.image === '') {
        swal.fire({
            title: 'عکس دامدار خالی می باشد',
            icon: 'error',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
        })
        return;
    }
    if (form.value.role_id == -1) {
        form.value.role_id = '';
    }
    axios.put(`/admin/users/${user.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'دامدار با موفقیت ویرایش شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const ClearData = () => {
    form.value = {
        username: '',
        fullname: '',
        image: '',
        nationalCode: '',
        mobile: '',
        homeNumber: '',
        birthDate: '',
        email: '',
        address: '',
        password: '',
        role_id: [],
    }
    errorList.value = []
}

onMounted(() => {
    selectValue.value = form.value.image;
    userRole.map((item) => {
        form.value.role_id.push(item);
    })
});

//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>ویرایش دامدار</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="user-img w-48 m-auto relative mt-5">
                <img :src="selectValue" alt=""
                     class="w-36 h-36 bg-slate-200 rounded-full m-auto border-2 border-solid border-white">
                <span class="absolute left-9 bottom-[6.5rem] p-1 text-center hover:cursor-pointer"
                      @click="btnShowModal(false)">
                    <SvgComponent name="edit-icon" size="1.2" color="#262930"></SvgComponent>
                </span>
                <span class="absolute left-9 top-[6.5rem] p-1 text-center hover:cursor-pointer"
                      @click.prevent="selectValue=''">
                    <SvgComponent name="delete-icon" size="1.2" color="#262930"></SvgComponent>
                </span>
            </div>
            <div class="mt-16 grid grid-cols-[auto_auto] justify-items-center gap-5 sm:grid-cols-1">
                <div class="w-[100%]">
                    <input type="text" placeholder="نام کاربری را وارد کنید" v-model="form.username"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.username">
                        {{ errorList.username[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="نام و نام خانوادگی را وارد کنید" v-model="form.fullname"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.fullname">
                        {{ errorList.fullname[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="کد ملی را وارد کنید" v-model="form.nationalCode"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.nationalCode">
                        {{ errorList.nationalCode[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="شماره موبایل را وارد کنید" v-model="form.mobile"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.mobile">
                        {{ errorList.mobile[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="شماره خانه را وارد کنید" v-model="form.homeNumber"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.homeNumber">
                        {{ errorList.homeNumber[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <date-picker v-model="form.birthDate" auto-submit class="w-full" color="#262930"
                                 placeholder="تاریخ تولد"/>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.birthDate">
                        {{ errorList.birthDate[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="ایمیل خود را وارد کنید" v-model="form.email"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.email">
                        {{ errorList.email[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="password" placeholder="رمز خود را وارد کنید" v-model="form.password"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.password">
                        {{ errorList.password[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <select name="level" multiple v-model="form.role_id"
                            class="w-full bg-slate-100 rounded-lg overflow-hidden">
                        <option value="-1" disabled>مقام دامدار</option>
                        <option v-for="role in roleData.data" :value="role.id" :key="role.id">{{ role.name }}</option>
                    </select>
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.role_id">
                        {{ errorList.role_id[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="آدرس را وارد کنید" v-model="form.address"
                              class="w-[100%] h-full pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.address">
                        {{ errorList.address[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updateUser">
                    ویرایش
                </button>
                <button class="bg-[#25282f] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click="ClearData">
                    پاک کردن
                </button>
            </div>
        </div>
        <modal-global-gallery v-if="showModal"></modal-global-gallery>
    </div>
</template>
