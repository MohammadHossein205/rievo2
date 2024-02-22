<script setup>
import {ref} from "vue";

const props = defineProps(['type', 'id'])
const userdata = ref(user != null ? user : 0);
import {GetBlogComment} from "./BlogComment.js"
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

const storeBlogComment = () => {
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
        GetBlogComment(1);
    }).catch(error => {
        errorList.value = error.response.data.errors;
    });
}
</script>

<template>
    <div class="blgComntHed">
        <div class="blgLstSecTtl">
            <span class="icon-Vector-781"></span>
            <h2>نظرات کاربران</h2>
        </div>
        <p>نظر شما با نام {{ userdata.fullname }} منتشر خواهد شد</p>
    </div>
    <form class="blgComntFrm">
        <div class="typeCmntBx">
            <div class="typeCmntLbl">
                <span class="icon-Group-2292"></span>
                <label for="text01">متن پیام خود را وارد کنید</label>
            </div>
            <textarea
                class="form-control"
                id="text01"
                rows="5"
                placeholder="متن پیام شما"
                v-model="form.body"
            ></textarea>
            <div class="error" v-if="errorList.body">
                {{ errorList.body[0] }}
            </div>
        </div>
        <button class="transitionCls" @click.prevent="storeBlogComment">ثبت دیدگاه</button>
    </form>
</template>
