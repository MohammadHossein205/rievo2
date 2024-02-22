<script setup>
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {message, userData} = defineProps(['message', 'userData'])

const swal = inject('$swal');

const form = ref({
    user_id: message.user_id,
    body: message.body,
});
const errorList = ref([]);

const updatePermission = () => {

    axios.put(`/admin/message/${message.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'پیام با موفقیت ویرایش شد',
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
        discount_code: '',
        price: '',
        end_time: '',
    }
    errorList.value = []
}
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>ویرایش پیام</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-16 grid grid-cols-1 items-center gap-5">
                <div class="w-[100%]">
                    <select name="" v-model="form.user_id" class="w-full bg-slate-100 rounded-lg overflow-hidden">
                        <option value="-1" disabled>نام کاربر را انتخاب کنید</option>
                        <option v-for="user in userData.data" :value="user.id">{{ user.fullname }}</option>
                    </select>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.user_id">
                        {{ errorList.user_id[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="متن پیام را وارد کنید"
                              class="w-[100%] h-32 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"
                              v-model="form.body"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.body">
                        {{ errorList.body[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updatePermission">
                    ویرایش
                </button>
                <button class="bg-[#25282f] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click="ClearData">
                    پاک کردن
                </button>
            </div>
        </div>
    </div>
</template>
