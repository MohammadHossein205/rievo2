<script setup>
import {onMounted, ref} from "vue";

const props = defineProps(['allcommentcount']);
const allcommentCount = ref(props.allcommentcount);
const commentCount = ref(0);
const rate1 = ref(0);
const rate2 = ref(0);
const rate3 = ref(0);
const rate4 = ref(0);
const rate5 = ref(0);
const AllCommentCount = async () => {
    await allcommentCount.value.map((item) => {
        commentCount.value += item.rate_count;
    })
}
const GetCommentCountData = async () => {
    await allcommentCount.value.map((item, index) => {
        if (index == 0) {
            rate1.value = item.rate_count;
        } else if (index == 1) {
            rate2.value = item.rate_count;
        } else if (index == 2) {
            rate3.value = item.rate_count;
        } else if (index == 3) {
            rate4.value = item.rate_count;
        } else if (index == 4) {
            rate5.value = item.rate_count;
        }
    })
}
const MakeCommentPercent = (number) => {
    return Math.round(number / commentCount.value * 100);
}
onMounted(() => {
    AllCommentCount();
    GetCommentCountData();
})
</script>

<template>
    <div class="xprtCmntLft" transfer="#targetElOne@767">
        <strong>امتیاز کاربران به تفکیک</strong>
        <ul>
            <li>
                <p>{{ rate5 }}</p>
                <div class="position-relative">
                    <small :style="{width:MakeCommentPercent(rate5)+'%'}" style="background-color: #00d247"></small>
                </div>
                <span>خیلی خوب</span>
            </li>
            <li>
                <p>{{ rate4 }}</p>
                <div class="position-relative">
                    <small :style="{width:MakeCommentPercent(rate4)+'%'}" style="background-color: #0ae977"></small>
                </div>
                <span>خوب</span>
            </li>
            <li>
                <p>{{ rate3 }}</p>
                <div class="position-relative">
                    <small :style="{width:MakeCommentPercent(rate3)+'%'}" style="background-color: #ff7c04"></small>
                </div>
                <span>متوسط</span>
            </li>
            <li>
                <p>{{ rate2 }}</p>
                <div class="position-relative">
                    <small :style="{width:MakeCommentPercent(rate2)+'%'}" style="background-color: #ff3f60"></small>
                </div>
                <span>بد</span>
            </li>
            <li>
                <p>{{ rate1 }}</p>
                <div class="position-relative">
                    <small :style="{width:MakeCommentPercent(rate1)+'%'}" style="background-color: #ea1237"></small>
                </div>
                <span>خیلی بد</span>
            </li>
        </ul>
    </div>
</template>
