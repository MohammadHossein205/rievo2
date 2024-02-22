<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {inject, ref} from "vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['userData']);
const userData = ref(props.userData.data);
const swal = inject('$swal');

const form = ref({
    user_id: [],
    body: '',
    is_new: '',
});
const errorList = ref([]);

const storeMessage = () => {
    form.value.user_id = form.value.user_id.length == 0 ? '' : form.value.user_id;
    axios.post('/admin/message', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'پیام با موفقیت درج شد',
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
        user_id: -1,
        body: '',
        is_new: '',
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
            <h1>افزودن پیام</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-5 grid grid-cols-1 items-center gap-5">
                <div class="w-[100%]">
                    <select name="" multiple v-model="form.user_id"
                            class="w-full bg-slate-100 h-64 rounded-lg no-scrollbar">
                        <option value="-1" disabled>نام کاربر را انتخاب کنید</option>
                        <option v-for="user in userData" :value="user.id">{{ user.fullname }}</option>
                    </select>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.user_id">
                        {{ errorList.user_id[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <textarea placeholder="متن پیام را وارد کنید"
                              class="w-[100%] h-32 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]"
                              v-model="form.body"></textarea>
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.body">
                        {{ errorList.body[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeMessage">
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
