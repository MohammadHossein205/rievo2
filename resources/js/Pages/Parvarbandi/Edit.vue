<script setup>
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {parvarbandiData} = defineProps(['parvarbandiData'])
const swal = inject('$swal');
const form = ref({
    expire_date: parvarbandiData.data.expire_date_shamsi,
});
const errorList = ref([]);

const updateParvarbandi = () => {
    axios.put(`/admin/parvarbandi/${parvarbandiData.data.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'زمان انقضائ با موفقیت ویرایش شد',
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
        name: '',
        permissionIDs: []
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
            <h1>ویرایش زمان پرواربندی</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto_auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <date-picker
                        type="date"
                        compact-time
                        auto-submit
                        color="#262930"
                        v-model="form.expire_date"
                    />
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.expire_date">
                        {{ errorList.expire_date[0] }}
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updateParvarbandi">
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
