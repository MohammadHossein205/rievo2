<script setup>
import LoaderComponent from "@/components/loader/LoaderComponent.vue";
import Header from "@/Pages/part/header.vue";
import Sidebar from "@/Pages/part/sidebar.vue";
import {inject, ref} from "vue";
import axios from "axios";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['ticketData']);
const ticketData = ref(props.ticketData.data)
// console.log(props.ticketData.data)
const form = ref({
    'ticketgroupe_id': '',
    'user_id': 1,
    'body': '',
})
const swal = inject('$swal');

const GetData = async (id) => {
    await axios.get(`/admin/ticketgroupe/showData/${id}`).then(res => {
        ticketData.value = res.data.data;
    });
}
const getTicketGroupeId = async () => {
    await props.ticketData.data.map((item) => {
        form.value.ticketgroupe_id = item.ticketgroupe_id;
    })
}
const SendTicket = async () => {
    if (form.value.body == '') {
        swal.fire({
            title: 'متن تیکت نباید خالی باشد',
            icon: 'warning',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
        })
    } else {
        await getTicketGroupeId();
        await axios.post('/admin/ticket', form.value).then(res => {
            if (res.data == 200) {
                swal.fire({
                    title: 'تیکت با موفقیت ارسال شد',
                    icon: 'success',
                    confirmButtonText: 'تایید',
                    confirmButtonColor: '#2563eb',
                })
            }
            GetData(form.value.ticketgroupe_id);
            form.value.body = '';
        }).catch(error => {
            swal.fire({
                title: 'تیکت با موفقیت ارسال نشد',
                icon: 'warning',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
        });
    }
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
            <h1>نمایش تیکت</h1>
        </div>
        <div class="h-full bg-white rounded-lg mt-2 p-2 overflow-scroll no-scrollbar mb-[8rem]">
            <div v-for="ticketdata in ticketData"
                 :class="ticketdata.user_id!=1?'grid grid-cols-[auto] justify-end mt-4':'mt-4'">
                <div class="flex items-center gap-2" v-if="ticketdata.user_id==1">
                    <img
                        :src="ticketdata.image"
                        alt="" class="bg-slate-500 rounded-full w-16 h-16 shadow-lg">
                    <strong class="text-sm">ادمین دامداری ریوو</strong>
                </div>
                <div class="flex items-center justify-end gap-2" v-else>
                    <strong class="text-sm">{{ ticketdata.user_name }}</strong>
                    <img
                        :src="ticketdata.image"
                        alt="" class="bg-slate-500 rounded-full w-16 h-16 shadow-lg">
                </div>
                <div
                    class="border-2 shadow-lg border-[#1b1c1e] border-solid w-[30rem] rounded-lg p-2 text-justify mt-2 sm:w-full">
                    {{ ticketdata.body }}
                </div>
                <div class="flex justify-between items-center w-[30rem] mt-1 sm:w-full">
                    <strong class="text-slate-600">{{ ticketdata.created_time }}</strong>
                    <strong class="text-slate-600">{{ ticketdata.created_at }}</strong>
                </div>
            </div>
            <div class="fixed bottom-0 w-[82%] bg-white rounded-lg p-1 flex items-center gap-2 sm:flex-col sm:w-full">
                <textarea type="text" class="bg-slate-300 w-[90%] h-24 mb-2 text-[.8rem] rounded-lg"
                          v-model="form.body"></textarea>
                <button class="bg-[#2563eb] w-32 h-12 rounded-lg text-white" @click="SendTicket()">ارسال پیام</button>
            </div>
        </div>
    </div>
</template>
