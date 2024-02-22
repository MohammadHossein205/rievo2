<script setup>
import {ref, inject} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "../part/Helperjs";
import SvgComponent from "@/components/part/SvgComponent.vue";
import {set} from "@vueuse/core";

const props = defineProps(['userData']);
const userData = ref(props.userData.data);
const swal = inject('$swal');

const form = ref({
    user_id: -1,
    title: '',
    description: '',
    monthly_money: '',
    count: 0,
});
const showDetail = ref(false);
const errorList = ref([]);
const userPaymentData = ref([])
const storeFactor = () => {
    if (form.value.user_id == -1) {
        form.value.user_id = '';
    }
    axios.post('/admin/factor', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'فاکتور با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
        form.value.user_id = -1;
    });
}
const GetUsersDam = async (id) => {
    await axios.post(`/admin/get-user-dam-data`, form.value).then(res => {
        if (res.data.data.length == 0) {
            swal.fire({
                title: 'این کاربر هیچ دامی ندارد',
                icon: 'error',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
        } else {
            userPaymentData.value = res.data;
            showDetail.value = true;
            form.value.count = res.data.data.length;
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const ClearData = () => {
    form.value = {
        user_id: -1,
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
            <h1>افزودن فاکتور</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-5 grid grid-cols-[auto] justify-items-center gap-5 sm:grid-cols-1">
                <div class="w-[100%] flex items-center gap-5">
                    <div class="w-[30%]">
                        <select name="level" v-model="form.user_id" @change="GetUsersDam"
                                class="w-full bg-slate-100 rounded-lg sm:w-[15rem]">
                            <option value="-1">نام دامدار را انتخاب کنید</option>
                            <option v-for="user in userData" :value="user.id">
                                {{ user.fullname == '' ? user.email : user.fullname }}
                            </option>
                        </select>
                        <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.user_id">
                            {{ errorList.user_id[0] }}
                        </div>
                    </div>
                </div>
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
            <div class="bg-slate-100 mt-5 rounded-lg p-2 grid gap-5" v-if="showDetail">
                <div v-for="(item) in userPaymentData.data" class="flex items-center gap-5">
                    <strong>
                        <span>نام دام : </span>
                        <span>{{ item.factortable_id }}</span>
                    </strong>
                </div>
                <div class="flex gap-2 items-center">
                    <label for="">
                        مجموع مبلغ فاکتور را وارد کنید :
                    </label>
                    <input type="text" class="h-8 rounded-lg p-1 text-center w-[20%]" v-model="form.monthly_money">
                </div>
            </div>
            <div class="grid grid-rows-2 mt-5">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeFactor">
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
