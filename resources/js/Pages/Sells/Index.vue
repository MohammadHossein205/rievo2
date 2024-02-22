<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['selldamData']);
const selldamData = ref(props.selldamData.data);

const links = ref(props.selldamData.meta.links);

const swal = inject('$swal');
const loader = ref(false);
const search = ref('');
const IsSearchActive = ref(false);

const form = ref({
    discountid: 0,
    userids: [],
})
const formDelete = ref({
    discountid: [],
    userids: [],
})
const discountId = ref(0);
const discountCode = ref('');
const userIds = ref([]);

const paginate = ref({
    currentPage: props.selldamData.meta.current_page,
    total: props.selldamData.meta.total,
    lastPage: props.selldamData.meta.last_page,
});
const setpage = async (page) => {
    if (IsSearchActive) {
        if (paginate.value.currentPage != page) {
            await searchData(page, search.value);
        }
    } else {
        if (paginate.value.currentPage != page) {
            await GetData(page);
        }
    }
}
const GetData = async (page, search) => {
    loader.value = true;
    await axios.post(`/admin/get-all-selldam-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        selldamData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}
const prev = () => {
    if (paginate.value.currentPage > 1) {
        GetData(paginate.value.currentPage - 1);
    }
}
const next = () => {
    if (paginate.value.currentPage < paginate.value.lastPage) {
        GetData(paginate.value.currentPage + 1);
    }
}
const searchData = async (page, search) => {
    loader.value = true;
    IsSearchActive.value = true;
    await axios.post(`/admin/get-all-selldam-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        selldamData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}
const deleteUser = (id, index) => {
    swal.fire({
        title: 'آیا مطمعن به حذف هستید؟',
        text: "امکان برگشت برای این عملیات وجود ندارد!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#25282f',
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/admin/selldam/${id}`).then(res => {
                if (res.data === 200) {
                    selldamData.value.splice(index, 1);
                    swal.fire({
                        title: 'درخواست فروش با موفقیت حذف شد',
                        icon: 'success',
                        confirmButtonText: 'تایید',
                    })
                    GetData(1);
                } else if (res.data === 100) {
                    swal.fire({
                        title: 'دامدار فعلی قابل حذف نمی باشد',
                        icon: 'error',
                        confirmButtonText: 'تایید',
                    })
                }
            });
        }
    })
}
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:overflow-scroll sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3 w-full">
            <h1>همه دامداران</h1>
            <input type="text" class="h-7 w-64 text-[.7rem] font-medium rounded-lg shadow text-black"
                   v-model="search"
                   @keyup.enter="searchData(1,search)"
                   placeholder="جستجو پیشرفته . . .">
        </div>
        <div class="grid justify-center mt-3" v-if="loader">
            <LoaderComponent></LoaderComponent>
        </div>
        <table class="mt-2 bg-white rounded-lg text-center shadow-xl border-2 border-solid border-slate-100 w-[99.9%]">
            <thead class="font-bold">
            <tr>
                <th>شماره</th>
                <th>نام کاربر</th>
                <th>نام دام</th>
                <th>وضعیت</th>
                <th>تاریخ ثبت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody v-if="!loader" :class="{'animate-pulse':loader}">
            <tr v-for="(sell,index) in selldamData" class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td>{{ index += 1 }}</td>
                <td>{{ sell.user_id }}</td>
                <td>{{ sell.dam_id }}</td>
                <td>
                    <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                                  v-if="sell.status ==1"></SvgComponent>
                    <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
                </td>
                <td>{{ sell.created_at }}</td>
                <td class="flex justify-center items-center gap-1">
                    <Link :href="`showData/${sell.id}`" v-if="can('update user')">
                        <SvgComponent name="detail" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </Link>
                    <span @click="deleteUser(sell.id,index)" class="hover:cursor-pointer" v-if="can('delete user')">
                        <SvgComponent name="delete-icon" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="flex my-5 justify-center gap-3">
            <div v-for="link in links">
                <p @click="prev" v-if="link.label==='Previous'"
                   class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                    قبلی</p>
                <p @click="next" v-else-if="link.label==='Next'"
                   class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                    بعدی</p>
                <p @click="setpage(link.label)"
                   class="bg-gray-300 text-gray-600 p-[.2rem_1rem] font-bold rounded-xl hover:cursor-pointer"
                   v-else>{{ link.label }}</p>
            </div>
        </div>
    </div>
</template>
