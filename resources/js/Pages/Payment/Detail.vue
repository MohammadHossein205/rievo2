<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['paymentDetailData']);
const paymentDetailData = ref(props.paymentDetailData.data);

const loader = ref(false);

//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1 sm:overflow-scroll">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>جزئیات خرید</h1>
        </div>
        <div class="grid justify-center mt-3" v-if="loader">
            <LoaderComponent></LoaderComponent>
        </div>

        <table class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100">
            <thead class="font-bold">
            <tr>
                <th>شماره</th>
                <th>شماره فاکتور</th>
                <th>نام محصول</th>
                <th>نوع محصول</th>
                <th>توضیحات</th>
                <th>تعداد</th>
                <th>قیمت اصلی محصول</th>
                <th>تاریخ خرید</th>
            </tr>
            </thead>
            <tbody v-if="!loader" :class="{'animate-pulse':loader}">
            <tr v-for="(paymentdetail,index) in paymentDetailData"
                class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td class="p-6">{{ index + 1 }}</td>
                <td>{{ paymentdetail.payment_id }}</td>
                <td>{{ paymentdetail.paymentable_id }}</td>
                <td>{{ paymentdetail.paymentable_type == 'App\Model\Dam' ? 'ندارد' : 'دام' }}</td>
                <td>{{ paymentdetail.description.substring(0, 100) }}</td>
                <td>{{ paymentdetail.count }}</td>
                <td>{{ paymentdetail.price }} تومان</td>
                <td>{{ paymentdetail.created_at }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
