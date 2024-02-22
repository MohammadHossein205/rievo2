<script setup>

import {onMounted, ref} from "vue";

const props = defineProps(['type', 'id'])
import {GetBlogComment, blogComment, type, id} from "./BlogComment.js"
import BlogCommentLoop from "./BlogCommentLoop.vue";

onMounted(() => {
    type.value = props.type;
    id.value = props.id;
    GetBlogComment(1);
})
</script>

<template>
    <div>
        <ul>
            <blog-comment-loop v-for="blogitem in blogComment"
                               :blogcommentitem="blogitem"></blog-comment-loop>
        </ul>
    </div>
</template>
