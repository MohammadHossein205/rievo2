<script setup>

import {ref} from "vue";
import {toast} from "vue3-toastify";
import axios from "axios";

const props = defineProps(['articleid']);


const userdata = ref(user != null ? user : 0);
const form = ref({
    user_id: userdata.value.id,
    article_id: props.articleid,
    rate: 0,
});
const errorList = ref([]);
const storeBlogRate = (rateNumber) => {
    if (userdata.value == 0) {
        toast.error("برای ثبت امتیاز ابتدا وارد سایت شوید", {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        });
    }
    form.value.rate = rateNumber;
    axios.post('/blog-rate', form.value).then(res => {
        if (res.data === 200) {
            toast.success("امتیاز شما با موفقیت ثبت شد", {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            });
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}
</script>

<template>
    <div class="rating-stars">
        <p>
            <i>0</i>
            / 5
        </p>
        <ul class="starsLst">
            <li class="star" title="Poor" data-value="1">
                <span class="icon-Group-2273 transitionCls" @click="storeBlogRate(1)"></span>
            </li>
            <li class="star" title="Fair" data-value="2">
                <span class="icon-Group-2273 transitionCls" @click="storeBlogRate(2)"></span>
            </li>
            <li class="star" title="Good" data-value="3">
                <span class="icon-Group-2273 transitionCls" @click="storeBlogRate(3)"></span>
            </li>
            <li class="star" title="Excellent" data-value="4">
                <span class="icon-Group-2273 transitionCls" @click="storeBlogRate(4)"></span>
            </li>
            <li class="star" title="WOW!!!" data-value="5">
                <span class="icon-Group-2273 transitionCls" @click="storeBlogRate(5)"></span>
            </li>
        </ul>
    </div>
</template>
