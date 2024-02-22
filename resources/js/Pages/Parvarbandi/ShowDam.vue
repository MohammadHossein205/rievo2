<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject, onMounted} from "vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['damDatas', 'damvizheDatas']);
const damDatas = ref(props.damDatas.data);
const damvizheDatas = ref(props.damvizheDatas.data);
const isEdit = ref(false);
const swal = inject('$swal');
const group_id = ref(0);
const form = ref({
    user_id: [],
    dam_id: [],
    dam_type: [],
    expire_date: '',
});
const errorList = ref([]);
const storeParvarbandi = async () => {
    setDamId();
    await axios.post(`/admin/parvarbandi`, form.value).then(res => {
        if (res.data === 200) {
            swal.fire({
                title: 'دوره پرواربندی با موفقیت ثبت شد',
                icon: 'success',
                confirmButtonText: 'تایید',
                confirmButtonColor: '#2563eb',
            })
            isEdit.value = false;
            errorList.value = [];
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}
const showParvarbandi = () => {
    isEdit.value = true;
}

const setDamId = () => {
    damDatas.value.map((item) => {
        form.value.dam_id.push(item.id);
        form.value.dam_type.push(item.dam_type);
        form.value.user_id.push(item.user_id_id);
    })
    damvizheDatas.value.map((item) => {
        form.value.dam_id.push(item.id);
        form.value.dam_type.push(item.dam_type);
        form.value.user_id.push(item.user_id_id);
    })
}

onMounted(() => {
    damDatas.value.map((item, index) => {
        if (index == 0) {
            group_id.value = item.group_id;
        }
    })
})

//for close menu
checkScreen();
</script>

<template>
    <Header></Header>
    <Sidebar></Sidebar>
    <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1">
        <div
            class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
            <h1>همه دام ها</h1>
        </div>
        <table class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100">
            <thead class="font-bold">
            <tr>
                <th>شماره</th>
                <th>نام دسته بندی</th>
                <th>نام کاربر</th>
                <th>نام دام</th>
                <th>دارای زمان پرواربندی</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(dam,index) in damDatas"
                class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td>{{ index + 1 }}</td>
                <td>{{ dam.group_id }}</td>
                <td>{{ dam.user_id }}</td>
                <td>{{ dam.name }}</td>
                <td>
                    <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                                  v-if="dam.hasParvarbandi==1"></SvgComponent>
                    <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
                </td>
            </tr>
            <tr v-for="(damvizhe,index) in damvizheDatas"
                class="even:bg-slate-100 hover:bg-slate-200 transition-all">
                <td>{{ index + 1 }}</td>
                <td>{{ damvizhe.group_id }}</td>
                <td>{{ damvizhe.user_id }}</td>
                <td>{{ damvizhe.name }}</td>
                <td>
                    <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                                  v-if="damvizhe.hasParvarbandi==1"></SvgComponent>
                    <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="mt-2 flex justify-between items-center bg-white p-2 rounded-lg shadow-lg">
            <strong class="text-sm">افزودن زمان پرواربندی</strong>
            <span @click="showParvarbandi" v-if="can('delete role')"
                  class="hover:cursor-pointer">
                        <SvgComponent name="edit-icon" size="1.8" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </span>
        </div>
        <div class="mt-2 p-2 bg-white rounded-lg shadow-lg" v-if="isEdit">
            <div>
                <strong class="text-[1rem]">نام دسته بندی : </strong>
                <span class="font-bold">{{ group_id }}</span>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-5">
                <div class="w-[100%]">
                    <date-picker
                        type="date"
                        compact-time
                        auto-submit
                        color="#262930"
                        v-model="form.expire_date"
                    />
                    <div class="text-red-500 pr-1 pt-2" v-if="errorList.expire_date">
                        {{ errorList.expire_date[0] }}
                    </div>
                </div>
            </div>
            <button class="bg-[#3661ec] p-3 text-white rounded-lg w-36 mt-5 hover:text-red-500 transition-all"
                    @click.prevent="storeParvarbandi">
                افزودن
            </button>
        </div>
    </div>
</template>
