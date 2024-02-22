<script setup>
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import DatePicker from 'vue3-persian-datetime-picker'
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {discountcode} = defineProps(['discountcode'])

const swal = inject('$swal');
const form = ref({
    discount_code: discountcode.discount_code,
    price: discountcode.price,
    count: discountcode.count,
    end_time: discountcode.end_time,
});
const errorList = ref([]);

const updatePermission = () => {
    form.value.discount_code = discountcode.discount_code;
    axios.put(`/admin/discountcode/${discountcode.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'کد تخفیف با موفقیت ویرایش شد',
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
        discount_code: '',
        price: '',
        end_time: '',
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
            <h1>ویرایش تخفیف</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="mt-16 grid grid-cols-1 items-center gap-5">
                <div class="w-[100%]">
                    <input type="text" placeholder="کد تخفیف" v-model="form.discount_code" disabled
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.discountCode">
                        {{ errorList.discountCode[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="مبلغ تخفیف را وارد کنید ( تومان )" v-model="form.price"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.price">
                        {{ errorList.price[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="تعداد استفاده تخفیف را وارد کنید" v-model="form.count"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.count">
                        {{ errorList.count[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <date-picker
                        type="date"
                        compact-time
                        auto-submit
                        color="#262930"
                        v-model="form.end_time"
                    />
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.end_time">
                        {{ errorList.end_time[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updatePermission">
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
