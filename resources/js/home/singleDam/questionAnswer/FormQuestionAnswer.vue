<script setup>
import {ref} from "vue";

const props = defineProps(['type', 'id'])
const textComment = ref('');
const userdata = ref(user != null ? user : 0);
import {GetQuestionAnswer} from "./QuestionAnswer.js"
import {toast} from "vue3-toastify";
import axios from "axios";

const errorList = ref([]);
const step = ref(25);
const form = ref({
    user_id: userdata.value.id,
    body: '',
    parent_id: 0,
    questionanswerable_id: props.id,
    questionanswerable_type: props.type,
    status: 0,
});

const storeQuetionAnswer = () => {
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
    axios.post('/admin/questionanswer', form.value).then(res => {
        toast.success("دیدگاه شما با موفقیت ثبت شد , بعد از تایید مدیریت منتشار می شود", {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        });
        form.value.body = '';
        GetQuestionAnswer(1);
    }).catch(error => {
        errorList.value = error.response.data.errors;
    });
}
</script>

<template>
    <form class="xprtFrmHed">
        <div class="xprtFrmHed">
            پرسش شما با نام {{ userdata.fullname }} منتشر خواهد شد
        </div>
        <div class="typeCmntBx">
            <div class="typeCmntLbl">
                <span class="icon-Group-2292"></span>
                <label for="text02">متن پیام خود را وارد کنید</label>
            </div>
            <textarea class="form-control" id="text02" rows="5" v-model="form.body"
                      placeholder="متن پیام شما"></textarea>
            <div class="error" v-if="errorList.body">
                {{ errorList.body[0] }}
            </div>
        </div>

        <button class="transitionCls" @click.prevent="storeQuetionAnswer">ثبت دیدگاه</button>
    </form>
</template>
