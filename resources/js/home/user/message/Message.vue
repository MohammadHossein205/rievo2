<script setup>
import {ref} from "vue";
import axios from "axios";

const props = defineProps(['message'])
const form = ref({
    id: props.message.id
})
axios.post('/user/notification/SetMessageStatus', form.value).then(res => {
    console.log(res.data)
})
</script>

<template>
    <li class="dashNotfCrd">
        <a href="#" class="transitionCls">
            <div class="dashNotfHed">
                <div>
                    <i>{{ props.message.created_time }}</i>
                    <i>{{ props.message.created_at }}</i>
                </div>
                <span v-if="props.message.is_new==1">جدید</span>
                <span v-else-if="props.message.is_new==0"></span>
            </div>
            <p>
                {{ props.message.body }}
            </p>
        </a>
    </li>
</template>

<style scoped>

</style>
