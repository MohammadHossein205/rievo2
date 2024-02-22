<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import ModalGlobalGallery from "../modalGalleries/ModalGlobalGallery.vue";
import {showModal, btnShowModal, selectValue} from '../modalGalleries/Modal';
import {inject, ref} from "vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import DatePicker from 'vue3-persian-datetime-picker'
import {checkScreen} from "@/Pages/part/Helperjs.js";


const swal = inject('$swal');

const form = ref({
    text: '',
});
const errorList = ref([]);

const storeQuestionAnswerSetting = () => {
    axios.post('/admin/questionanswersetting', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'متن تنظیمات با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            ClearData();
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}
const ClearData = () => {
    form.value = {
        text: '',
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
            <h1>افزودن متن تنظیمات</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-16 grid grid-cols-1 justify-items-center gap-5">
                <div class="w-[100%]">
                    <input type="text" placeholder="متن تنظیمات را وارد کنید" v-model="form.text"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.text">
                        {{ errorList.text[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeQuestionAnswerSetting">
                    افزودن
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
