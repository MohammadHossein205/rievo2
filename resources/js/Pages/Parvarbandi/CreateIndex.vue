<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['grouoData']);
const grouoData = ref(props.grouoData.data);
// const links = ref(props.userData.meta.links);
const swal = inject('$swal');
const loader = ref(false);
const search = ref('');
const IsSearchActive = ref(false);

// const paginate = ref({
//     currentPage: props.userData.meta.current_page,
//     total: props.userData.meta.total,
//     lastPage: props.userData.meta.last_page,
// });
// const setpage = async (page) => {
//     if (IsSearchActive) {
//         if (paginate.value.currentPage != page) {
//             await searchData(page, search.value);
//         }
//     } else {
//         if (paginate.value.currentPage != page) {
//             await GetData(page);
//         }
//     }
// }

const GetData = async (page, search) => {
    loader.value = true;
    await axios.post(`/admin/get-all-role-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        grouoData.value = res.data.data;
        loader.value = false;
    });
}
const prev = () => {
    // if (paginate.value.currentPage > 1) {
    //     GetData(paginate.value.currentPage - 1);
    // }
}
const next = () => {
    // if (paginate.value.currentPage < paginate.value.lastPage) {
    //     GetData(paginate.value.currentPage + 1);
    // }
}

const searchData = async (page, search) => {
    loader.value = true;
    IsSearchActive.value = true;
    await axios.post(`/admin/get-all-role-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        grouoData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}

const deleteRole = (id, index) => {
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
            axios.delete(`/admin/role/${id}`).then(res => {
                if (res.data === 200) {
                    grouoData.value.splice(index, 1);
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
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>همه دسته بندی پرواربندی</h1>
        </div>
        <div class="grid justify-center mt-3" v-if="loader">
            <LoaderComponent></LoaderComponent>
        </div>

        <table class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100">
            <thead class="font-bold">
            <tr>
                <th>شماره</th>
                <th>نام دسته بندی</th>
                <th>تاریخ ساخت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(group,index) in grouoData"
                class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td>{{ index + 1 }}</td>
                <td>{{ group.name }}</td>
                <td>{{ group.created_at }}</td>
                <td class="flex justify-center items-center gap-1 p-5">
                    <Link :href="`/admin/parvarbandi/${group.id}`" v-if="can('edit role')">
                        <SvgComponent name="parvarbandi" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </Link>
                </td>
            </tr>
            </tbody>
        </table>
        <!--        <div class="flex my-5 justify-center gap-3">-->
        <!--            <div v-for="link in links.links">-->
        <!--                <p @click="prev" v-if="link.label==='Previous'"-->
        <!--                   class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">-->
        <!--                    قبلی</p>-->
        <!--                <p @click="next" v-else-if="link.label==='Next'"-->
        <!--                   class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">-->
        <!--                    بعدی</p>-->
        <!--                <p @click="setpage(link.label)"-->
        <!--                   class="bg-gray-300 text-gray-600 p-[.2rem_1rem] font-bold rounded-xl hover:cursor-pointer"-->
        <!--                   v-else>{{ link.label }}</p>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</template>
