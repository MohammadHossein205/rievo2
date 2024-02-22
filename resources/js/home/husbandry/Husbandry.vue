<script setup>
import {ref} from "vue";

const props = defineProps(['factors', 'tax', 'payments', 'today', 'selldamcout', 'selldammoney', 'buydamcout', 'buydammoney', 'userdamcout', 'userdammoney', 'user'])

const factors = ref(props.factors)
const payments = ref(props.payments)
const today = ref(props.today)
const selldamcout = ref(props.selldamcout)
const selldammoney = ref(props.selldammoney)
const buydamcout = ref(props.buydamcout)
const buydammoney = ref(props.buydammoney)
const userdamcout = ref(props.userdamcout)
const userdammoney = ref(props.userdammoney)
const tax = ref(props.tax)
const user = ref(props.user)
const IndexOfTab = ref(1)


</script>

<template>
    <div class="dashLeft">
        <div class="husbndryTab">
            <div v-for="(factor,index) in factors">
                <h2 v-if="index==0">دامداری</h2>
                <div class="factorNotif" v-if="factor.admin_show==1 && factor.status == 0">
                    <p>
                        فاکتور این ماه ( {{ factor.created_at }}) صادر شده است - با مشاهده
                        و بررسی آن اقدام به پرداخت نمایید
                    </p>
                    <a
                        href="#"
                        class="transitionCls showFactr"
                        @click.prevent="IndexOfTab=4"
                    >مشاهده و پرداخت</a>
                </div>
            </div>
            <div class="tabBox fctrTabBx">
                <div class="tabBXHeader">
                    <ul class="position-relative">
                        <li>
                            <a
                                href="#"
                                class="tablinks active transitionCls"
                                tabId="tabOne"
                                id="defaultOpen"
                                @click.prevent="IndexOfTab=1"
                            >
                                نمای کلی
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="tablinks transitionCls"
                                tabId="tabTwo"
                                @click.prevent="IndexOfTab=2"
                            >
                                لیست دام ها
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="tablinks transitionCls"
                                tabId="tabThree"
                                @click.prevent="IndexOfTab=3"
                            >
                                تاریخچه تراکنش ها
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="tablinks transitionCls tabFactrLnk"
                                tabId="tabFour"
                                @click.prevent="IndexOfTab=4"
                            >
                                لیست فاکتور ها
                            </a>
                        </li>
                        <li class="goToFactrLi">
                            <div class="goToFactrLst">
                                بازگشت به صفحه فاکتور ها
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="tabOne" class="tabcontent" v-if="IndexOfTab==1">
                    <div class="dshHusChart">
                        <user-profit :payment="payments"
                                     :today="today"></user-profit>
                    </div>
                    <div class="dshHusOvrviw">
                        <h2>نمای کلی دامداری</h2>
                        <ul>
                            <li>
                                <div class="dshOvrviwTop">
                                    <span class="icon-Vector-1171"></span>
                                    <div>
                                        <strong>{{ selldamcout }}</strong>
                                        <p>فروخته شده</p>
                                    </div>
                                </div>
                                <div class="dshOvrviwBtm">
                                    <p>برآورد ارزش دامداری شما</p>
                                    <div>
                                        <strong>{{ buydammoney }}</strong>
                                        <img src="../../../../public/img/toman.png" alt="img"/>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dshOvrviwTop">
                                    <span class="icon-Vector-5211"></span>
                                    <div>
                                        <strong>{{ buydamcout }}</strong>
                                        <p>خریداری شده</p>
                                    </div>
                                </div>
                                <div class="dshOvrviwBtm">
                                    <p>مبلغ کل دریافتی فروش</p>
                                    <div>

                                        <strong>{{ selldammoney }}</strong>
                                        <img src="../../../../public/img/toman.png" alt="img"/>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dshOvrviwTop">
                                    <span class="icon-Vector-522"></span>
                                    <div>
                                        <strong>{{ userdamcout }}</strong>
                                        <p>دام های فعال</p>
                                    </div>
                                </div>
                                <div class="dshOvrviwBtm">
                                    <p>مبلغ هزینه شده برای خرید</p>
                                    <div>
                                        <strong>{{ userdammoney }}</strong>
                                        <img src="../../../../public/img/toman.png" alt="img"/>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="costBenftTbl">
                        <h2>میزان سود و زیان هر دام به تفکیک</h2>
                        <div class="table-responsive">
                            <user-dam-table :payment="payments"></user-dam-table>
                        </div>
                    </div>
                </div>


                <div id="tabTwo" class="tabcontent" v-if="IndexOfTab==2">
                    <user-dam :payments="payments"
                              :factor="factors"
                              :tax="tax"
                    ></user-dam>
                </div>


                <div id="tabThree" class="tabcontent" v-if="IndexOfTab==3">
                    <user-activity :payment="payments"></user-activity>
                </div>
                <detail-factor :factors="factors"
                               :user="user"
                               :tax="tax"
                ></detail-factor>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
