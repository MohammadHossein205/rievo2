<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, onMounted, ref} from "vue";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";
import {Baner1, Baner2, BanerValue, btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['authimageData']);
const authimageData = ref(props.authimageData)
const swal = inject('$swal');
const form = ref({
    login_image: authimageData.value == null ? '' : authimageData.value.login_image,
    register_image: authimageData.value == null ? '' : authimageData.value.register_image,
});
const errorList = ref([]);

const storeSetting = () => {
    form.value.login_image = Baner1.value;
    form.value.register_image = Baner2.value;
    axios.post('/admin/authimage', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'عکس ورود عضویت با موفقیت درج شد',
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
    const form = ref({
        login_image: '',
        register_image: '',
    });
    errorList.value = []
}
onMounted(() => {
    Baner1.value = authimageData.value.login_image;
    Baner2.value = authimageData.value.register_image;
})

//for close menu
checkScreen();
</script>
<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>اطلاعات عکس ورود عضویت</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto] justify-items-center gap-5">
                <div class="w-[100%] pr-2">
                    عکس صفحه ورود
                </div>
                <div class="w-[100%]">
                    <img :src="Baner1" alt="بنر اول"
                         class="bg-slate-100 h-32 w-full rounded-lg text-slate-500 pr-2 pt-1 text-[.8rem]"
                         @click="BanerValue(1)">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.baner_one_image">
                        {{ errorList.baner_one_image[0] }}
                    </div>
                </div>
                <div class="w-[100%] pr-2">
                    عکس صفحه عضویت
                </div>
                <div class="w-[100%]">
                    <img :src="Baner2" alt="بنر دوم"
                         class="bg-slate-100 h-32 w-full rounded-lg text-slate-500 pr-2 pt-1 text-[.8rem]"
                         @click="BanerValue(2)">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.baner_two_image">
                        {{ errorList.baner_two_image[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeSetting">
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
