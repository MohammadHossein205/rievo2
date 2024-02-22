<script setup>
import Header from "./part/header.vue";
import Sidebar from "./part/sidebar.vue";
import {checkScreen, showSidebar} from "@/Pages/part/Helperjs.js";

checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16.5rem] pt-[2rem] pl-[6rem] sm:p-0">
        <h1>main</h1>
    </div>
</template>
