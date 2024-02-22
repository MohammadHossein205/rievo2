<script setup>
import {ref, inject} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "../part/Helperjs";

const {factor} = defineProps(['factor'])

const swal = inject('$swal');
const form = ref({
    title: factor.title,
    description: factor.description,
});
const errorList = ref([]);

const updateFactor = () => {
    axios.put(`/admin/factorpage/${factor.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'فاکتور با موفقیت ویرایش شد',
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
const ClearData = () => {
    form.value = {
        title: '',
        description: '',
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
            <h1>ویرایش فاکتور</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-16 grid grid-cols-[auto] justify-items-center gap-5 sm:grid-cols-1">
                <div class="w-[100%]">
                    <input type="text" placeholder="عنوان را وارد کنید" v-model="form.title"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.title">
                        {{ errorList.title[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="توضیحات را وارد کنید" v-model="form.description"
                              class="w-[100%] h-full pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.description">
                        {{ errorList.description[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2 mt-5">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updateFactor">
                    ویرایش
                </button>
                <button class="bg-[#25282f] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click="ClearData">
                    پاک کردن
                </button>
            </div>
        </div>
    </div>
</template>
