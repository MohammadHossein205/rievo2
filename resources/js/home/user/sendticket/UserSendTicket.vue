<script setup>
import {inject, ref} from "vue";
import {toast} from 'vue3-toastify';
import axios from "axios";

const props = defineProps(['setting']);
const setting = ref(props.setting)

const form = ref({
    user_id: user.id,
    title: '',
    body: '',
});

const errorList = ref([]);
const storeTicket = () => {
    axios.post('/user/ticket', form.value).then(res => {
        if (res.data != 200) {
            toast.error("درخواست شما با موفقیت درج نشد", {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            });
        } else {
            toast.success("درخواست شما با موفقیت درج شد", {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            });
            ClearData();
        }
    }).catch(error => {
        errorList.value = error.response.data.errors
    })
}

const ClearData = () => {
    form.value = {
        user_id: 0,
        title: '',
        body: '',
    }
    errorList.value = []
}
</script>

<template>
    <div
        class="modal fade addTicketMdl"
        id="addTicketMdl"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="ticktMdlRght">
                    <h1>ثبت درخواست پشتیبانی</h1>
                    <form>
                        <input type="text" class="form-select mb-3" v-model="form.title" placeholder="موضوع درخواست">
                        <div class="ticket-error" v-if="errorList.title">
                            {{ errorList.title[0] }}
                        </div>
                        <div class="typeCmntBx">
                            <div class="typeCmntLbl">
                                <label for="text01">متن خود را وارد کنید</label>
                            </div>
                            <textarea
                                class="form-control"
                                id="text01"
                                rows="2"
                                placeholder="متن شما"
                                v-model="form.body"
                            >

                            </textarea>
                            <div class="ticket-error" v-if="errorList.body">
                                {{ errorList.body[0] }}
                            </div>
                        </div>

                    </form>
                    <button
                        class="transitionCls"
                        @click="storeTicket"
                        data-bs-target="#addTicketMdl2"
                    >
                        ذخیره و ثبت اطلاعات
                    </button>
                </div>
                <div class="ticktMdlLft">
                    <strong> نکات مهم قبل از ثبت درخواست پشتیبانی</strong>
                    <ul>
                        <li class="position-relative" v-for="item in setting">{{item.text}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div
        class="modal fade addTicketMdl"
        id="addTicketMdl2"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="ticktMdlRght">
                    <h1>ثبت درخواست پشتیبانی</h1>
                    <div class="tiktMdlSuces">
                        <div>
                            <span class="icon-Vector-148"></span>
                        </div>
                        <strong>تیکت شما با موفقیت ثبت شد</strong>
                        <p>تیم پشتیبانی ریوو در کمتر از 24 ساعت پاسخگوی شما خواهند بود</p>
                    </div>
                </div>
                <div class="ticktMdlLft">
                    <strong> نکات مهم قبل از ثبت درخواست پشتیبانی</strong>
                    <ul>
                        <li class="position-relative">عنوان یک</li>
                        <li class="position-relative">نکته شماره دو</li>
                        <li class="position-relative">موضوع شماره 3</li>
                        <li class="position-relative">توضیحات</li>
                        <li class="position-relative">تست 1</li>
                        <li class="position-relative">تست 3</li>
                        <li class="position-relative">تست 4</li>
                        <li class="position-relative">تست 5</li>
                        <li class="position-relative">تست7</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
