<script setup>

import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const swal = inject('$swal');

const old_password = ref('');
const password = ref('');
const password_confirmation = ref('');
const IsChange = ref(false)

const errorList = ref([]);

const changePassword = () => {
    let form = new FormData();
    form.append('old_password', old_password.value);
    form.append('password', password.value);
    form.append('password_confirmation', password_confirmation.value);
    swal.fire({
        title: 'آیا مطمعن به تغییر کلمه عبور هستید؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#25282f',
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('/admin/profile/password', form).then(res => {
                if (res.data === 200) {
                    swal.fire({
                        title: 'کلمه عبور شما با موفقیت ویرایش شد',
                        icon: 'success',
                        confirmButtonText: 'تایید',
                        confirmButtonColor: '#2563eb',
                    })
                } else {
                    swal.fire({
                        title: 'کلمه عبور شما تغییر نکرد',
                        icon: 'warning',
                        confirmButtonText: 'تایید',
                        confirmButtonColor: '#2563eb',
                    })
                }
            }).catch(error => {
                errorList.value = error.response.data.errors
            });
        }
    });
}

//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-2">
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-5 grid justify-items-center gap-5">
                <div class="w-[100%]">
                    <input type="password" placeholder="رمز عبور قدیمی را وارد کنید" v-model="old_password"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.old_password">
                        {{ errorList.old_password[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="password" placeholder="رمز عبور جدید را وارد کنید" v-model="password"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.password">
                        {{ errorList.password[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="password" placeholder="تایید رمز عبور را وارد کنید" v-model="password_confirmation"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.password_confirmation">
                        {{ errorList.password_confirmation[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="changePassword">
                    تغییر رمز عبور
                </button>
            </div>
        </div>
    </div>
</template>
