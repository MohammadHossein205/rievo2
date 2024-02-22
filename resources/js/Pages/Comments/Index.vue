<script setup>
import Header from "../../Pages/part/header.vue";
import Sidebar from "../../Pages/part/sidebar.vue";
import {Link} from '@inertiajs/vue3'
import SvgComponent from "../../components/part/SvgComponent.vue";
import {ref, inject} from "vue";
import LoaderComponent from "../../components/loader/LoaderComponent.vue";
import DetailComponent from "@/components/detailModal/DetailComponent.vue";
import {checkScreen} from "@/Pages/part/Helperjs.js";

const props = defineProps(['commentData']);
const commentData = ref(props.commentData.data);

const links = ref(props.commentData.meta.links);
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
const paginate = ref({
  currentPage: props.commentData.meta.current_page,
  total: props.commentData.meta.total,
  lastPage: props.commentData.meta.last_page,
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
  await axios.post(`/admin/get-all-comment-data?page=${page}`, {search: search}).then(res => {
    paginate.value.currentPage = res.data.current_page;
    commentData.value = res.data.data;
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
  await axios.post(`/admin/get-all-comment-data?page=${page}`, {search: search}).then(res => {
    paginate.value.currentPage = res.data.current_page;
    commentData.value = res.data.data;
    loader.value = false;
    links.value = res.data.links;
  });
}
const deleteComment = (id, index) => {
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
      axios.delete(`/admin/comment/${id}`).then(res => {
        if (res.data === 200) {
          commentData.value.splice(index, 1);
          swal.fire({
            title: 'کامنت با موفقیت حذف شد',
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
const SeenComment = (id) => {
  axios.put(`/admin/comment/seen/${id}`, formSeen.value).then(res => {
  }).catch(error => {
    errorList.value = error.response.data.errors
  });
}
const insertComment = (id) => {
  swal.fire({
    title: 'آیا مطمعن به انتشار کامنت هستید؟',
    text: "امکان برگشت برای این عملیات وجود ندارد!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#2563eb',
    cancelButtonColor: '#25282f',
    confirmButtonText: 'بله',
    cancelButtonText: 'خیر'
  }).then((result) => {
    if (result.isConfirmed) {
      axios.put(`/admin/comment/status/${id}`, formStatus.value).then(res => {
        if (res.data == 200) {
          swal.fire({
            title: 'کامنت با موفقیت منتشر شد',
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
const sendCommnetBody = (id) => {
  let text = "";
  commentData.value.map((item) => {
    if (item.id == id) {
      text = item.body;
    }
  })
  return text;
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
      <h1>همه کامنت ها</h1>
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
        <th>نام پست</th>
        <th>نوع پست</th>
        <th>پیام کامنت</th>
        <th>امتیاز</th>
        <th>وضعیت</th>
        <th>وضعیت مشاهده</th>
        <th>تاریخ ساخت</th>
        <th>عملیات</th>
      </tr>
      </thead>
      <tbody v-if="!loader" :class="{'animate-pulse':loader}">
      <tr v-for="(comment,index) in commentData" class="even:bg-slate-100 hover:bg-slate-200 transition-all">
        <td>{{ index += 1 }}</td>
        <td>{{ comment.user_id }}</td>
        <td>{{ comment.commentable_id }}</td>
        <td>
          <span v-if="comment.commentable_type=='App\\Models\\Dam'">دام</span>
          <span v-else>ندارد</span>
        </td>
        <td>{{ comment.body.substring(0, 40) }}</td>
        <td>{{ comment.rate }}</td>
        <td>
          <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                        v-if="comment.status==1"></SvgComponent>
          <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
        </td>
        <td>
          <SvgComponent name="check-circle" class="m-auto" size="1.4" color="green"
                        v-if="comment.is_seen==1"></SvgComponent>
          <SvgComponent name="close-circle" class="m-auto" size="1.6" color="red" v-else></SvgComponent>
        </td>
        <td>{{ comment.created_at }}</td>
        <td class="flex justify-center items-center m-5 gap-1">
                    <span class="hover:cursor-pointer" @click="SeenComment(comment.id)" v-if="can('seen comment')">
                        <detail-component :body="sendCommnetBody(comment.id)"
                                          :user="comment.user_id">
                        </detail-component>
                    </span>
          <span class="hover:cursor-pointer" v-if="can('status comment')">
                        <SvgComponent name="check" size="1.5" color="#25282f"
                                      class="hover:scale-125"
                                      @click="insertComment(comment.id)"
                        >
                        </SvgComponent>
                    </span>
          <Link :href="`${comment.id}/edit`" v-if="can('edit comment')">
            <SvgComponent name="edit-icon" size="1.5" color="#25282f"
                          class="hover:scale-125"></SvgComponent>
          </Link>
          <span @click="deleteComment(comment.id,index)" class="hover:cursor-pointer"
                v-if="can('delete comment')">
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
