<script setup>

import ModalGlobalGallery from "../modalGalleries/ModalGlobalGallery.vue";
import {showModal, btnShowModal, selectValue} from '../modalGalleries/Modal';
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {questionanswersetting} = defineProps(['questionanswersetting'])

const swal = inject('$swal');
const form = ref({
    text: questionanswersetting.text,
});
const errorList = ref([]);

const ClearData = () => {
    form.value = {
        text: '',
    }
    errorList.value = []
}
const updateQuestionAnswerSetting = () => {
    axios.put(`/admin/questionanswersetting/${questionanswersetting.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'متن تنظیمات با موفقیت ویرایش شد',
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
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>ویرایش متن تنظیمات</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto] justify-items-center gap-5">
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
                        @click.prevent="updateQuestionAnswerSetting">
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
