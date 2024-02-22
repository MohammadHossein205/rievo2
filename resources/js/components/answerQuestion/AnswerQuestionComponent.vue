<script setup>
import {inject, ref} from "vue";
import SvgComponent from "../part/SvgComponent.vue";

const props = defineProps(['body', 'userfullname', 'userid', 'id', 'parent_id']);
const show = ref(false);
const modal = ref('modal');
const errorList = ref([]);
const swal = inject('$swal');
const form = ref({
    user_id: props.userid,
    body: '',
    parent_id: props.id,
    questionanswerable_id: props.parent_id,
    status: 1,
});

const showDetail = () => {
    show.value = true;
}
const storeAnswer = async (id) => {
    await axios.post(`/admin/questionanswer/answer/${id}`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'پاسخ با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    });
}
document.body.addEventListener('click', function (ev) {
    if (ev.target.className.includes('modalGallery')) {
        show.value = false;
    }
})

</script>
<template>
<span class="bg-blue-400 p-[.3rem_.6rem] ml-[.2rem] rounded text-white shadow hover:cursor-pointer"
      @click="showDetail()">
                    <SvgComponent name="view" size="1.5" color="#25282f"
                                  class="hover:scale-125"></SvgComponent>
                </span>
    <div
        class="modalGallery fixed top-0 left-0 w-full h-full bg-modal backdrop-blur-lg z-10 flex justify-center items-center"
        v-if="show">
        <div class="bg-white w-[90%] h-[90%] rounded-lg p-1 relative justify-end">
            <div class="text-right p-2">
                <span class="text-sm text-slate-400">نظر داده شده از کاربر : </span>
                <span class="text-sm font-bold">{{ props.userfullname }}</span>
            </div>
            <svg-component name="close" size="1.6" color="black" @click="show=!show"
                           class="absolute top-2 left-1 hover:cursor-pointer"></svg-component>
            <textarea
                class="w-full h-[30%] mt-2 resize-none overflow-auto rounded-lg p-2 text-sm border shadow text-justify"
                disabled
                v-model="props.body"></textarea>
            <textarea placeholder="پاسخ به سوال . . ." v-model="form.body"
                      class="w-full mt-2 h-[30%] resize-none overflow-auto rounded-lg p-2 text-sm border shadow text-justify"></textarea>
            <div class="text-red-500 pr-1 pt-2 text-right" v-if="errorList.body">
                {{ errorList.body[0] }}
            </div>
            <div class="text-right">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeAnswer(props.id,index)">
                    افزودن
                </button>
            </div>

        </div>
    </div>
</template>
