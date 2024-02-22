<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, ref} from "vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";
import {btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import SvgComponent from "@/components/part/SvgComponent.vue";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";

const swal = inject('$swal');

const form = ref({
    namefamily: '',
    image: '',
    body: '',
});
const errorList = ref([]);

const storeFakeComment = () => {
    form.value.image = selectValue.value;
    axios.post('/admin/fakecomment', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'کامنت فیک شما با موفقیت درج شد',
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
        namefamily: '',
        image: '',
        body: '',
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
            <h1>افزودن کامنت فیک</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-1 items-center gap-5">
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
                <div class="w-[100%]">
                    <input type="text" placeholder="نام و نام خانوادگی کاربر را وارد کنید" v-model="form.namefamily"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.namefamily">
                        {{ errorList.namefamily[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="متن کامنت را وارد کنید"
                              class="w-[100%] h-32 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"
                              v-model="form.body"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.body">
                        {{ errorList.body[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeFakeComment">
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
