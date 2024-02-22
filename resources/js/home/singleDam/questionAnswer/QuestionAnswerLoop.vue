<script setup>
import {onMounted, ref} from "vue";

const props = defineProps(['questionansweritem'])
const questionansweritem = ref(props.questionansweritem);


onMounted(() => {

})

</script>

<template>
    <div v-for="questionanswer in questionansweritem">
        <li v-if="questionanswer.parent_id!=questionanswer.id-1">
            <div class="xprtCmntLiHed">
                <div class="xprtCmntLiUsr">
                    <img :src="questionanswer.image" alt="img">
                    <div>
                        <p>{{ questionanswer.user_id }}</p>
                        <span>{{ questionanswer.created_at }}</span>
                    </div>
                </div>
            </div>
            <div class="xprtCmntLiTxt">
                {{ questionanswer.body }}
            </div>
        </li>
        <li class="xprtQsReply" v-else>
            <div class="xprtCmntLiHed">
                <div class="xprtCmntLiUsr">
                    <img :src="questionanswer.image" alt="img">
                    <div>
                        <p>{{ questionanswer.user_id }}</p>
                        <span>{{ questionanswer.created_at }}</span>
                    </div>
                </div>
                <i>ریوو</i>
            </div>
            <div class="xprtCmntLiTxt">
                {{ questionanswer.body }}
            </div>
        </li>
    </div>
</template>


