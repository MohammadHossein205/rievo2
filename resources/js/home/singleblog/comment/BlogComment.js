import {ref} from "vue";
import axios from "axios";

const blogComment = ref([])
const type = ref('')
const id = ref(0)
const parent_id = ref(0)

const userdata = ref(user);

const GetBlogComment = async (page) => {
    axios.post(`/get-blog-comments?page${page}`, {commentable_id: id.value, commentable_type: type.value})
        .then(res => {
            blogComment.value = res.data;
        })}

export {
    type,
    id,
    parent_id,
    blogComment,
    GetBlogComment
}

