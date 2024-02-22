<script setup>
import {ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";

const props = defineProps(['damcount'])

const IsSearched = ref(false)

const form = ref({
    text: ''
})
const dam = ref([])
const FindDam = () => {
    if (form.value.text != '')
        axios.post('/search/dam', form.value).then(res => {
            if (res.data.data.length != 0) {
                dam.value = res.data.data
                IsSearched.value = true;
            } else {
                toast.error('دام شما یافت نشد', {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                })
                IsSearched.value = false;
            }
        })
}
</script>

<template>
    <section class="searchSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="searchSecDiv">
                        <h1>دام و محصولات خود را به راحتی پیدا کنید</h1>
                        <p>جستجو در بین {{ props.damcount }} دام و محصولات</p>
                        <div class="searchBox">
                            <button @click="FindDam">
                                <span class="icon-Group-2099"></span>
                            </button>
                            <input
                                type="text"
                                id="input01"
                                class="form-control"
                                v-model="form.text"
                                @keyup.enter="FindDam"
                                placeholder="جستجو در بین دام ها و محصولات"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="resultSec" v-if="IsSearched">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="resltSecHed">
                        <h2>نتایج جستجو شما</h2>
                        <span>{{ dam.length }} دام</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="resltSecBdy">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="resltSecLst">
                            <a :href="`/single/dam/${item.slug}`" class="shopLstCrd transitionCls position-relative"
                               v-for="item in dam">
                                <div class="shopLstImg">
                                    <img :src="item.image[0].url" :alt="item.name" v-if="item.image.length!=0"/>
                                </div>
                                <div class="shpLstInfo">
                                    <h2>{{ item.name }}</h2>
                                    <ul>
                                        <li>
                                            <span>نژاد </span>
                                            <p>{{ item.group_company_id }}</p>
                                        </li>
                                        <li>
                                            <span>سن</span>
                                            <p>{{ item.ageYear }} سال {{ item.ageMonth }} ماه</p>
                                        </li>
                                        <li>
                                            <span>جنسیت</span>
                                            <p>{{ item.gender }}</p>
                                        </li>
                                    </ul>
                                    <div class="lstCrdbtm">
                                        <div class="lstCrdLike">
                                            <span class="icon-Group-2108 transitionCls"></span>
                                            <span class="icon-Group-2271 transitionCls"></span>
                                        </div>
                                        <div class="lstCrdPric">
                                            <p>قیمت</p>
                                            <strong class="position-relative">
                                                <img src="../../../../public/img/toman.png" alt="img"/>
                                                {{ item.price }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
