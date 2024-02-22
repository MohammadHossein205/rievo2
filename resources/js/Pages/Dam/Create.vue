<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import ModalGlobalGallery from "../modalGalleries/ModalGlobalGallery.vue";
import {showModal, btnShowModal, selectValue, selectIdValue, MultiSelectValue} from '../modalGalleries/Modal';
import {inject, ref} from "vue";
import SvgComponent from "../../components/part/SvgComponent.vue";

const props = defineProps(['groupcompanyData', 'groupData', 'damCode']);
const groupcompanyData = ref([]);
const groupData = ref(props.groupData.data);

const active_haveMilk = ref(false);

const swal = inject('$swal');

const form = ref({
    group_id: -1,
    group_company_id: -1,
    name: '',
    slug: '',
    code: props.damCode,
    image: '',
    price: '',
    weight: '',
    color: '',
    color_english: '',
    ageYear: '',
    ageMonth: '',
    gender: -1,
    haveMilk: false,
    milk_amount: '',
    description: '',
    imageIds: [],
});
const errorList = ref([]);

const storeDam = () => {
    if (MultiSelectValue.value == '') {
        swal.fire({
            title: 'عکس دام خالی می باشد',
            icon: 'error',
            confirmButtonText: 'تایید',
        })
        return;
    }
    if (form.value.group_id == -1) {
        form.value.group_id = '';
    }
    if (form.value.group_company_id == -1) {
        form.value.group_company_id = '';
    }
    if (form.value.gender == -1) {
        form.value.gender = '';
    }
    form.value.imageIds = selectIdValue.value;
    axios.post('/admin/dam', form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'دام با موفقیت درج شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            // ClearData();
            selectValue.value.slice(0, selectValue.value.length)
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}
const ClearData = () => {
    form.value = {
        group_id: -1,
        group_company_id: -1,
        name: '',
        slug: '',
        code: '',
        image: '',
        price: '',
        weight: '',
        color: '',
        ageYear: '',
        ageMonth: '',
        gender: -1,
        haveMilk: false,
        milk_amount: '',
        description: '',
        imageIds: [],
    }
    errorList.value = []
}

const AllowHaveMilk = () => {
    if (form.value.gender == '0') {
        active_haveMilk.value = false;
    } else {
        active_haveMilk.value = true;
    }
}

function RemoveImage(index) {
    selectIdValue.value.splice(index, 1);
    MultiSelectValue.value.splice(index, 1);
}

const ClearImageData = () => {
    MultiSelectValue.value = [];
    selectIdValue.value = [];
}
const GetGroupCompanyData = (name) => {
    groupcompanyData.value = [];
    let _groupCompanyData = props.groupcompanyData.data;
    _groupCompanyData.map((item) => {
        if (item.group_id == name) {
            groupcompanyData.value.push(item);
        }
    })
}
</script>
<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>افزودن دام</h1>
        </div>
        <div class="my-2 flex items-center">
            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg" @click="btnShowModal(true)">افزودن عکس دام
            </button>
            <span class="p-1 text-center hover:cursor-pointer"
                  @click="ClearImageData">
                    <SvgComponent name="delete-icon" size="1.2" color="#262930"></SvgComponent>
            </span>
        </div>
        <div class="bg-white rounded-lg mt-3 p-5">
            <div class="flex flex-wrap gap-0">
                <div v-for="(image,index) in MultiSelectValue" class="grid justify-items-center">
                    <img :src="image" :alt="image"
                         class="w-36 h-36 bg-slate-200 rounded-full m-auto border-2 border-solid border-white">
                    <span class="p-1 text-center hover:cursor-pointer"
                          @click="RemoveImage(index)">
                    <SvgComponent name="delete-icon" size="1.2" color="#262930"></SvgComponent>
                    </span>
                </div>
            </div>
            <div class="mt-10 grid grid-cols-[auto_auto] justify-items-center gap-5 sm:grid-cols-1">
                <div class="w-[100%]">
                    <select name="level" v-model="form.group_id" class="w-full bg-slate-100 rounded-lg">
                        <option value="-1">نوع دسته بندی دام</option>
                        <option v-for="group in groupData" :value="group.id" @click="GetGroupCompanyData(group.name)">
                            {{ group.name }}
                        </option>
                    </select>
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.group_id">
                        {{ errorList.group_id[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <select name="level" v-model="form.group_company_id" class="w-full bg-slate-100 rounded-lg">
                        <option value="-1">نوع نژاد دام</option>
                        <option v-for="groupcompany in groupcompanyData" :value="groupcompany.id">
                            {{ groupcompany.name }}
                        </option>
                    </select>
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.group_company_id">
                        {{ errorList.group_company_id[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="کد دام" v-model="form.code" disabled
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.code">
                        {{ errorList.code[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="نام دام را وارد کنید" v-model="form.name"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.name">
                        {{ errorList.name[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="text" placeholder="پیوند یکتا را وارد کنید" v-model="form.slug"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.slug">
                        {{ errorList.slug[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="قیمت دام را وارد کنید ( تومان )" v-model="form.price"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.price">
                        {{ errorList.price[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="وزن دام را وارد کنید ( کیلوگرم )" v-model="form.weight"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.weight">
                        {{ errorList.weight[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="رنگ دام را وارد کنید" v-model="form.color"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.color">
                        {{ errorList.color[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="رنگ اینگلیسی دام را وارد کنید" v-model="form.color_english"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.color_english">
                        {{ errorList.color_english[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="سن دام ( سال )" v-model="form.ageYear"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.ageYear">
                        {{ errorList.ageYear[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <input type="email" placeholder="سن دام ( ماه )" v-model="form.ageMonth"
                           class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem]">
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.ageMonth">
                        {{ errorList.ageMonth[0] }}
                    </div>
                </div>
                <div class="w-[100%]">
                    <select name="level" v-model="form.gender" class="w-full bg-slate-100 rounded-lg"
                            @change="AllowHaveMilk">
                        <option value="-1">جنسیت دام</option>
                        <option value="1">نر</option>
                        <option value="0">ماده</option>
                    </select>
                    <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.gender">
                        {{ errorList.gender[0] }}
                    </div>
                </div>
                <div class="w-[100%] grid grid-cols-[auto_auto] justify-start items-center gap-5">
                    <div>
                        <input type="checkbox" id="havemilk" v-model="form.haveMilk"
                               class="w-4 h-4 text-blue-600 bg-slate-500 rounded focus:ring-white"
                               :disabled="active_haveMilk"
                               @click="form.haveMilk=!form.haveMilk">
                        <label class="font-medium mr-1 select-none" for="havemilk">شیرده</label>
                    </div>
                    <div>
                        <input type="text" placeholder="حجم شیر ( کیلوگرم )" v-model="form.milk_amount"
                               :disabled="!form.haveMilk"
                               class="w-[100%] h-10 pr-2 rounded-lg border-none bg-slate-100 text-[.85rem] ">
                        <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.milk_amount">
                            {{ errorList.milk_amount[0] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-[100%] mt-10">
                <ckeditor v-model="form.description" class="rounded-lg"></ckeditor>
                <div class="allert text-red-500 pr-1 pt-2" v-if="errorList.description">
                    {{ errorList.description[0] }}
                </div>
            </div>
            <div class="grid grid-rows-2">
                <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click.prevent="storeDam">
                    افزودن
                </button>
                <button class="bg-[#25282f] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                        @click="ClearData">
                    پاک کردن
                </button>
            </div>
        </div>
        <modal-global-gallery v-if="showModal"></modal-global-gallery>
    </div>
</template>
