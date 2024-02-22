<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, onMounted, ref} from "vue";
import {btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import SvgComponent from "@/components/part/SvgComponent.vue";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['wallettextData']);
const wallettextData = ref(props.wallettextData)
const swal = inject('$swal');
const form = ref({
    title_text: wallettextData.value == null ? '' : wallettextData.value.title_text,
    title_description: wallettextData.value == null ? '' : wallettextData.value.title_description,
    about_wallet: wallettextData.value == null ? '' : wallettextData.value.about_wallet,
});
const errorList = ref([]);

const storeHusbandryText = () => {
    axios.post('/admin/walletext', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'اطلاعات با موفقیت درج شد',
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
    form.value = [];
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
            <h1>اطلاعات متن کیف پول</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <textarea placeholder="عنوان را وارد کنید" v-model="form.title_text"
                              class="w-[100%] h-64 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    </textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.title_text">
                        {{ errorList.title_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="توضیح عنوان را وارد کنید" v-model="form.title_description"
                              class="w-[100%] h-64 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    </textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.title_description">
                        {{ errorList.title_description[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="توضیح عنوان را وارد کنید" v-model="form.about_wallet"
                              class="w-[100%] h-64 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    </textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.about_wallet">
                        {{ errorList.about_wallet[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeHusbandryText">
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
