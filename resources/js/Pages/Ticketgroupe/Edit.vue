<script setup>

import ModalGlobalGallery from "../modalGalleries/ModalGlobalGallery.vue";
import {showModal, btnShowModal, selectValue} from '../modalGalleries/Modal';
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import DatePicker from 'vue3-persian-datetime-picker'
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {comment} = defineProps(['comment'])

const swal = inject('$swal');
const form = ref({
    body: comment.body,
});
const errorList = ref([]);

const ClearData = () => {
    form.value = {
        body: '',
    }
    errorList.value = []
}
const updateComment = () => {
    axios.put(`/admin/comment/${comment.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'کامنت با موفقیت ویرایش شد',
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
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem]">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>ویرایش تیکت</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <textarea type="text" placeholder="متن کامنت را وارد کنید" v-model="form.body"
                              class="w-[100%] h-64 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.body">
                        {{ errorList.body[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updateComment">
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
