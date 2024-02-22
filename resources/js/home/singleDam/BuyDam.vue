<script setup>
import {onMounted, ref} from "vue";

import {toast} from 'vue3-toastify';
import axios from "axios";

const dam = defineProps(['dam', 'text', 'type', 'arrow', 'user', 'isvizhe'])

const text = ref(dam.text)
const arrow = ref(dam.arrow)

const damInfo = ref(dam.dam)

const id = ref(damInfo.value.id)
const type = ref(dam.type)
const dams = ref([]);
const damsVizhe = ref([]);
const types = [];
const BuyItem = () => {
    if (dam.user) {
        const form = ref({
            id: id.value,
            type: '',
        })
        if (type.value == 'normal') {
            form.value.type = 'App\\Models\\Dam'
        } else {
            form.value.type = 'App\\Models\\Damvizhe'
        }
        axios.post('/set/cart', form.value).then(res => {
            if (res.data == 0) {
                toast.error("این دام قبلا رزرو شده", {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
            } else if (res.data == 100) {
                toast.error("دام شما ثبت نشد", {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
            } else if (res.data == 200) {
                toast.success("دام شما با موفقیت ثبت شد", {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
            }
        })
    } else {
        toast.error("ابتدا باید وارد سایت شوید", {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        });
    }
}
</script>

<template>
    <a href="#" class="transitionCls" @click.prevent="BuyItem">
        <span class="icon-Group-2108"></span>
        <p v-if="text">اضافه کردن به سبد خرید</p>
        <i class="icon-Group-2210" v-if="arrow"></i>
    </a>
</template>

<style scoped>

</style>
