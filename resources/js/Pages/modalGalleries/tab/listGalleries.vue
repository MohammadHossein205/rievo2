<script setup>
import {onMounted, ref} from "vue";
import {selectValue, selectIdValue, MultiSelect, MultiSelectValue} from "../Modal"

const galleries = ref([])
const links = ref({});
const paginate = ref({
    currentPage: '',
    total: '',
    lastPage: '',
});

const getGalleries = (page) => {
    axios.get(`/admin/galleries-get-data?page=${page}`).then(res => {
        galleries.value = res.data.data
        links.value = res.data.meta;
        paginate.value.currentPage = res.data.meta.current_page;
        paginate.value.total = res.data.meta.total;
        paginate.value.lastPage = res.data.meta.last_page;
    });
}
const prev = () => {
    if (paginate.value.currentPage > 1) {
        getGalleries(paginate.value.currentPage - 1);
    }
}

const next = () => {
    if (paginate.value.currentPage < paginate.value.lastPage) {
        getGalleries(paginate.value.currentPage + 1);
    }
}

const setpage = (page) => {
    if (page != paginate.value.currentPage) {
        getGalleries(page);
    }
}
const selectBtn = (gallery) => {
    if (MultiSelect) {
        MultiSelectValue.value.push(gallery.url);
        selectIdValue.value.push(gallery.id);
    } else {
        selectValue.value = gallery.url;
    }
}
onMounted(() => {
    getGalleries(1);
});
</script>

<template>
    <section class="flex gap-2 flex-wrap mt-2 p-2 ">
        <figure class="rounded-lg transition-all" :class="{'blur-[2px]':selectValue==gallery.url}"
                v-for="gallery in galleries"
                @click="selectBtn(gallery)">
            <img :src="gallery.url" :alt="gallery.name" class="w-48 h-40 rounded-lg">
        </figure>
    </section>
    <div class="mt-2 flex justify-center gap-3">
        <div v-for="link in links.links">
            <p @click="prev" v-if="link.label==='Previous'"
               class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                قبلی</p>
            <p @click="next" v-else-if="link.label==='Next'"
               class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
                بعدی</p>
            <p @click="setpage(link.label)"
               class="bg-gray-300 text-gray-600 p-[.2rem_1rem] font-bold rounded-xl hover:cursor-pointer"
               :class="{'bg-blue-300' : link.active}" v-else>{{ link.label }}</p>
        </div>
    </div>
</template>


