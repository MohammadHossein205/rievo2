<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, onMounted, ref} from "vue";
import {btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['paymentconditionData']);
const paymentconditionData = ref(props.paymentconditionData)
const swal = inject('$swal');
const form = ref({
    title_text: paymentconditionData.value == null ? '' : paymentconditionData.value.title_text,
    body_text: paymentconditionData.value == null ? '' : paymentconditionData.value.body_text,
    image: paymentconditionData.value == null ? '' : paymentconditionData.value.image,
});
const errorList = ref([]);

const storeAboutUs = () => {
    form.value.image = selectValue.value;
    axios.post('/admin/paymentcondition', form.value).then(res => {
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
    const form = ref({
        title_text: '',
        body_text: '',
        image: '',
    });
    errorList.value = []
}
onMounted(() => {
    selectValue.value = form.value.image;
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
            <h1>اطلاعات تماس با ما</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <input type="text" placeholder="متن تایتل را وارد کنید" v-model="form.title_text"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.title_text">
                        {{ errorList.title_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="توضیح بزرگ تایتل را وارد کنید" v-model="form.body_text"
                              class="w-[100%] h-32 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    </textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.body_text">
                        {{ errorList.body_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <img :src="selectValue" alt="عکس درباره ما"
                         class="bg-slate-100 h-32 w-full rounded-lg text-slate-500 pr-2 pt-1 text-[.8rem]"
                         @click="btnShowModal(false)">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.image">
                        {{ errorList.image[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeAboutUs">
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
