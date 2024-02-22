<script setup>
import {ref} from "vue";

const props = defineProps(['type', 'id'])
const textComment = ref('');
const userdata = ref(user != null ? user : 0);
import {GetComments} from "./comments.js"
import {toast} from "vue3-toastify";
import axios from "axios";

const errorList = ref([]);
const step = ref(25);
const form = ref({
    user_id: userdata.value.id,
    body: '',
    commentable_id: props.id,
    commentable_type: props.type,
    rate: 0,
});

const storeComment = () => {
    if (userdata.value == 0) {
        toast.error("برای ثبت دیدگاه وارد سایت شوید", {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        });
        return;
    }
    if (form.value.rate == 0) {
        form.value.rate = 1;
    }
    axios.post('/comments', form.value).then(res => {
        toast.success("دیدگاه شما با موفقیت ثبت شد , بعد از تایید مدیریت منتشار می شود", {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        });
        form.value.body = '';
        GetComments(1);
    }).catch(error => {
        errorList.value = error.response.data.errors;
    });
}
const ChangeRangeNumber = () => {
    if (form.value.rate == 0) {
        form.value.rate = 1;
    } else if (form.value.rate == 25) {
        form.value.rate = 2;
    } else if (form.value.rate == 50) {
        form.value.rate = 3;
    } else if (form.value.rate == 75) {
        form.value.rate = 4;
    } else if (form.value.rate == 100) {
        form.value.rate = 5;
    }
}
</script>

<template>
    <form class="xprtCmntFrm">
        <div class="xprtFrmHed">
            نظر شما با نام {{ userdata.fullname }} منتشر خواهد شد
        </div>
        <div class="typeCmntBx">
            <div class="typeCmntLbl">
                <span class="icon-Group-2292"></span>
                <label for="text01"
                >متن پیام خود را وارد کنید</label
                >
            </div>
            <textarea
                class="form-control"
                id="text01"
                rows="5"
                placeholder="متن پیام شما"
                v-model="form.body"
            ></textarea>

        </div>
        <div class="error" v-if="errorList.body">
            {{ errorList.body[0] }}
        </div>
        <div class="exprtPointBx">
            <div class="exprtPontTtl">ثبت امتیاز</div>
            <div class="costRange position-relative">
                <input
                    type="range"
                    id="slider"
                    min="0"
                    min-value="0"
                    max-value="100"
                    :step="step"
                    v-model="form.rate"
                    @change="ChangeRangeNumber"
                />
                <div class="scale"></div>
            </div>
        </div>
        <button class="transitionCls" @click.prevent="storeComment">ثبت دیدگاه</button>
    </form>
</template>
