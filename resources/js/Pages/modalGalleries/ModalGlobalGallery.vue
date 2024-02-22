<script setup>
import {closeModal, showModal} from './Modal';
import addGalleries from '../modalGalleries/tab/addGalleries.vue'
import listGalleries from '../modalGalleries/tab/listGalleries.vue'

import {ref} from "vue";

const currentTab = ref(listGalleries)
const isActive = ref('list')
const changeTab = (componentName, type) => {
    currentTab.value = componentName;
    isActive.value = type;
}
</script>


<template>
    <div
        class="modalGallery fixed left-0 top-0 z-10 w-screen h-screen bg-[rgba(5,5,5,.6)] backdrop-blur-lg grid justify-center items-center hover:cursor-default sm:block"
        @click="closeModal">
        <div class="bg-white w-[90rem] h-[40rem] p-4 rounded-lg sm:w-[90%] sm:h-full sm:m-auto">
            <div class=" bg-slate-100 shadow-lg rounded-lg grid p-4">
                <nav class="flex justify-center gap-5 items-center">
                    <span
                        class="bg-[#262930] text-white px-5 py-1 rounded-lg transition-all duration-300 hover:cursor-pointer"
                        :class="{'shadow-[0_0_.5rem_blue]' : isActive=='list'}"
                        @click="changeTab(listGalleries,'list')">نمایش تصاویر</span>
                    <span
                        class="bg-[#262930] text-white px-5 py-1 rounded-lg transition-all duration-300 hover:cursor-pointer"
                        :class="{'shadow-[0_0_.5rem_blue]' : isActive=='upload'}"
                        @click="changeTab(addGalleries,'upload')">آپلود رسانه</span>
                </nav>

            </div>
            <div class="bg-slate-100 rounded-lg sm:h-[80%] sm:overflow-scroll">
                <component :is="currentTab"></component>
                <!--                    <keep-alive>-->

                <!--                    </keep-alive>-->
            </div>
        </div>
    </div>
</template>

