<script setup>
import axios from "axios";
import {ref} from "vue";

const activity = ref()
axios.get('/get/card/activity').then(res => {
    // console.log(res.data.data)
    activity.value = res.data.data
})
</script>

<template>
    <table class="table table-striped border rounded" v-if="activity">
        <thead>
        <tr>
            <th scope="col" class="tr">نوع</th>
            <th scope="col" class="tr">زمان</th>
            <th scope="col" class="tr">مقدار</th>
            <!--            <th scope="col" class="tr">کارمزد</th>-->
            <th scope="col" class="tr">شماره کارت/شبا</th>
            <th scope="col" class="tr">کد رهگیری</th>
            <th scope="col" class="tr">وضعیت</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in activity">
            <td class="td">
                <strong :class="{blue:item.status==1,orange:item.status==0}">{{ item.payment_type }}</strong>
            </td>
            <td class="td">
                <p class="ltr">{{ item.created_at_with_time }}</p>
            </td>
            <td class="td">
                <p>{{ item.price }}</p>
            </td>
            <!--            <td>-->
            <!--                <p>{{ item.wage }}</p>-->
            <!--            </td>-->
            <td class="td">
                <p>{{ item.card_number }}</p>
            </td>
            <td class="td">
                <p>{{ item.resNumber }}</p>
            </td>
            <td class="td">
                <span class="green" v-if="item.status==1">موفق</span>
                <span class="red" v-else>ناموفق</span>
            </td>
        </tr>
        <!--        <tr>-->
        <!--            <td>-->
        <!--                <strong class="orange">واریز</strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>12:32 ، 12 اسنفد 1402</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>2,500,000</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>234,000</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>5720 3849 5839 2819</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>47862307</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <span class="red">ناموفق</span>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td>-->
        <!--                <strong class="blue">واریز</strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>12:32 ، 12 اسنفد 1402</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>2,500,000</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>234,000</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>5720 3849 5839 2819</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>47862307</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <span class="green">موفق</span>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td>-->
        <!--                <strong class="orange">واریز</strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>12:32 ، 12 اسنفد 1402</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>2,500,000</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>234,000</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>5720 3849 5839 2819</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <p>47862307</p>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <span class="red">ناموفق</span>-->
        <!--            </td>-->
        <!--        </tr>-->
        </tbody>
    </table>
</template>

<style scoped>

</style>
