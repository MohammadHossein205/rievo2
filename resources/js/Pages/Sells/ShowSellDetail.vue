<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, ref} from "vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {sellData} = defineProps(['sellData']);
const swal = inject('$swal');

const form = ref({
    user_id: sellData.data.user_id,
    dam_id: sellData.data.dam_id,
});
const formsell = ref({
    sell_id: sellData.data.id,
    price: '',
    dam_type: sellData.data.dam_type,
    user_id: sellData.data.user_name_id,
    dam_id: sellData.data.dam_name_id,
})
const errorList = ref([]);

const storeSell = () => {
    axios.post('/admin/selldam', formsell.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'درخواست پرداخت با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            ClearData();
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
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
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>جزئیات درخواست</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-2 grid grid-cols-[auto_auto] justify-items-center gap-5 sm:grid-cols-1">
                <div class="w-[100%]">
                    <label for="" class="mr-1 font-bold">نام کاربر</label>
                    <input type="text" disabled placeholder="نام کاربر را وارد کنید" v-model="form.user_id"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <!--                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.username">-->
                    <!--                        {{ errorList.username[0] }}-->
                    <!--                    </div>-->
                </div>
                <div class="w-[100%]">
                    <label for="" class="mr-1 font-bold">نام دام</label>
                    <input type="text" disabled placeholder="نام دام را وارد کنید" v-model="form.dam_id"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <!--                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.fullname">-->
                    <!--                        {{ errorList.fullname[0] }}-->
                    <!--                    </div>-->
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="مبلغ دام را وارد کنید" v-model="formsell.price"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.price">
                        {{ errorList.price[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeSell">
                    افزودن
                </button>
                <button class="bg-[#25282f] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click="ClearData">
                    پاک کردن
                </button>
            </div>
        </div>
    </div>
</template>
