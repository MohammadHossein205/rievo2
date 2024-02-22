<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";

const props = defineProps(['allarticledata']);
const allarticledata = ref(props.allarticledata.data)

const blogright = ref([])
const blogleft = ref([])

const links = ref(props.allarticledata.links);

const paginate = ref({
    total: props.allarticledata.total,
    per_page: props.allarticledata.per_page,
});
const setpage = async (page) => {
    await GetData(page);
}
const GetData = async (page, search) => {
    await axios.post(`/get-all-blog-data?page=${page}`, {search: search}).then(res => {
        paginate.value.total = res.data.total;
        paginate.value.per_page = res.data.per_page;
        allarticledata.value = res.data.data;
        setDataToArray();
        console.log(paginate.value)
    });
}
const prev = () => {
    if (paginate.value.currentPage > 1) {
        GetData(paginate.value.currentPage - 1);
    }
}
const next = () => {
    if (paginate.value.currentPage < paginate.value.lastPage) {
        GetData(paginate.value.currentPage + 1);
    }
}
const setDataToArray = () => {
    blogright.value = allarticledata.value.slice(0, 4)
    blogleft.value = allarticledata.value.slice(4, 8)
}

onMounted(() => {
    setDataToArray();
})


</script>

<template>
    <div class="blgLstSecTtl">
        <span class="icon-Vector-781"></span>
        <h2>وبلاگ و آموزش</h2>
    </div>
    <div class="blgLstDiv">
        <div class="blgLstRght">
            <a :href="`/blog_post/${right.slug}`" v-for="(right,index) in blogright"
               :class="{blgBigPost:index==0,blgMinPost:index!=0}">

                <div class="blgLstTxt">
                    <img
                        :src="right.image"
                        class="transitionCls"
                        :alt="right.title"
                    />
                    <div>
                        <h2 class="transitionCls">{{ right.title }}</h2>
                        <p v-html="right.body.substring(0,90)+'. . .'"></p>
                    </div>
                </div>
                <ul>
                    <li>
                        <span class="icon-Group-2352"></span>
                        <strong>{{ right.view_count }}</strong>
                        <p>بازدید</p>
                    </li>
                    <li>
                        <span class="icon-Group-2353"></span>
                        <strong>{{ right.rating != null ? right.rating : 0}}</strong>
                        <p>امتیاز</p>
                    </li>
                    <li>
                        <span class="icon-Group-2300"></span>
                        <strong>{{ right.comment_count }}</strong>
                        <p>دیدگاه</p>
                    </li>
                    <li>
                        <span class="icon-Group-2202"></span>
                        <p>{{ right.type }}</p>
                    </li>
                </ul>
            </a>
        </div>
        <div class="blgLstLeft">
            <a :href="`/blog_post/${left.slug}`" v-for="(left,index) in blogleft"
               :class="{blgMinPost:index!=blogleft.length-1,blgBigPost:index==(blogleft.length-1)}">
                <div class="blgLstTxt">
                    <img
                        :src="left.image"
                        class="transitionCls"
                        :alt="left.title"
                    />
                    <div>
                        <h2 class="transitionCls">{{ left.title }}</h2>
                        <p v-html="left.body.substring(0,60)+'. . .'"></p>
                    </div>
                </div>
                <ul>
                    <li>
                        <span class="icon-Group-2352"></span>
                        <strong>{{ left.view_count }}</strong>
                        <p>بازدید</p>
                    </li>
                    <li>
                        <span class="icon-Group-2353"></span>
                        <strong>{{ left.rating != null ? left.rating : 0}}</strong>
                        <p>امتیاز</p>
                    </li>
                    <li>
                        <span class="icon-Group-2300"></span>
                        <strong>{{ left.comment_count }}</strong>
                        <p>دیدگاه</p>
                    </li>
                    <li>
                        <span class="icon-Group-2202"></span>
                        <p>{{ left.type }}</p>
                    </li>
                </ul>
            </a>
        </div>
    </div>
    <div class="paginatnBx">
        <ul>
            <BlogPaginateComponent :paginate="paginate" @sendData="GetData"></BlogPaginateComponent>
        </ul>
    </div>
</template>

<style scoped>

</style>
