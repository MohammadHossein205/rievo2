<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, onMounted, ref} from "vue";
import {btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import SvgComponent from "@/components/part/SvgComponent.vue";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['contactusData']);
const contactusData = ref(props.contactusData)
const swal = inject('$swal');
const form = ref({
    location_image: contactusData.value == null ? '' : contactusData.value.location_image,
    location_link: contactusData.value == null ? '' : contactusData.value.location_link,
    face_to_face: contactusData.value == null ? '' : contactusData.value.face_to_face,
    link_way: contactusData.value == null ? '' : contactusData.value.link_way,
    email: contactusData.value == null ? '' : contactusData.value.email,
    telegram: contactusData.value == null ? '' : contactusData.value.telegram,
    instagram: contactusData.value == null ? '' : contactusData.value.instagram,
    whatsapp: contactusData.value == null ? '' : contactusData.value.whatsapp,
    eitaa: contactusData.value == null ? '' : contactusData.value.eitaa,
    rubika: contactusData.value == null ? '' : contactusData.value.rubika,
});
const errorList = ref([]);

const storeContactus = () => {
    form.value.location_image = selectValue.value;
    axios.post('/admin/contactus', form.value).then(res => {
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
        location_image: '',
        location_link: '',
        face_to_face: '',
        link_way: '',
        email: '',
        telegram: '',
        instagram: '',
        whatsapp: '',
        eitaa: '',
        rubika: '',
    });
    errorList.value = []
}
onMounted(() => {
    selectValue.value = contactusData.value.location_image;
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
                    <div class="user-img relative mb-4">
                        <img :src="selectValue" alt=""
                             class="w-full h-36 rounded border-2 border-white outline-none bg-slate-200">
                        <span class="absolute left-9 bottom-[6.5rem] p-1 text-center hover:cursor-pointer"
                              @click="btnShowModal(false)">
                    <SvgComponent name="edit-icon" size="1.2" color="#262930"></SvgComponent>
                </span>
                        <span class="absolute left-9 top-[6.5rem] p-1 text-center hover:cursor-pointer"
                              @click.prevent="selectValue=''">
                    <SvgComponent name="delete-icon" size="1.2" color="#262930"></SvgComponent>
                </span>
                    </div>
                    <input type="text" placeholder="لینک مکان عکس را وارد کنید" v-model="form.location_image"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.location_image">
                        {{ errorList.location_image[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="آدرس حضوری را وارد کنید" v-model="form.face_to_face"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.face_to_face">
                        {{ errorList.face_to_face[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <label for="" class="text-slate-500 font-bold mr-1">راه های ارتباطی</label>
                    <ckeditor v-model="form.link_way" class="rounded-lg mt-2"></ckeditor>
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.link_way">
                        {{ errorList.link_way[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="ایمیل را وارد کنید" v-model="form.email"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.email">
                        {{ errorList.email[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="آیدی تلگرام را وارد کنید" v-model="form.telegram"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.telegram">
                        {{ errorList.telegram[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="آیدی اینستاگرام را وارد کنید" v-model="form.instagram"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.instagram">
                        {{ errorList.instagram[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="آیدی واتساپ را وارد کنید" v-model="form.whatsapp"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.whatsapp">
                        {{ errorList.whatsapp[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="آیدی ایتا را وارد کنید" v-model="form.eitaa"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.eitaa">
                        {{ errorList.eitaa[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="آیدی روبیکا را وارد کنید" v-model="form.rubika"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.rubika">
                        {{ errorList.rubika[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeContactus">
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
