<script setup>
import {ref, inject, onMounted} from "vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import Header from "../../Pages/part/header.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const {role, rolePermission, permissionData} = defineProps(['role', 'rolePermission', 'permissionData'])
const swal = inject('$swal');
const form = ref({
    name: role.name,
    permissionIDs: []
});

const allPermissionActive = ref(false);
const errorList = ref([]);

const updateUser = () => {
    axios.put(`/admin/role/${role.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'مقام با موفقیت ویرایش شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
const ClearData = () => {
    form.value = {
        name: '',
        permissionIDs: []
    }
    errorList.value = []
}
const CheckAllPermission = () => {
    allPermissionActive.value = !allPermissionActive.value;
    if (allPermissionActive.value) {
        permissionData.map((item) => {
            form.value.permissionIDs.push(item.id)
        })
    } else {
        form.value.permissionIDs = [];
    }
}
onMounted(() => {
    rolePermission.permissions.map((item) => {
        form.value.permissionIDs.push(item.id);
    })
})
//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>ویرایش مقام</h1>
        </div>
        <div class="bg-white rounded-lg mt-1 p-5">
            <div class="grid grid-cols-[auto_auto] justify-items-center gap-5">
                <div class="w-[100%]">
                    <input type="text" placeholder="نام مقام را وارد کنید" v-model="form.name"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.name">
                        {{ errorList.name[0] }}
                    </div>
                </div>
                <div class="w-[100%] flex gap-1 items-center justify-end">
                    <input type="checkbox"
                           class="w-4 h-4 text-blue-600 bg-slate-500 rounded focus:ring-white" id="checkedAll"
                           @change="CheckAllPermission">
                    <label for="checkedAll">علامت همه</label>
                </div>
            </div>

            <div class="mt-5 bg-slate-100 p-2 rounded-lg">
                <strong class="text-sm">دسترسی ها</strong>
                <div class="grid grid-cols-minmaxfill items-center justify-start">
                    <div v-for="permission in permissionData" :key="permission.id" class="my-2">
                        <input type="checkbox"
                               class="w-4 h-4 text-blue-600 bg-slate-500 rounded focus:ring-white"
                               :value="permission.id"
                               v-model="form.permissionIDs"
                               :id="permission.persian_name">
                        <label :for="permission.persian_name" class="font-medium mr-1">{{
                                permission.persian_name
                            }}</label>
                    </div>
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="updateUser">
                    ویرایش
                </button>
                <button class="bg-[#25282f] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click="ClearData">
                    پاک کردن
                </button>
            </div>
        </div>
    </div>
</template>
