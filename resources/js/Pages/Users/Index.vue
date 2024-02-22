<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import ModalDiscount from "@/components/Modaldiscount/ModalDiscount.vue";
import {btnShowModal, showModal} from "@/Pages/modalGalleries/Modal.js";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['userData', 'discountData', 'userIdData']);
const userData = ref(props.userData.data);
const discountData = ref(props.discountData.data);
const userIdData = ref(props.userIdData);

const links = ref(props.userData.meta.links);

const swal = inject('$swal');
const loader = ref(false);
const search = ref('');
const IsSearchActive = ref(false);
const IsDiscountActive = ref(false);
const IsAllUserHaveDiscount = ref(false);

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
    currentPage: props.userData.meta.current_page,
    total: props.userData.meta.total,
    lastPage: props.userData.meta.last_page,
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
    await axios.post(`/admin/get-all-users-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        userData.value = res.data.data;
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
    await axios.post(`/admin/get-all-users-data?page=${page}`, {search: search}).then(res => {
        paginate.value.currentPage = res.data.current_page;
        userData.value = res.data.data;
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
            axios.delete(`/admin/users/${id}`).then(res => {
                if (res.data === 200) {
                    userData.value.splice(index, 1);
                    swal.fire({
                        title: 'دامدار با موفقیت حذف شد',
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
const GetDiscountId = (id) => {
    discountId.value = id;
    discountData.value.map((item) => {
        if (item.id == id.value) {
            discountCode.value = item.discount_code;
        }
    })
}

const GetAllUserId = () => {
    IsAllUserHaveDiscount.value = !IsAllUserHaveDiscount.value;
    if (IsAllUserHaveDiscount.value) {
        userIdData.value.map((item) => {
            userIds.value.push(item.id)
        })
    } else {
        userIds.value = [];
    }
}
const GetUserDiscountId = (id) => {
    id.map((item) => {
        formDelete.value.discountid.push(item.id);
    })
}
const ChangeDiscountActive = () => {
    IsDiscountActive.value = !IsDiscountActive.value;
    if (IsDiscountActive.value == false) {
        userIds.value = [];
        discountId.value = 0;
        discountCode.value = '';
    }
}

const InsertDiscountCode = () => {
    form.value.discountid = discountId.value;
    form.value.userids = userIds.value;
    if (userIds.value.length == 0) {
        swal.fire({
            title: 'هیچ کاربری انتخاب نشده است',
            icon: 'error',
            confirmButtonText: 'تایید',
        })
    } else {
        swal.fire({
            title: 'آیا مطمعن به درج تخفیف هستید؟',
            // text: "امکان برگشت برای این عملیات وجود ندارد!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#25282f',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/admin/add-discount-to-users', form.value).then((res => {
                    if (res.data == 200) {
                        swal.fire({
                            title: 'تخفیف با موفقیت درج شد',
                            icon: 'success',
                            confirmButtonText: 'تایید',
                        })
                        GetData(1);
                    }
                }))
            }
        })
    }
}

const DeleteDiscountCode = () => {
    formDelete.value.userids = userIds.value;
    if (userIds.value.length == 0) {
        swal.fire({
            title: 'هیچ کاربری انتخاب نشده است',
            icon: 'error',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
        })
    } else {
        swal.fire({
            title: 'آیا مطمعن به حذف تخفیف هستید؟',
            // text: "امکان برگشت برای این عملیات وجود ندارد!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#25282f',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/admin/remove-users-discount', formDelete.value).then((res => {
                    if (res.data == 200) {
                        swal.fire({
                            title: 'تخفیف با موفقیت حذف شد',
                            icon: 'success',
                            confirmButtonText: 'تایید',
                            confirmButtonColor: '#2563eb',
                        })
                        GetData(1);
                    }
                }))
            }
        })
    }
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
        <div class="flex items-center justify-between gap-1">
            <div class="flex items-center justify-start gap-1">
                <button class="my-5" @click="ChangeDiscountActive">
                <span v-if="!IsDiscountActive"
                      class="bg-[#2563eb] text-white my-2 px-5 py-2 rounded-lg">تخفیف</span>
                    <span v-else class="bg-red-700 text-white my-2 px-5 py-2 rounded-lg">انصراف تخفیف</span>
                </button>
                <button class="bg-[#2563eb] text-white my-2 px-5 py-2 rounded-lg" v-if="IsDiscountActive"
                        @click="btnShowModal(false)">
                    انتخاب تخفیف
                </button>
                <div v-if="discountId!=0&&IsDiscountActive" class="bg-[#262930] p-2 rounded-lg text-white flex gap-1">
                    <span>کد تخفیف : </span>
                    <span>{{ discountCode }}</span>
                    <div class="rounded-full hover:cursor-pointer" @click="discountId=0">
                        <SvgComponent name="close" size="1.2" color="#B91C1C"></SvgComponent>
                    </div>
                </div>
            </div>
            <div v-if="discountId!=0&&IsDiscountActive">
                <button class="bg-[#2563eb] text-white my-2 px-5 py-2 rounded-lg" v-if="IsDiscountActive"
                        @click="InsertDiscountCode()">
                    تایید نهایی تخفیف
                </button>
            </div>
            <div v-if="IsDiscountActive&&discountId==0">
                <button class="bg-[#2563eb] text-white my-2 px-5 py-2 rounded-lg"
                        @click="DeleteDiscountCode()">
                    حذف تخفیف
                </button>
            </div>
        </div>
        <table class="mt-2 bg-white rounded-lg text-center shadow-xl border-2 border-solid border-slate-100 w-[99.9%]">
            <thead class="font-bold">
            <tr>
                <th v-if="IsDiscountActive">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-slate-500 rounded focus:ring-white"
                           @click="GetAllUserId">
                </th>
                <th v-else>شماره</th>
                <th>نام کاربری</th>
                <th>نام و نام خانوادگی</th>
                <th>تصویر</th>
                <th>ایمیل</th>
                <th>کد ملی</th>
                <th>موبایل</th>
                <th>کد تخفیف</th>
                <th>مقام</th>
                <th>تاریخ عضویت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody v-if="!loader" :class="{'animate-pulse':loader}">
            <tr v-for="(user,index) in userData" class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td v-if="IsDiscountActive">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-slate-500 rounded focus:ring-white"
                           v-model="userIds"
                           :value="user.id"
                           @click="GetUserDiscountId(user.discount_id)">
                </td>
                <td v-else>{{ index += 1 }}</td>
                <td>{{ user.username }}</td>
                <td>{{ user.fullname }}</td>
                <td>
                    <img :src="user.image" :alt="user.image" class="w-16 h-16 rounded-full">
                </td>
                <td>{{ user.email }}</td>
                <td>{{ user.nationalCode }}</td>
                <td>{{ user.mobile }}</td>
                <td>
                    <span class="bg-[#2563eb] text-white rounded-lg px-3 py-1 text-[.6rem]">
                        {{ user.discount_id != '' ? user.discount_id[0].discount_code : 'ندارد' }}
                    </span>
                </td>
                <td>
                    <span v-for="item in user.role" class="grid">
                        <span class="bg-[#25282f] text-white rounded-lg px-3 py-1 mt-1 text-[.6rem]">{{ item }}</span>
                    </span>
                </td>
                <td>{{ user.created_at }}</td>
                <td class="flex justify-center items-center mt-5 gap-1">
                    <Link :href="`${user.id}/edit`" v-if="can('update user')">
                        <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </Link>
                    <span @click="deleteUser(user.id,index)" class="hover:cursor-pointer" v-if="can('delete user')">
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
        <modal-discount :discountdata="props.discountData" :discountId="discountId.value" @getDiscount="GetDiscountId"
                        v-if="showModal"></modal-discount>
    </div>
</template>
