import {ref} from "vue";
import axios from "axios";

const questionanswer = ref([])
const type = ref('')
const id = ref(0)
const parent_id = ref(0)

const userdata = ref(user);

const GetQuestionAnswer = async (page) => {
    await axios.post(`/get-questionanswer?page${page}`, {
        questionanswerable_id: id.value,
        questionanswerable_type: type.value,
    }).then(res => {
        questionanswer.value = res.data;
    })
}

export {
    type,
    id,
    parent_id,
    questionanswer,
    GetQuestionAnswer
}

