<script setup>
import {ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";
import VueCountdown from "@chenfengyuan/vue-countdown";

const emit = defineEmits(['issmschange'])
const props = defineProps(['paymnetcondition', 'user'])
const PaymentCondition = ref(props.paymnetcondition)
const user = ref(props.user)





</script>

<template>

</template>

<style scoped>

</style>
