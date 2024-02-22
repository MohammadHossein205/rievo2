<script setup>
import {useDropzone} from "vue3-dropzone";
import axios from "axios";
import {inject, ref} from "vue";
import SvgComponent from "../../../components/part/SvgComponent.vue";

const showProgress = ref(false);
const percentCompleted = ref(0);
const allFileCount = ref(0);
const iconName = ref('image-xmark');
let filesName = [];

// const swal = inject('$Swal')

const saveFiles = (files) => {
    iconName.value = 'image-xmark';
    const formData = new FormData(); // pass data as a form
    const config = {
        onUploadProgress: function (progressEvent) {
            percentCompleted.value = (progressEvent.loaded / progressEvent.total) * 100;
        }
    }
    allFileCount.value = files.length;
    for (var x = 0; x < files.length; x++) {
        formData.append("image", files[x]);
        filesName.push(files[x].name);
        axios.post('/admin/galleries', formData, config).then(res => {
            //-----
            showProgress.value = true;
            if (percentCompleted.value === 100) {
                iconName.value = 'image-check';
            }
        }).catch((error) => {
            // Swal.fire({
            //     title: 'خطا',
            //     text: "حجم فایل باید کمتر از 2 مگابایت باشد!",
            //     icon: 'error',
            //     confirmButtonColor: '#3085d6',
            //     confirmButtonText: 'تایید',
            // })
        });
    }
};

function onDrop(acceptFiles, rejectReasons) {
    saveFiles(acceptFiles); // saveFiles as callback
}

const {getRootProps, getInputProps, ...rest} = useDropzone({onDrop});

</script>

<template>
    <div class="mt-1 border-slate-200 border-2 rounded p-2 shadow-sm">
        <div
            class="my-5 grid grid-cols-1 grid-rows-[auto_auto] justify-items-center items-center gap-5 hover:cursor-pointer"
            v-bind="getRootProps()">
            <input v-bind="getInputProps()"/>
            <SvgComponent name="upload" size="3" color="#6f6f6f"></SvgComponent>
            <p>در این قسمت فایل های خود را آپلود کنید</p>
        </div>
    </div>
    <div class="p-5 flex justify-center flex-wrap gap-5" v-if="showProgress">
        <div class="flex flex-col gap-2 items-center shadow-xl p-5 rounded border-2 border-dashed"
             :class="{'border-green-400':percentCompleted===100}"
             v-for="(item,index) in allFileCount">
            <SvgComponent :name="iconName" size="3"></SvgComponent>
            <strong>{{ filesName[index] }}</strong>
            <progress :value="percentCompleted" max="100" class="rounded h-1"></progress>
        </div>
    </div>
</template>


