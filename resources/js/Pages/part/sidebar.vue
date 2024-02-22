<script setup>
import SubMenuLinks from "../../components/part/SubMenuLinks.vue";
import SvgComponent from "../../components/part/SvgComponent.vue";
import {Link} from '@inertiajs/vue3'
import {onMounted, ref, watchEffect} from "vue";
import {showSidebar, ShowHideMenu} from "./Helperjs.js"
import {selectValue} from "@/Pages/modalGalleries/Modal.js";

const comment_Count = ref(comment_count);
const ticket_Count = ref(ticket_count);
const bankcard_Count = ref(bankcard_count);
const questionanswer_Count = ref(questionanswer_count);
const factor_Count = ref(factor_count);
const sell_Count = ref(sell_count);
const getmoney_Count = ref(getmoney_count);

const isOnResponsive = ref(false);
const checkScreenSize = () => {
    if (window.screen.width < 500) {
        isOnResponsive.value = true;
    }
}
const CheckUrl = (url) => {
    const urlData = ref(false);
    if (Array.isArray(url)) {
        if (url.includes(window.location.pathname)) {
            urlData.value = true;
        }
    } else {
        watchEffect(() => {
            if (window.location.pathname === url) {
                urlData.value = true;
            }
        })
    }
    return urlData;
}
onMounted(() => {
    checkScreenSize();
    selectValue.value = '';
})
</script>
<template>
    <div
        class="fixed z-[3] top-0 right-0 bg-[#1b1c1e] w-[15rem] h-screen pb-16 p-5 no-scrollbar overflow-scroll sm:w-[12rem]"
        v-if="showSidebar">
        <div class="relative flex justify-center items-center gap-1 text-white">
            <img src="../../../../public/img/logo/header_logo.svg" alt="rivo" width="100" height="100">
            <strong class="absolute left-0 top-0 bg-slate-900 rounded-full w-5 h-5 text-center hover:text-red-500"
                    @click="ShowHideMenu" v-if="isOnResponsive">X</strong>
        </div>
        <div class="mt-6">
            <ul>
                <li class="flex gap-1 items-center" v-if="can('admin index')">
                    <SvgComponent name="dashboard" size="1.2" color="#727272"></SvgComponent>
                    <Link href="/admin/index" :class="{'text-white':$page.url==='/admin/index'}"
                          class="text-[#a4a6b2] text-[.8rem] font-bold">داشبورد
                    </Link>
                </li>
                <li v-if="can('users')">
                    <SubMenuLinks title="دامداران" icon="users" size="1.2"
                                  :active="CheckUrl(['/admin/users/index','/admin/users/create'])">
                        <Link href="/admin/users/index" :class="{'text-blue-600':$page.component==='Users/Index'}"
                              v-if="can('index users')">
                            همه دامداران
                        </Link>
                        <Link href="/admin/users/create" :class="{'text-blue-600':$page.component==='Users/Create'}"
                              v-if="can('create user')">
                            افزودن دامدار
                        </Link>
                    </SubMenuLinks>
                </li>
                <li v-if="can('products')">
                    <SubMenuLinks title="محصولات" icon="product" size="1.2"
                                  :active="CheckUrl(['/admin/dam/index','/admin/dam/create','/admin/group/index','/admin/groupcompany/index'])">
                        <Link href="/admin/dam/index"
                              :class="{'text-blue-600':$page.component==='Dam/Index'}" v-if="can('dam')">
                            دام ها
                        </Link>
                        <Link href="/admin/group/index"
                              :class="{'text-blue-600':$page.component==='Group/Index'}" v-if="can('group')">
                            دسته بندی
                        </Link>
                        <Link href="/admin/groupcompany/index"
                              :class="{'text-blue-600':$page.component==='GroupCompany/Index'}"
                              v-if="can('groupcompany')">
                            نژاد دسته بندی
                        </Link>
                    </SubMenuLinks>
                </li>
                <li v-if="can('role')">
                    <SubMenuLinks title="مقام" icon="rule" size="1.2"
                                  :active="CheckUrl(['/admin/role/index','/admin/role/create'])">
                        <Link href="/admin/role/index"
                              :class="{'text-blue-600':$page.component==='Role/Index'}" v-if="can('index roles')">
                            همه مقام ها
                        </Link>
                        <Link href="/admin/role/create"
                              :class="{'text-blue-600':$page.component==='Role/Create'}" v-if="can('create role')">
                            افزودن مقام
                        </Link>
                    </SubMenuLinks>
                </li>
                <li v-if="can('permission')">
                    <SubMenuLinks title="دسترسی" icon="permission" size="1"
                                  :active="CheckUrl(['/admin/permission/index','/admin/permission/create'])">
                        <Link href="/admin/permission/index" v-if="can('index permissions')"
                              :class="{'text-blue-600':$page.component==='Permission/Index'}">
                            همه دسترسی ها
                        </Link>
                        <Link href="/admin/permission/create" v-if="can('create permission')"
                              :class="{'text-blue-600':$page.component==='Permission/Create'}">
                            افزودن دسترسی
                        </Link>
                    </SubMenuLinks>
                </li>
                <li class="flex gap-1 items-center mt-4" v-if="can('gallery')">
                    <SvgComponent name="gallery" size="1.1" color="#727272"></SvgComponent>
                    <Link href="/admin/galleries" :class="{'text-white':$page.component==='Gallery/Index'}"
                          class="text-[#a4a6b2] text-[.8rem] font-bold">رسانه
                    </Link>
                </li>
                <li class="flex gap-1 items-center mt-4" v-if="can('joinnews')">
                    <SvgComponent name="news" size="1.1" color="#727272"></SvgComponent>
                    <Link href="/admin/joinnews/index" :class="{'text-white':$page.component==='JoinNews/Index'}"
                          class="text-[#a4a6b2] text-[.8rem] font-bold">خبرنامه
                    </Link>
                </li>
                <li v-if="can('permission')">
                    <SubMenuLinks title="مقاله" icon="article" size="1.19"
                                  :active="CheckUrl(['/admin/article/index','/admin/article/create'])">
                        <Link href="/admin/article/index" v-if="can('index articles')"
                              :class="{'text-blue-600':$page.component==='Article/Index'}">
                            همه مقاله ها
                        </Link>
                        <Link href="/admin/article/create" v-if="can('create article')"
                              :class="{'text-blue-600':$page.component==='Article/Create'}">
                            افزودن مقاله
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="مدیریت پرداخت و برداشت" icon="payment" size="1.1" v-if="can('payment')"
                                  :active="CheckUrl(['/admin/payment','/admin/getmoney/index'])"
                                  :counter="getmoney_Count">
                        <Link href="/admin/payment" v-if="can('index payments')"
                              :class="{'text-blue-600':$page.component==='Payment/Index'}">
                            همه پرداختی ها
                        </Link>

                        <Link href="/admin/getmoney/index" v-if="can('index payments')"
                              :class="{'text-blue-600':$page.component==='Getmoney/Index'}">
                            درخواست برداشت از حساب
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="درخواست فروش" icon="sell" size="1.2" v-if="can('payment')"
                                  :active="CheckUrl('/admin/selldam/index')" :counter="sell_Count">
                        <Link href="/admin/selldam/index" v-if="can('index payments')"
                              :class="{'text-blue-600':$page.component==='Sells/Index'}">
                            همه درخواست فروش ها
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="فاکتور" icon="factor" size="1.1" v-if="can('factor')"
                                  :active="CheckUrl(['/admin/factor','/admin/factor/create'])" :counter="factor_Count">
                        <Link href="/admin/factor" v-if="can('index factors')"
                              :class="{'text-blue-600':$page.component==='Factor/Index'}">
                            همه فاکتور ها
                        </Link>
                        <Link href="/admin/factor/create" v-if="can('create discountcode')"
                              :class="{'text-blue-600':$page.component==='Factor/Create'}">
                            افزودن فاکتور
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="پرواربندی" icon="parvarbandi" size="1.1" v-if="can('parvarbandi')"
                                  :active="CheckUrl(['/admin/parvarbandi/create/index','/admin/parvarbandi/index'])">
                        <Link href="/admin/parvarbandi/index" v-if="can('index parvarbandis')"
                              :class="{'text-blue-600':$page.component==='Parvarbandi/Index'}">
                            همه پرواربندی ها
                        </Link>
                        <Link href="/admin/parvarbandi/create/index" v-if="can('index parvarbandis')"
                              :class="{'text-blue-600':$page.component==='Parvarbandi/CreateIndex'}">
                            افزودن پرواربندی
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="تخفیف" icon="discount" size="1.1" v-if="can('discountcode')"
                                  :active="CheckUrl(['/admin/discountcode/index','/admin/discountcode/create'])">
                        <Link href="/admin/discountcode/index" v-if="can('index discountcodes')"
                              :class="{'text-blue-600':$page.component==='DiscountCode/Index'}">
                            همه تخفیف ها
                        </Link>
                        <Link href="/admin/discountcode/create" v-if="can('create discountcode')"
                              :class="{'text-blue-600':$page.component==='DiscountCode/Create'}">
                            افزودن تخفیف
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="کارت بانکی" icon="bank-card" size="1.1" v-if="can('bankcard')"
                                  :active="CheckUrl('/admin/bankcard/index')" :counter="bankcard_Count">
                        <Link href="/admin/bankcard/index" v-if="can('index bankcards')"
                              :class="{'text-blue-600':$page.component==='Bankcard/Index'}">
                            همه کارت ها
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="کامنت" icon="comment" size="1.1" v-if="can('comment')"
                                  :active="CheckUrl('/admin/comment/index')" :counter="comment_Count">
                        <Link href="/admin/comment/index" v-if="can('index comments')"
                              :class="{'text-blue-600':$page.component==='Comments/Index'}">
                            همه کامنت ها
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="تیکت" icon="sms" size="1.1" v-if="can('ticket')"
                                  :active="CheckUrl('/admin/ticket/index')" :counter="ticket_Count">
                        <Link href="/admin/ticket/index" v-if="can('index tickets')"
                              :class="{'text-blue-600':$page.component==='Ticketgroupe/Index'}">
                            همه تیکت ها
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="پیام" icon="message" size="1.1" v-if="can('message')"
                                  :active="CheckUrl(['/admin/message/index','/admin/message/create'])">
                        <Link href="/admin/message/index" v-if="can('index messages')"
                              :class="{'text-blue-600':$page.component==='Message/Index'}">
                            همه پیام ها
                        </Link>
                        <Link href="/admin/message/create" v-if="can('create message')"
                              :class="{'text-blue-600':$page.component==='Message/Create'}">
                            ارسال پیام
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="پرسش و پاسخ" icon="question-answer" size="1.1" v-if="can('questionanswer')"
                                  :active="CheckUrl(['/admin/questionanswer/index','/admin/questionanswer/create','/admin/questionanswersetting/index'])"
                                  :counter="questionanswer_Count">
                        <Link href="/admin/questionanswer/index" v-if="can('index questionanswers')"
                              :class="{'text-blue-600':$page.component==='QuestionAnswer/Index'}">
                            همه پرسش و پاسخ ها
                        </Link>
                        <Link href="/admin/questionanswersetting/index" v-if="can('questionanswersetting')"
                              :class="{'text-blue-600':$page.component==='QuestionAnswerSetting/Index'}">
                            تنظیمات
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="کامنت فیک" icon="comment" size="1.1" v-if="can('fakecomment')"
                                  :active="CheckUrl(['/admin/fakecomment/index','/admin/fakecomment/create'])">
                        <Link href="/admin/fakecomment/index" v-if="can('index fakecomments')"
                              :class="{'text-blue-600':$page.component==='FakeComment/Index'}">
                            همه کامنت فیک ها
                        </Link>
                        <Link href="/admin/fakecomment/create" v-if="can('create fakecomment')"
                              :class="{'text-blue-600':$page.component==='FakeComment/Create'}">
                            افزودن کامنت فیک
                        </Link>
                    </SubMenuLinks>
                </li>
                <li>
                    <SubMenuLinks title="تنظیمات" icon="setting" size="1.1" v-if="can('setting')"
                                  :active="CheckUrl(['/admin/contactus/index','/admin/indexsetting/index'
                                  ,'/admin/aboutus/index','/admin/husbandry/index','/admin/walletext/index'
                                  ,'/admin/faq/index','/admin/chartprice/index','/admin/paymentcondition/index'
                                  ,'/admin/authimage/index'
                                  ,'/admin/taxs/index'])">
                        <Link href="/admin/indexsetting/index" v-if="can('index setting')"
                              :class="{'text-blue-600':$page.component==='IndexSetting/Index'}">
                            صفحه اصلی
                        </Link>
                        <Link href="/admin/authimage/index" v-if="can('index setting')"
                              :class="{'text-blue-600':$page.component==='AuthImage/Index'}">
                            تصاویر ورود | عضویت
                        </Link>
                        <Link href="/admin/contactus/index" v-if="can('contactus')"
                              :class="{'text-blue-600':$page.component==='Contactus/Index'}">
                            تماس با ما
                        </Link>
                        <Link href="/admin/aboutus/index" v-if="can('aboutus')"
                              :class="{'text-blue-600':$page.component==='Aboutus/Index'}">
                            درباره ما
                        </Link>
                        <Link href="/admin/paymentcondition/index" v-if="can('aboutus')"
                              :class="{'text-blue-600':$page.component==='PaymentCondition/Index'}">
                            قوانین پرداخت
                        </Link>
                        <Link href="/admin/husbandry/index" v-if="can('husbandrytext')"
                              :class="{'text-blue-600':$page.component==='HusbandryText/Index'}">
                            متن دامداری
                        </Link>
                        <Link href="/admin/taxs/index" v-if="can('husbandrytext')"
                              :class="{'text-blue-600':$page.component==='Taxs/Index'}">
                            مالیات کمیسیون
                        </Link>
                        <Link href="/admin/walletext/index" v-if="can('wallettext')"
                              :class="{'text-blue-600':$page.component==='WalletText/Index'}">
                            متن کیف پول
                        </Link>
                        <Link href="/admin/faq/index" v-if="can('faqsetting')"
                              :class="{'text-blue-600':$page.component==='Faq/Index'}">
                            سوالات متداول
                        </Link>
                        <Link href="/admin/chartprice/index" v-if="can('chartprice')"
                              :class="{'text-blue-600':$page.component==='Chart/Index'}">
                            نمودار
                        </Link>
                    </SubMenuLinks>
                </li>
            </ul>
        </div>
        <a href="/"
           class="fixed bottom-0 right-0 bg-[#2563eb] w-[15rem] h-10 rounded-[1rem_1rem_0_0] flex items-center justify-center text-white hover:text-slate-900 font-bold sm:w-[12rem]">
            رفتن به صفحه اصلی
        </a>
    </div>
</template>
