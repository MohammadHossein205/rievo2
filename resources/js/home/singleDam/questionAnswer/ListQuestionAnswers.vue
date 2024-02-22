<script setup>

import {onMounted, ref} from "vue";

const props = defineProps(['type', 'id'])
import {GetQuestionAnswer, questionanswer, type, id} from "./QuestionAnswer.js"
import QuestionAnswerLoop from "./QuestionAnswerLoop.vue";

onMounted(() => {
    type.value = props.type;
    id.value = props.id;
    GetQuestionAnswer(1);
})

</script>

<template>
    <div>
        <ul>
            <question-answer-loop v-for="questionansweritem in questionanswer"
                                  :questionansweritem="questionansweritem"></question-answer-loop>
        </ul>
    </div>
</template>
