<script setup>
import {inject, ref} from "vue";
import axios from "axios";
import Sidebar from "@/Pages/part/sidebar.vue";
import Header from "@/Pages/part/header.vue";
import {Link} from "@inertiajs/vue3";
import SvgComponent from "@/components/part/SvgComponent.vue";
import LoaderComponent from "@/components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";
import {btnShowModal, selectValue, showModal} from "@/Pages/modalGalleries/Modal.js";
import ModalGlobalGallery from "@/Pages/modalGalleries/ModalGlobalGallery.vue";

const props = defineProps(['groupData'])

const groupData = ref(props.groupData.data)
const links = ref(props.groupData.meta.links)
const loader = ref(false)
const isEdit = ref(false);
const search = ref('')
const IsSearchActive = ref(false);

const form = ref({
    name: '',
    image: '',
})
const updateid = ref('');

const errorList = ref([]);

const paginate = ref({
    currentPage: props.groupData.meta.current_page,
    total: props.groupData.meta.total,
    lastPage: props.groupData.meta.last_page,
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
    await axios.post(`/admin/get-all-group-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        groupData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
}
const destroyGroup = (id, index) => {
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
            axios.delete(`/admin/group/${id}`).then(res => {
                if (res.data === 200) {
                    groupData.value.splice(index, 1);
                    swal.fire({
                        title: 'دسته بندی با موفقیت حذف شد',
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
const storeGroup = () => {
    form.value.image = selectValue.value;
    axios.post('/admin/group', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'دسته بندی شما با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            form.value = {
                name: '',
                image: '',
            }
            selectValue.value = '';
            errorList.value = [];
            GetData(1);
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const updateGroup = () => {
    form.value.image = selectValue.value;
    axios.put(`/admin/group/${updateid.value}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'دسته بندی با موفقیت ویرایش شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
        }
        GetData(1);
        form.value = {
            name: '',
            image: '',
        }
        selectValue.value = '';
        isEdit.value = false;
        updateid.value = '';
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const ShowData = (name, image, id) => {
    form.value.name = name;
    selectValue.value = image;
    updateid.value = id;
    isEdit.value = true;
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
const searchData = async (page, search) => {
    loader.value = true;
    IsSearchActive.value = true;
    await axios.post(`/admin/get-all-group-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        groupData.value = res.data.data;
        loader.value = false;
        links.value = res.data.links;
    });
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
            <h1>همه دسته بندی ها</h1>
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
                        <th>عکس دسته بندی</th>
                        <th>تاریخ ساخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(group,index) in groupData" class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                        <td>{{ index + 1 }}</td>
                        <td>{{ group.name }}</td>
                        <td>
                            <img :src="group.image" alt="" class="w-16 h-16 rounded-full">
                        </td>
                        <td>{{ group.created_at }}</td>
                        <td class="flex justify-center items-center gap-1 p-5">
                            <button class="p-1" @click="ShowData(group.name,group.image,group.id)"
                                    v-if="can('edit group')">
                                <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                                              class="hover:scale-125"></SvgComponent>
                            </button>
                            <span @click="destroyGroup(group.id,index)" class="hover:cursor-pointer"
                                  v-if="can('delete group')">
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
            <div class="mt-2 bg-white h-full rounded p-2">
                <h1 class="text-sm my-2 font-bold" v-if="!isEdit">افزودن دسته بندی</h1>
                <h1 class="text-sm my-2 font-bold" v-else>ویرایش دسته بندی</h1>
                <div class="user-img w-48 m-auto relative mt-5">
                    <img :src="selectValue" alt=""
                         class="w-36 h-36 bg-slate-200 rounded-full m-auto border-2 border-solid border-white">
                    <span class="absolute left-9 bottom-[6.5rem] p-1 text-center hover:cursor-pointer"
                          @click="btnShowModal(false)">
                    <SvgComponent name="edit-icon" size="1.2" color="#262930"></SvgComponent>
                </span>
                    <span class="absolute left-9 top-[6.5rem] p-1 text-center hover:cursor-pointer"
                          @click.prevent="selectValue=''">
                    <SvgComponent name="delete-icon" size="1.2" color="#262930"></SvgComponent>
                </span>
                </div>
                <div class="grid gap-2 mt-5">
                    <div class="w-[100%]">
                        <input type="text" placeholder="نام دسته را وارد کنید" v-model="form.name"
                               class="w-[100%] h-10 pr-2 rounded border-none bg-slate-100 text-[.8rem] focus:shadow transition-all">
                        <div class="text-red-500 pr-1 pt-2" v-if="errorList.name">
                            {{ errorList.name[0] }}
                        </div>
                    </div>
                </div>
                <button class="bg-[#2563eb] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        v-if="!isEdit"
                        @click.prevent="storeGroup">
                    افزودن
                </button>
                <button class="bg-blue-500 p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        v-else
                        @click.prevent="updateGroup()">
                    ویرایش
                </button>
            </div>
        </div>
        <modal-global-gallery v-if="showModal"></modal-global-gallery>
    </div>
</template>
