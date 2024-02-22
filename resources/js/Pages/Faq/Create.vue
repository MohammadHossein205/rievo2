<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from "@inertiajs/vue3";
import {inject, ref} from "vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const swal = inject('$swal');

const form = ref({
    title: '',
    body: '',
});
const errorList = ref([]);

const storeFaq = () => {
    axios.post('/admin/faq', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'سوال با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            form.value = {
                name: '',
                persian_name: '',
            }
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}
const ClearData = () => {
    form.value = {
        title: '',
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
            <h1>افزودن سوال</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-2 grid grid-cols-[auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <textarea type="text" placeholder="عنوان را وارد کنید" v-model="form.title"
                              class="w-[100%] h-32 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.title">
                        {{ errorList.title[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea type="text" placeholder="متن را وارد کنید" v-model="form.body"
                              class="w-[100%] h-32 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.body">
                        {{ errorList.body[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeFaq">
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
