<script setup>
import {inject, ref} from "vue";
import axios from "axios";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {Link} from "@inertiajs/vue3";
import SvgComponent from "../../components/part/SvgComponent.vue";
import {MultiSelectValue} from "@/Pages/modalGalleries/Modal.js";
import LoaderComponent from "@/components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['groupcompanyData', 'groupData'])

const groupcompanyData = ref(props.groupcompanyData.data)
const groupData = ref(props.groupData.data);
const links = ref(props.groupcompanyData.meta.links)
const loader = ref(false)
const isEdit = ref(false);
const search = ref('')
const IsSearchActive = ref(false);

const form = ref({
    group_id: -1,
    name: '',
    english_name: '',
})
const updateid = ref('');

const errorList = ref([]);

const paginate = ref({
    currentPage: props.groupcompanyData.meta.current_page,
    total: props.groupcompanyData.meta.total,
    lastPage: props.groupcompanyData.meta.last_page,
});

const swal = inject('$swal');
const prev = () => {
    if (paginate.value.currentPage > 1) {
        GetData(paginate.value.currentPage - 1)
    }
}
const next = () => {
    if (paginate.value.currentPage < paginate.value.lastPage) {
        GetData(paginate.value.currentPage + 1)
    }
}
const GetData = async (page, search) => {
    loader.value = true
    await axios.post(`/admin/get-all-groupcompany-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        groupcompanyData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}
const destroyGroupCompany = (id, index) => {
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
            axios.delete(`/admin/groupcompany/${id}`).then(res => {
                if (res.data === 200) {
                    groupcompanyData.value.splice(index, 1);
                    swal.fire({
                        title: 'نژاد دسته بندی با موفقیت حذف شد',
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
const storeGroupCompany = () => {
    if (form.value.group_id === -1) {
        swal.fire({
            title: 'نام دسته را انتخاب کنید',
            icon: 'error',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
        })
        return;
    }
    axios.post('/admin/groupcompany', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'نژاد دسته بندی با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            form.value = {
                group_id: -1,
                name: '',
            }
            errorList.value = [];
            GetData(1);
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const updateGroupCompany = () => {
    axios.put(`/admin/groupcompany/${updateid.value}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'نژاد دسته بندی با موفقیت ویرایش شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
        }
        GetData(1);
        form.value = {
            group_id: -1,
            name: '',
        }
        isEdit.value = false;
        updateid.value = '';
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const ShowData = (name, english_name, id) => {
    form.value.name = name;
    form.value.english_name = english_name;
    form.value.group_id = id;
    updateid.value = id;
    isEdit.value = true;
}

const searchData = async (page, search) => {
    loader.value = true;
    IsSearchActive.value = true;
    await axios.post(`/admin/get-all-groupcompany-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        groupcompanyData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}

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

//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>همه نژاد دسته بندی</h1>
            <input type="text" class="h-7 w-64 text-[.7rem] font-medium rounded-lg shadow text-black"
                   v-model="search"
                   @keyup.enter="searchData(1,search)"
                   placeholder="جستجو پیشرفته . . .">
        </div>
        <div class="mt-3 grid justify-center">
            <LoaderComponent v-if="loader"></LoaderComponent>
        </div>
        <div class="grid grid-cols-[2fr_1fr] gap-2 sm:grid-cols-1">
            <div>
                <table
                    class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100"
                    v-if="!loader">
                    <thead class="font-bold">
                    <tr>
                        <th>شماره</th>
                        <th>نام دسته بندی</th>
                        <th>نام نژاد</th>
                        <th>نام انگیلیسی نژاد</th>
                        <th>تاریخ ساخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(groupcompany,index) in groupcompanyData"
                        class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                        <td>{{ index + 1 }}</td>
                        <td>{{ groupcompany.group_id }}</td>
                        <td>{{ groupcompany.name }}</td>
                        <td>{{ groupcompany.english_name }}</td>
                        <td>{{ groupcompany.created_at }}</td>
                        <td class="flex justify-center items-center gap-1 p-5">
                            <button class="p-1"
                                    @click="ShowData(groupcompany.name,groupcompany.english_name,groupcompany.id)">
                                <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                                              class="hover:scale-125"></SvgComponent>
                            </button>
                            <span @click="destroyGroupCompany(groupcompany.id,index)" class="hover:cursor-pointer">
                                <SvgComponent name="delete-icon" size="1.5" color="#25282f"
                                              class="hover:scale-125"></SvgComponent>
                            </span>
                        </td>
                    </tr>
                    </tbody>

                </table>
                <div class="flex mt-5 justify-center gap-3">
                    <div v-for="link in links">
                        <p @click="prev" v-if="link.label==='Previous'"
                           class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                            قبلی</p>
                        <p @click="next" v-else-if="link.label==='Next'"
                           class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                            بعدی</p>
                        <p @click="setpage(link.label)"
                           class="bg-gray-300 text-gray-600 p-[.2rem_1rem] font-bold rounded-xl hover:cursor-pointer"
                           :class="{'text-black' : link.active}" v-else>{{ link.label }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-2 bg-white h-56 rounded p-2">
                <h1 class="text-sm my-2 font-bold" v-if="!isEdit">افزودن نژاد</h1>
                <h1 class="text-sm my-2 font-bold" v-else>ویرایش نژاد</h1>
                <div class="grid gap-2">
                    <div class="w-[100%]">
                        <select class="w-full bg-slate-100" v-model="form.group_id">
                            <option value="-1">نام دسته را انتخاب کنید</option>
                            <option v-for="group in groupData" :value="group.id">{{
                                    group.name
                                }}
                            </option>
                        </select>
                        <div class="text-red-500 pr-1 pt-2" v-if="errorList.group_id">
                            {{ errorList.group_id[0] }}
                        </div>
                    </div>
                    <div class="w-[100%]">
                        <input type="text" placeholder="نام نژاد را وارد کنید" v-model="form.name"
                               class="w-[100%] h-10 pr-2 rounded border-none bg-slate-100 text-[.8rem] focus:shadow transition-all">
                        <div class="text-red-500 pr-1 pt-2" v-if="errorList.name">
                            {{ errorList.name[0] }}
                        </div>
                    </div>
                    <div class="w-[100%]">
                        <input type="text" placeholder="نام اینگلیسی نژاد را وارد کنید" v-model="form.english_name"
                               class="w-[100%] h-10 pr-2 rounded border-none bg-slate-100 text-[.8rem] focus:shadow transition-all">
                        <div class="text-red-500 pr-1 pt-2" v-if="errorList.name">
                            {{ errorList.name[0] }}
                        </div>
                    </div>
                </div>
                <button class="bg-[#2563eb] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        v-if="!isEdit"
                        @click.prevent="storeGroupCompany">
                    افزودن
                </button>
                <button class="bg-blue-500 p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        v-else
                        @click.prevent="updateGroupCompany()">
                    ویرایش
                </button>
            </div>
        </div>
    </div>
</template>
