<script setup>
import axios from "axios";
import {ref} from "vue";
import {toast} from "vue3-toastify";

const proop = defineProps(['user'])

const Cards = ref()
const form = ref({
    'user_id': proop.user.id
})
axios.post('/admin/bankcard/get_card', form.value).then(res => {
    if (res.data == 100) {
        toast.error('کارت پیدا نشد', {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT
        })
    } else {
        Cards.value = res.data
    }
})

const DeleteCard = (index) => {
    axios.delete(`/admin/bankcard/${Cards.value[index].id}`).then(res => {
        if (res.data == 200) {
            toast.success('کارت شما حذف شد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        } else if (res.data == 200) {
            toast.error('کارت شما حذف نشد', {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            })
        }
    })
}
</script>

<template>
    <li v-for="(card,index) in Cards">
        <div class="xprtChkBnkBx">
            <img :src="card.image" alt="img"/>
            <div>
                <strong>{{ card.bankname }}</strong>
                <p>{{ card.cardnumber }}</p>
            </div>
        </div>
        <button @click="DeleteCard(index)" v-if="card.status==1">حذف این کارت</button>
        <small v-if="card.status==0">در انتظار تایید</small>
    </li>
</template>

<style scoped>

</style>
