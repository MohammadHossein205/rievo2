<script setup>
import {ref} from "vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import {useDark, useToggle} from "@vueuse/core";
import {ShowHideMenu} from "./Helperjs.js";

const userData = ref(user);
const isDark = useDark();
const toggleDark = useToggle(isDark);

const like_Count = ref(like_count);
const user_Count = ref(user_count);
const view_Count = ref(view_count);
const showhide = ref(false);
const ShowHideProfileSetup = () => {
    showhide.value = !showhide.value;
}
</script>

<template>
    <div class="fixed z-[2] top-0 right-0 w-full h-16 pr-[16rem] p-2 bg-[#f7f7f7] sm:p-0">
        <div class="bg-white rounded-lg p-2 flex justify-between items-center px-5 shadow-lg sm:px-2">
            <div class="flex gap-1 items-center">
                <div class="bg-[#1b1c1e] p-1 rounded-lg hidden sm:w-10 sm:block" @click="ShowHideMenu">
                    <div>
                        <SvgComponent name="menu" size="2" color="#fff"
                                      class="hover:cursor-pointer"></SvgComponent>
                    </div>
                </div>
                <div class="bg-[#1b1c1e] grid justify-items-center w-28 p-1 rounded-lg sm:w-16">
                    <div class="flex items-center gap-2 sm:flex-col">
                        <SvgComponent name="like" size="1.2" color="#fff"
                                      class="hover:cursor-pointer"></SvgComponent>
                        <span class="text-white sm:hidden">تعداد لایک</span>
                    </div>
                    <span class="text-white text-[1rem]">{{ like_Count }}</span>
                </div>
                <div class="bg-[#1b1c1e] grid justify-items-center w-28 p-1 rounded-lg sm:w-16">
                    <div class="flex items-center gap-2 sm:flex-col">
                        <SvgComponent name="users" size="1.2" color="#fff"
                                      class="hover:cursor-pointer"></SvgComponent>
                        <span class="text-white sm:hidden">تعداد دامداران</span>
                    </div>
                    <span class="text-white text-[1rem]">{{ user_Count }}</span>
                </div>
                <div class="bg-[#1b1c1e] grid justify-items-center w-28 p-1 rounded-lg sm:w-16">
                    <div class="flex items-center gap-2 sm:flex-col">
                        <SvgComponent name="view" size="1.2" color="#fff"
                                      class="hover:cursor-pointer"></SvgComponent>
                        <span class="text-white sm:hidden">تعداد بازدید</span>
                    </div>
                    <span class="text-white text-[1rem]">{{ view_Count }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="transition-all">
                    <img :src="userData.image"
                         class="prof-setting rounded w-20 h-20 hover:cursor-pointer" alt=""
                         @click="ShowHideProfileSetup">
                    <div
                        class="transition-all absolute left-2 top-[6.6rem] w-[11rem] bg-white shadow rounded p-2"
                        v-if="showhide">
                        <a :href="`/admin/profile/${userData.fullname}`"
                           class="flex justify-between p-2 hover:cursor-pointer hover:bg-slate-100 hover:shadow-lg rounded-lg transition-all">
                            <strong>ویرایش پروفایل</strong>
                            <SvgComponent name="users" size="1.2" color="#727272"></SvgComponent>
                        </a>
                        <a :href="`/admin/profile/password/${userData.fullname}`"
                           class="flex justify-between p-2 hover:cursor-pointer hover:bg-slate-100 hover:shadow-lg rounded-lg transition-all">
                            <strong>تعییر رمز عبور</strong>
                            <SvgComponent name="change-password" size="1.2" color="#727272"></SvgComponent>
                        </a>
                        <a href="/logout"
                           class="flex justify-between p-2 hover:cursor-pointer hover:bg-slate-100 hover:shadow-lg rounded-lg transition-all">
                            <strong>خروج</strong>
                            <SvgComponent name="admin-exit-icon" size="1.2" color="#fff"></SvgComponent>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
