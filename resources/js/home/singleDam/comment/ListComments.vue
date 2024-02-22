<script setup>

import {onMounted, ref} from "vue";

const props = defineProps(['type', 'id'])
import {GetComments, comments, type, id} from "./comments"
import CommentLoop from "./CommentLoop.vue";

onMounted(() => {
    type.value = props.type;
    id.value = props.id;
    GetComments(1);
})

</script>

<template>
    <div>
        <ul>
            <comment-loop v-for="comment in comments" :comment="comment"></comment-loop>
        </ul>
    </div>
</template>
