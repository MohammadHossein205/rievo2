<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, onMounted, ref} from "vue";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";
import {Baner1, Baner2, BanerValue, btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['indexsettingData']);
const indexsettingData = ref(props.indexsettingData)
const swal = inject('$swal');
const form = ref({
    top_big_text: indexsettingData.value == null ? '' : indexsettingData.value.top_big_text,
    top_small_text: indexsettingData.value == null ? '' : indexsettingData.value.top_small_text,
    top_big_description: indexsettingData.value == null ? '' : indexsettingData.value.top_big_description,
    estelam_text: indexsettingData.value == null ? '' : indexsettingData.value.estelam_text,
    baner_one_image: indexsettingData.value == null ? '' : indexsettingData.value.baner_one_image,
    baner_one_image_link: indexsettingData.value == null ? '' : indexsettingData.value.baner_one_image_link,
    baner_two_image: indexsettingData.value == null ? '' : indexsettingData.value.baner_two_image,
    baner_two_image_link: indexsettingData.value == null ? '' : indexsettingData.value.baner_two_image_link,
    more_information_title: indexsettingData.value == null ? '' : indexsettingData.value.more_information_title,
    more_information_text: indexsettingData.value == null ? '' : indexsettingData.value.more_information_text,
    phone_text: indexsettingData.value == null ? '' : indexsettingData.value.phone_text,
});
const errorList = ref([]);

const storeSetting = () => {
    form.value.baner_one_image = Baner1.value;
    form.value.baner_two_image = Baner2.value;
    axios.post('/admin/indexsetting', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'اطلاعات صفحه اصلی با موفقیت درج شد',
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
        top_big_text: '',
        top_small_text: '',
        top_big_description: '',
        estelam_text: '',
        baner_one_image: '',
        baner_one_image_link: '',
        baner_two_image: '',
        baner_two_image_link: '',
        more_information_title: '',
        more_information_text: '',
        phone_text: '',
    });
    errorList.value = []
}
onMounted(() => {
    Baner1.value = indexsettingData.value.baner_one_image;
    Baner2.value = indexsettingData.value.baner_two_image;
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
            <h1>اطلاعات صفحه اصلی</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <input type="text" placeholder="متن تایتل بالا را وارد کنید" v-model="form.top_big_text"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.top_big_text">
                        {{ errorList.top_big_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="متن زیر تایتل بالا را وارد کنید" v-model="form.top_small_text"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.top_small_text">
                        {{ errorList.top_small_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="توضیح تایتل بالا را وارد کنید" v-model="form.top_big_description"
                              class="w-[100%] h-32 resize-none pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.top_big_description">
                        {{ errorList.top_big_description[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="متن استعلام را وارد کنید" v-model="form.estelam_text"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.estelam_text">
                        {{ errorList.estelam_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <img :src="Baner1" alt="بنر اول"
                         class="bg-slate-100 h-32 w-full rounded-lg text-slate-500 pr-2 pt-1 text-[.8rem]"
                         @click="BanerValue(1)">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.baner_one_image">
                        {{ errorList.baner_one_image[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="لینک بنر اول را وارد کنید" v-model="form.baner_one_image_link"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.baner_one_image_link">
                        {{ errorList.baner_one_image_link[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <img :src="Baner2" alt="بنر دوم"
                         class="bg-slate-100 h-32 w-full rounded-lg text-slate-500 pr-2 pt-1 text-[.8rem]"
                         @click="BanerValue(2)">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.baner_two_image">
                        {{ errorList.baner_two_image[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="لینک بنر دوم را وارد کنید" v-model="form.baner_two_image_link"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.baner_two_image_link">
                        {{ errorList.baner_two_image_link[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="تایتل بیشتر بدانیم را وارد کنید"
                           v-model="form.more_information_title"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.more_information_title">
                        {{ errorList.more_information_title[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="متن بیشتر بدانیم را وارد کنید" v-model="form.more_information_text"
                              class="w-[100%] h-32 resize-none pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.more_information_text">
                        {{ errorList.more_information_text[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="متن شماره تماس را وارد کنید"
                           v-model="form.phone_text"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.phone_text">
                        {{ errorList.phone_text[0] }}
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
