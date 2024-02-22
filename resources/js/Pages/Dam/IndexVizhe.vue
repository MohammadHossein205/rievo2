<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "@/components/loader/LoaderComponent.vue";

const props = defineProps(['damData']);
const damData = ref(props.damData.data);
const links = ref(props.damData.meta.links);
const swal = inject('$swal');
const loader = ref(false);
const search = ref('');
const IsSearchActive = ref(false);

const paginate = ref({
    currentPage: props.damData.meta.current_page,
    total: props.damData.meta.total,
    lastPage: props.damData.meta.last_page,
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
    await axios.post(`/admin/get-all-damvizhe-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        damData.value = res.data.data;
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
    await axios.post(`/admin/get-all-damvizhe-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        damData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}

const deleteMobile = (id, index) => {
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
            axios.delete(`/admin/damvizhe/${id}`).then(res => {
                if (res.data === 200) {
                    damData.value.splice(index, 1);
                    swal.fire({
                        title: 'دام با موفقیت حذف شد',
                        icon: 'success',
                        confirmButtonText: 'تایید',
                        confirmButtonColor: '#2563eb',
                    })
                    GetData(1);
                }
            });
        }
    })
}
</script>
<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1 sm:overflow-scroll">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>همه دام ها</h1>
            <input type="text" class="h-7 w-64 text-[.7rem] font-medium rounded-lg shadow text-black"
                   v-model="search"
                   @keyup.enter="searchData(1,search)"
                   placeholder="جستجو پیشرفته . . .">
        </div>
        <div class="mt-4 flex justify-end items-center">
            <LoaderComponent class="mx-auto" v-if="loader"></LoaderComponent>
            <Link href="create" v-if="can('create dam')"
                  class="bg-blue-600 px-10 py-3 rounded-lg text-white hover:text-slate-900">افزودن
                دام ویژه
            </Link>
        </div>
        <table class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100">
            <thead class="font-bold">
            <tr>
                <th>شماره</th>
                <th>نام دسته</th>
                <th>نژاد دام</th>
                <th>کد دام</th>
                <th>نام</th>
                <th>عکس</th>
                <th>قیمت</th>
                <th>وزن</th>
                <th>رنگ</th>
                <th>جنسیت</th>
                <th>مبلغ تخفیف</th>
                <th>تاریخ پایان تخفیف</th>
                <th>تاریخ ثبت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(dam,index) in damData" class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td>{{ index += 1 }}</td>
                <td>{{ dam.group_id }}</td>
                <td>{{ dam.group_company_id }}</td>
                <td>{{ dam.code }}</td>
                <td>{{ dam.name }}</td>
                <td class="flex">
                    <img v-for="(img) in dam.image.slice(0,3)" :src="img.url" :alt="img.name"
                         class="w-10 h-10 rounded-full">
                </td>
                <td>{{ dam.price }}</td>
                <td>{{ dam.weight }}</td>
                <td>{{ dam.color }}</td>
                <td>{{ dam.gender }}</td>
              <td>{{ dam.disount_price }}</td>
              <td>{{ dam.disount_time }}</td>
                <td>{{ dam.created_at }}</td>
                <td class="flex justify-center items-center gap-1 p-6">
                    <Link :href="`${dam.id}/edit`" v-if="can('edit dam')">
                        <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </Link>
                    <span @click="deleteMobile(dam.id,index)" v-if="can('delete dam')"
                          class="hover:cursor-pointer">
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
