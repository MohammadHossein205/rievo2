<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import {Link} from '@inertiajs/vue3'
import {useDropzone} from "vue3-dropzone";
import {inject, ref} from "vue";
import LoaderComponent from "@/components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";


const props = defineProps(['galleries']);
const galleries = ref(props.galleries.data);
const links = ref(props.galleries.meta)
const loader = ref(false)

const paginate = ref({
    currentPage: props.galleries.meta.current_page,
    total: props.galleries.meta.total,
    lastPage: props.galleries.meta.last_page,

});
const swal = inject('$swal');
const saveFiles = (files) => {
    const formData = new FormData(); // pass data as a form
    for (var x = 0; x < files.length; x++) {
        formData.append("image", files[x]);
        axios.post('/admin/galleries', formData).then(res => {
            galleries.value.unshift(res.data)
        }).catch((error) => {
            swal.fire({
                title: 'خطا',
                text: "حجم فایل باید کمتر از 2 مگابایت باشد!",
                icon: 'error',
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'تایید',
            })
        });
    }
};

const showSize = (size) => {
    let finalSize = size / 1000;
    if (finalSize > 1000) {
        return (finalSize / 1000).toFixed(2) + ' MB';
    } else {
        return `${finalSize.toFixed(0)} KB`;
    }
}


function onDrop(acceptFiles, rejectReasons) {
    saveFiles(acceptFiles); // saveFiles as callback
    // console.log(rejectReasons);
}

const {getRootProps, getInputProps, ...rest} = useDropzone({onDrop});


const prev = () => {
    if (paginate.value.currentPage > 1) {
        GetData(paginate.value.currentPage - 1)
    }
}

const next = () => {
    if (paginate.value.currentPage < paginate.value.lastPage) {
        GetData(paginate.value.currentPage + 1)
    }
}
const setpage = async (page) => {
    if (paginate.value.currentPage != page)
        await GetData(page);
}
const GetData = async (page) => {
    loader.value = true
    await axios.get(`/admin/galleries-get-data?page=${page}`).then(res => {
        paginate.value.currentPage = res.data.current_page;
        galleries.value = res.data.data
        loader.value = false
        links.value = res.data.links;
    });
}

const destroyGallery = (id, index) => {
    swal.fire({
        title: 'آیا مطمعن به حذف هستید؟',
        text: "امکان برگشت برای این عملیات وجود ندارد!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#25282f',
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/admin/galleries/${id}`).then(res => {
                if (res.data === 200) {
                    galleries.value.splice(index, 1);
                    swal.fire({
                        title: 'تصویر شما با موفقیت حذف شد',
                        icon: 'success',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'تایید',
                    })
                    GetData(1);
                }
            });

        }
    })

}

//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div class="border-slate-200 border-2 rounded p-2 shadow-lg mt-5">
            <div
                class="grid grid-cols-1 grid-rows-[auto_auto] justify-items-center items-center gap-5 hover:cursor-pointer"
                v-bind="getRootProps()">
                <input v-bind="getInputProps()"/>
                <SvgComponent name="upload" size="3" color="#6f6f6f"></SvgComponent>
                <p>در این قسمت فایل های خود را آپلود کنید</p>
            </div>
        </div>
        <div class="text-center my-5">
            <LoaderComponent v-if="loader"></LoaderComponent>
        </div>
        <div class="mt-2 grid grid-cols-minmaxfill gap-2">
            <div class="shadow rounded p-1 grid justify-items-center" v-for="(gallery,index) in galleries">
                <img :src="gallery.url" alt="" class="w-[10rem] h-[10rem] rounded">
                <p class="mt-4">
                    {{ gallery.name.substring(0, 25) }}
                </p>
                <div class="mt-2">
                    <span>حجم فایل :</span>
                    <span>{{ showSize(gallery.size) }}</span>
                </div>
                <p class="mt-2" v-if="can('delete gallery')">
                    <span @click.prevent="destroyGallery(gallery.id,index)" class="hover:cursor-pointer">
                        <SvgComponent name="delete-icon" size="1.5" color="#25282f"></SvgComponent>
                    </span>
                </p>
            </div>
        </div>
        <div class="flex my-5 justify-center gap-3">
            <div v-for="link in links.links">
                <p @click="prev" v-if="link.label==='Previous'"
                   class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                    قبلی</p>
                <p @click="next" v-else-if="link.label==='Next'"
                   class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                    بعدی</p>
                <p @click="setpage(link.label)"
                   class="bg-gray-300 text-gray-600 p-[.2rem_1rem] font-bold rounded-xl hover:cursor-pointer"
                   :class="{'text-black' : link.active}" v-else>{{ link.label }}</p>
            </div>
        </div>
    </div>
</template>
