<script lang="ts">

import {defineComponent, onMounted, ref} from 'vue';
import {LineChart} from 'vue-chart-3';
import {Chart, registerables} from "chart.js";
import axios from "axios";
import {toast} from "vue3-toastify";

Chart.register(...registerables);

export default defineComponent({
    name: 'Home',
    components: {LineChart},
    props: [''],
    data() {
        return {
            groups: [],
            tabIndex: 0,
            form: {
                id: 0,
                last_updated_at: ''
            },
        }
    },
    mounted() {
        axios.get('/get_groups').then(res => {
            this.groups = res.data
            this.form.id = this.groups[this.tabIndex].id
            axios.post('/FillChart', this.form).then(respon => {
                respon.data.data.map((item) => {
                    this.price.push(item.price.replace(/,/g, ""))
                    this.created.push(item.created_at_chart)
                })
            })
            axios.post('/GetLastUpdate', this.form).then(respones => {
                this.form.last_updated_at = respones.data.data[0].updated_at
            })
        })
    },
    methods: {
        SetIndex: function (index) {
            this.tabIndex = index
            this.form.id = this.groups[this.tabIndex].id
            let length = this.price.length
            for (let i = 0; i < length; i++) {
                this.price.pop()
                this.created.pop()
            }
            axios.post('/FillChart', this.form).then(respon => {
                if (respon.data.data.length != 0) {
                    respon.data.data.map((item) => {
                        this.price.push(item.price.replace(/,/g, ""))
                        this.created.push(item.created_at_chart)
                    })
                    axios.post('/GetLastUpdate', this.form).then(respones => {
                        this.form.last_updated_at = respones.data.data[0].updated_at
                    })
                } else {
                    toast.error('برای این دسته بندی قیمتی وجود ندارد', {
                        position: toast.POSITION.BOTTOM_RIGHT,
                        autoClose: 3000
                    })
                }
            })
        }
    },
    setup() {
        const price = ref([])
        const created = ref([])
        const testData = {
            labels: created.value,
            datasets: [
                {
                    data: price.value,
                    backgroundColor: ['#C61331'],
                    borderColor: '#C61331',
                    borderWidth: 2,
                },
            ],
        };

        return {testData, price, created};
    },
});

</script>

<template>
    <div class="priceLstHed">
        <p>
            <img src="../../../public/img/info_mark.png" alt="icon"/>
            <i id="inquiry">لیست قیمت به تفکیک</i>
        </p>
        <div>
            <strong>{{ form.last_updated_at }}</strong>
            <span>آخرین بروزرسانی</span>
        </div>
    </div>
    <div class="priceLstBdy">
        <div class="tabBXHeader">
            <ul>
                <li v-for="(item,index) in groups">
                    <a
                        href="#"
                        class="tablinks position-relative"
                        :class="{active:tabIndex==index}"
                        tabId="tabOne"
                        id="defaultOpen"
                        @click.prevent="SetIndex(index)"
                    >{{ item.name }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="priceLstTab">
            <div id="tabOne" class="tabcontent">
                <div class="hidden-undefined"></div>
                <LineChart :chartData="testData"/>
            </div>
        </div>
    </div>
</template>
