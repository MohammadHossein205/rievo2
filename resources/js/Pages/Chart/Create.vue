<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, ref} from "vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['groupData']);
const groupData = ref(props.groupData)
const swal = inject('$swal');

const form = ref({
    group_id: -1,
    price: '',
});
const errorList = ref([]);

const storeChartPrice = () => {
    axios.post('/admin/chartprice', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'قیمت دسته با موفقیت درج شد',
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
        group_id: '',
        price: '',
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
            <h1>افزودن قیمت دسته</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-2 grid grid-cols-2 justify-items-center gap-5 sm:grid-cols-1">
                <div class="w-[100%]">
                    <select name="" id="" class="w-full bg-slate-100 rounded-lg" v-model="form.group_id">
                        <option value="-1">دسته بندی را انتخاب کنید</option>
                        <option v-for="group in groupData" :value="group.id">{{ group.name }}</option>
                    </select>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.group_id">
                        {{ errorList.group_id[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="قیمت را وارد کنید" v-model="form.price"
                           class="w-[100%] pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.price">
                        {{ errorList.price[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeChartPrice">
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
