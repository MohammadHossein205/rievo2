<script setup>
import {ref} from "vue";
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";
import {GetComments} from "./comments";

const props = defineProps(['comment'])
const comment = ref(props.comment);

const page = ref(1)
const InfiniteShow = ref(true)
const loadComment = async () => {
    page.value++;

}
</script>

<template>
    <li v-for="itemcomment in comment">
        <div class="xprtCmntLiHed">
            <div class="xprtCmntLiUsr">
                <img :src="itemcomment.image" alt="img">
                <div>
                    <p>{{ itemcomment.user_id }}</p>
                    <span>{{ itemcomment.created_at }}</span>
                </div>
            </div>
            <strong class="orange" v-if="itemcomment.rate==1">
                {{ itemcomment.rate }}
                <span>خیلی بد</span>
            </strong>
            <strong class="orange" v-else-if="itemcomment.rate==2">
                {{ itemcomment.rate }}
                <span>بد</span>
            </strong>
            <strong class="orange" v-else-if="itemcomment.rate==3">
                {{ itemcomment.rate }}
                <span>متوسط</span>
            </strong>
            <strong class="green" v-else-if="itemcomment.rate==4">
                {{ itemcomment.rate }}
                <span>خوب</span>
            </strong>
            <strong class="green" v-else-if="itemcomment.rate==5">
                {{ itemcomment.rate }}
                <span>خیلی خوب</span>
            </strong>
        </div>
        <div class="xprtCmntLiTxt">
            {{ itemcomment.body }}
        </div>
    </li>
<!--    <a href="#" class="exprtCmntMor transitionCls">-->

<!--    </a>-->
</template>


