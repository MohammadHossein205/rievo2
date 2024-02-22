<script setup>
import {onMounted, ref} from "vue";
import SvgComponent from "@/components/part/SvgComponent.vue";

const props = defineProps(['body', 'user']);

const show = ref(false);
const modal = ref('modal');
const commentId = ref(0);
const showDetail = () => {
    show.value = true;
}
const close = () => {
    show.value = false;
}

const updateCommentSeen = () => {
    axios.put(`/admin/comment/${user.id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'دامدار با موفقیت ویرایش شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
</script>
<template>
<span class="bg-blue-400 p-[.3rem_.6rem] ml-[.2rem] rounded text-white shadow hover:cursor-pointer"
      @click="showDetail()">
                    <SvgComponent name="view" size="1.5" color="#25282f"
                                  class="hover:scale-125"></SvgComponent>
                </span>
    <div class="fixed top-0 left-0 w-full h-full bg-modal backdrop-blur-lg z-10 flex justify-center items-center"
         v-if="show" @click="close()">
        <div class="bg-white w-[90%] h-[90%] rounded-lg p-1 relative justify-end">
            <div class="text-right p-2">
                <span class="text-sm text-slate-400">نظر داده شده از کاربر : </span>
                <span class="text-sm font-bold">{{ props.user }}</span>
            </div>
            <svg-component name="close" size="1.6" color="black" @click="show=!show"
                           class="absolute top-2 left-1 hover:cursor-pointer"></svg-component>
            <textarea class="w-full h-[93%] resize-none overflow-auto rounded-lg p-2 text-sm border shadow text-justify"
                      disabled
                      v-model="props.body"></textarea>
        </div>
    </div>
</template>
