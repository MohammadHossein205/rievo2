<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['bankCardData']);
const bankCardData = ref(props.bankCardData.data);

const links = ref(props.bankCardData.meta.links);
const swal = inject('$swal');
const loader = ref(false);
const search = ref('');
const IsSearchActive = ref(false);

const showDetail = ref(false);
const formSeen = ref({
  is_seen: 1,
});
const formStatus = ref({
  status: 1,
});
const formshaba = ref({
  cardnumber: '',
})
const paginate = ref({
  currentPage: props.bankCardData.meta.current_page,
  total: props.bankCardData.meta.total,
  lastPage: props.bankCardData.meta.last_page,
});
const setpage = async (page) => {
  if (IsSearchActive) {
    if (paginate.value.currentPage != page) {
      await searchData(page, search.value);
    }
  } else {
    if (paginate.value.currentPage != page) {
      await GetData(page);
    }
  }
}
const GetData = async (page, search) => {
  loader.value = true;
  await axios.post(`/admin/get-all-bankcard-data?page=${page}`, {search: search}).then(res => {
    paginate.value.currentPage = res.data.current_page;
    bankCardData.value = res.data.data;
    loader.value = false;
    links.value = res.data.links;
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
const searchData = async (page, search) => {
  loader.value = true;
  IsSearchActive.value = true;
  await axios.post(`/admin/get-all-bankcard-data?page=${page}`, {search: search}).then(res => {
    paginate.value.currentPage = res.data.current_page;
    bankCardData.value = res.data.data;
    loader.value = false;
    links.value = res.data.links;
  });
}
const deleteBankCard = (id, index) => {
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
      axios.delete(`/admin/bankcard/${id}`).then(res => {
        if (res.data === 200) {
          bankCardData.value.splice(index, 1);
          swal.fire({
            title: 'کارت بانکی با موفقیت حذف شد',
            icon: 'success',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
          })
          GetData(1);
        }
      });
    }
  })
}
const IsAccepted = (id) => {
  swal.fire({
    title: 'آیا شماره کارت مورد تایید می باشد؟',
    text: "امکان برگشت برای این عملیات وجود ندارد!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#25282f',
    confirmButtonText: 'بله',
    cancelButtonText: 'خیر'
  }).then((result) => {
    if (result.isConfirmed) {
      axios.put(`/admin/bankcard/status/${id}`, formStatus.value).then(res => {
        if (res.data == 200) {
          swal.fire({
            title: 'شماره کارت با موفقیت تایید شد',
            icon: 'success',
            confirmButtonText: 'تایید',
            confirmButtonColor: '#2563eb',
          })
        }
      }).catch(error => {
        errorList.value = error.response.data.errors
      });
    }
  })

}
const checkFile = async (cardnumber) => {
  formshaba.value.cardnumber = cardnumber;
  await axios.post(`/admin/bankcard/get-user-information-shaba`, formshaba.value).then(res => {
    if (res.data.result == 1) {
      let messageText = 'نام صاحب کارت : ' + res.data.data.name;
      swal.fire({
        title: messageText,
        icon: 'success',
        confirmButtonText: 'تایید',
        confirmButtonColor: '#2563eb',
      })
    } else {
      swal.fire({
        title: `${res.data.message}`,
        icon: 'error',
        confirmButtonText: 'تایید',
        confirmButtonColor: '#2563eb',
      })
    }
  });
}

//for close menu
checkScreen();
</script>

<template>
  <Header></Header>
  <Sidebar></Sidebar>
  <div class="bg-[#f8f8f8] w-full h-screen pr-[16rem] pt-[6rem] pl-[.5rem] sm:pr-1 sm:overflow-scroll">
    <div
        class="bg-[#262930] text-white rounded-lg py-5 px-2 text-sm font-bold shadow flex justify-between mt-3">
      <h1>همه کارت بانکی ها</h1>
      <input type="text" class="h-7 w-64 text-[.7rem] font-medium rounded-lg shadow text-black"
             v-model="search"
             @keyup.enter="searchData(1,search)"
             placeholder="جستجو پیشرفته . . .">
    </div>
    <div class="grid justify-center mt-3" v-if="loader">
      <LoaderComponent></LoaderComponent>
    </div>
    <table class="mt-2 bg-white w-full rounded-lg text-center shadow-xl border-2 border-solid border-slate-100">
      <thead class="font-bold">
      <tr>
        <th>شماره</th>
        <th>نام کاربری</th>
        <th>نام بانک</th>
        <th>عکس</th>
        <th>شماره کارت</th>
        <th>شماره شبا</th>
        <th>وضعیت</th>
        <th>تاریخ ساخت</th>
        <th>عملیات</th>
      </tr>
      </thead>
      <tbody v-if="!loader" :class="{'animate-pulse':loader}">
      <tr v-for="(bankcard,index) in bankCardData" class="even:bg-slate-100 hover:bg-slate-200 transition-all">
        <td>{{ index += 1 }}</td>
        <td>{{ bankcard.user_id }}</td>
        <td>{{ bankcard.bankname }}</td>
        <td>
          <img :src="bankcard.image" :alt="bankcard.bankname" class="rounded-full w-16 h-16">
        </td>
        <td>{{ bankcard.cardnumber }}</td>
        <td>{{ bankcard.shabanumber }}</td>
        <td class="p-5">
          <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                        v-if="bankcard.status==1"></SvgComponent>
          <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
        </td>
        <td>{{ bankcard.created_at }}</td>
        <td class="flex justify-center items-center m-5 gap-1">
                    <span class="hover:cursor-pointer" v-if="can('status bankcard')">
                        <SvgComponent name="check" size="1.5" color="#25282f"
                                      class="hover:scale-125"
                                      @click="IsAccepted(bankcard.id)"
                        >
                        </SvgComponent>
                    </span>
          <!--                    <Link :href="`${bankcard.id}/edit`" v-if="can('edit comment')">-->
          <!--                        <SvgComponent name="edit-icon" size="1.5" color="#25282f"-->
          <!--                                      class="hover:scale-125"></SvgComponent>-->
          <!--                    </Link>-->
          <span @click="checkFile(bankcard.cardnumber)" class="hover:cursor-pointer"
                v-if="can('delete bankcard')">
                        <SvgComponent name="checkfile" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </span>
          <span @click="deleteBankCard(bankcard.id,index)" class="hover:cursor-pointer"
                v-if="can('delete bankcard')">
                        <SvgComponent name="delete-icon" size="1.5" color="#25282f"
                                      class="hover:scale-125"></SvgComponent>
                    </span>

        </td>
      </tr>
      </tbody>
    </table>
    <div class="flex my-5 justify-center gap-3">
      <div v-for="link in links">
        <p @click="prev" v-if="link.label==='Previous'"
           class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
          قبلی</p>
        <p @click="next" v-else-if="link.label==='Next'"
           class="bg-gray-800 text-white p-[.2rem_1rem] rounded-xl hover:shadow-xl cursor-pointer ">
          بعدی</p>
        <p @click="setpage(link.label)"
           class="bg-gray-300 text-gray-600 p-[.2rem_1rem] font-bold rounded-xl hover:cursor-pointer"
           v-else>{{ link.label }}</p>
      </div>
    </div>
  </div>
</template>
