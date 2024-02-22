import {ref} from "vue";
import axios from "axios";

const comments = ref([])
const type = ref('')
const id = ref(0)

const userdata = ref(user);

const GetComments = async (page) => {
    await axios.post(`/get-comments?page${page}`, {commentable_id: id.value, commentable_type: type.value,})
        .then(res => {
            comments.value = res.data;
        })
}

export {
    type,
    id,
    comments,
    GetComments
}

