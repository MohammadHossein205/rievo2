<script setup>
import {inject, ref} from "vue";
import {toast} from "vue3-toastify";
import axios from "axios";
import SvgComponent from "@/components/part/SvgComponent.vue";

const userdata = ref(user);
const {id, type, like} = defineProps(['id', 'type', 'like'])
const islike = ref(like);
const LikeEventHandler = () => {
    if (userdata.value != null) {
        axios.post('/like', {likeable_id: id, likeable_type: type,}).then(res => {
            islike.value = res.data.like;
        })
    } else {
        toast.error('ابتدا باید وارد سایت شوید', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    }
}
</script>

<template>
    <button class="transitionCls" @click="LikeEventHandler">
        <span class="icon-Group-2271" v-if="!islike"></span>
        <svg-component name="full-heart" size="1.5" v-if="islike"></svg-component>
    </button>
</template>
