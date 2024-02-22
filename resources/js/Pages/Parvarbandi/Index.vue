<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";
import forms from "@tailwindcss/forms";

const props = defineProps(['parvarbandiData']);
const parvarbandiData = ref(props.parvarbandiData.data);
const links = ref(props.parvarbandiData.meta.links);
const swal = inject('$swal');
const loader = ref(false);
const search = ref('');
const IsSearchActive = ref(false);

const form = ref({
    parvarbandi_id: 0,
    user_id: 0,
    dam_id: 0,
});
const paginate = ref({
    currentPage: props.parvarbandiData.meta.current_page,
    total: props.parvarbandiData.meta.total,
    lastPage: props.parvarbandiData.meta.last_page,
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
    await axios.post(`/admin/get-all-parvarbandi-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.meta.current_page;
        parvarbandiData.value = res.data.data;
        loader.value = false;
        paginate.value.currentPage = res.data.current_page;
        parvarbandiData.value = res.data.data;
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
    await axios.post(`/admin/get-all-parvarbandi-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.meta.current_page;
        paginate.value.currentPage = res.data.current_page;
        parvarbandiData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}

const deleteParvarbandi = (id, index) => {
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
            axios.delete(`/admin/parvarbandi/${id}`).then(res => {
                if (res.data === 200) {
                    parvarbandiData.value.splice(index, 1);
                    swal.fire({
                        title: 'مقام با موفقیت حذف شد',
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

const deleteDamInsertMohney = (parvarbandi, index) => {
    swal.fire({
        title: 'آیا مطمعن هستید؟',
        text: "امکان برگشت برای این عملیات وجود ندارد! با زدن دکمه تایید دام از دامداری شخص پاک شده و مبلغ به کیف پول آن واریز میگردد",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#25282f',
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر'
    }).then((result) => {
        if (result.isConfirmed) {
            form.value.user_id = parvarbandi.user_id_id;
            form.value.dam_id = parvarbandi.dam_id_id;
            form.value.parvarbandi_id = parvarbandi.id;
            axios.post(`/admin/delete-dam-insert-mohney`, form.value).then(res => {
                if (res.data === 200) {
                    parvarbandiData.value.splice(index, 1);
                    swal.fire({
                        title: 'عملیات با موفقیت انجام شد',
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
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>همه پرواربندی ها</h1>
            <input type="text" class="h-7 w-64 text-[.7rem] font-medium rounded-lg shadow text-black"
                   v-model="search"
                   @keyup.enter="searchData(1,search)"
                   placeholder="جستجو پیشرفته . . .">
        </div>
        <div class="grid justify-center mt-3" v-if="loader">
            <LoaderComponent></LoaderComponent>
        </div>

        <table class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100">
            <thead class="font-bold">
            <tr>
                <th>شماره</th>
                <th>نام کاربر</th>
                <th>نام دام</th>
                <th>تاریخ انقضائ پرواربندی</th>
                <th>وضعیت پرواربندی دام</th>
                <th>تاریخ ساخت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(parvarbandi,index) in parvarbandiData"
                class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td>{{ index + 1 }}</td>
                <td>{{ parvarbandi.user_id }}</td>
                <td>{{ parvarbandi.dam_id }}</td>
                <td>{{ parvarbandi.expire_date }}</td>
                <td>
                    <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                                  v-if="parvarbandi.parvarbandi_Expire == true"></SvgComponent>
                    <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
                </td>
                <td>{{ parvarbandi.created_at }}</td>
                <td class="flex justify-center items-center gap-1 p-5">
                    <span @click="deleteDamInsertMohney(parvarbandi,index)" v-if="can('delete permission')"
                          class="hover:cursor-pointer">
                        <SvgComponent name="checkfile" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </span>
                    <Link :href="`${parvarbandi.id}/edit`" v-if="can('edit role')">
                        <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </Link>
                    <span @click="deleteParvarbandi(parvarbandi.id,index)" v-if="can('delete permission')"
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
