<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import {selectValue} from "@/Pages/modalGalleries/Modal.js";
import {checkScreen} from "@/Pages/part/Helperjs.js";
import {log10} from "chart.js/helpers";

const props = defineProps(['factorDetailData']);
const factorDetailData = ref(props.factorDetailData.data);
const loader = ref(false);

const isEdit = ref(false);
const form = ref({
    id: 0,
    monthly_money: '',
})
const factorDamName = ref('');

const swal = inject('$swal');
const errorList = ref([]);
const ShowFactorDetail = (id) => {
    isEdit.value = true;
    factorDetailData.value.map((item) => {
        if (item.id == id) {
            form.value.id = id;
            factorDamName.value = item.factortable_id;
            form.value.monthly_money = item.monthly_money;
        }
    })
}

const storeFactorDetail = () => {
    if (form.value.monthly_money == 0) {
        swal.fire({
            title: 'همه بخش ها را پر کنید',
            icon: 'error',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
        })
        return;
    }
    axios.put(`/admin/factor/${form.value.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'فاکتور با موفقیت ثبت شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            isEdit.value = false;
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}

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
                <th>تعداد</th>
                <th>هزینه ماهیانه</th>
                <th>قیمت اصلی محصول</th>
                <th>تاریخ خرید</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody v-if="!loader" :class="{'animate-pulse':loader}">
            <tr v-for="(factordetail,index) in factorDetailData"
                class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td class="p-6">{{ index + 1 }}</td>
                <td>{{ factordetail.factor_id }}</td>
                <td>{{ factordetail.factortable_id }}</td>
                <td>{{ factordetail.factortable_type == 'App\\Models\\Damvizhe' ? 'دام ویژه' : 'دام' }}</td>
                <td>{{ factordetail.count }}</td>
                <td>{{ factordetail.monthly_money }} تومان</td>
                <td>{{ factordetail.price }} تومان</td>
                <td>{{ factordetail.created_at }}</td>
                <td>
                    <button @click="ShowFactorDetail(factordetail.id)">
                        <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="mt-2 p-2 bg-white rounded-lg" v-if="isEdit">
            <div>
                <strong class="text-[1rem]">نام دام : </strong>
                <span class="font-bold">{{ factorDamName }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-5">
                <div class="w-[100%]">
                    <input type="text" placeholder="هزینه ماهیانه را وارد کنید" v-model="form.monthly_money"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <!--                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.homeNumber">-->
                    <!--                        {{ errorList.homeNumber[0] }}-->
                    <!--                    </div>-->
                </div>
            </div>
            <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                    @click.prevent="storeFactorDetail">
                افزودن
            </button>
        </div>
    </div>

</template>
