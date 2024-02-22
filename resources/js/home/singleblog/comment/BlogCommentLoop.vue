<script setup>
import {onMounted, ref} from "vue";

const props = defineProps(['blogcommentitem'])
const blogcommentitem = ref(props.blogcommentitem);


onMounted(() => {

})

</script>

<template>
<!--    <div v-for="blogComment in blogcommentitem">-->
<!--        <li v-if="questionanswer.parent_id!=questionanswer.id-1">-->
<!--            <div class="xprtCmntLiHed">-->
<!--                <div class="xprtCmntLiUsr">-->
<!--                    <img :src="questionanswer.image" alt="img">-->
<!--                    <div>-->
<!--                        <p>{{ blogComment.user_id }}</p>-->
<!--                        <span>{{ blogComment.created_at }}</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="xprtCmntLiTxt">-->
<!--                {{ blogComment.body }}-->
<!--            </div>-->
<!--        </li>-->
        <li v-for="blogComment in blogcommentitem">
            <div class="blgCmntUsr">
                <img :src="blogComment.image" alt="img"/>
                <div>
                    <strong>{{blogComment.user_id}}</strong>
                    <p>{{blogComment.created_at}}</p>
                </div>
            </div>
            <div class="blgCmntTxt">
               {{blogComment.body}}
            </div>
        </li>
<!--    </div>-->
</template>


