<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import {LineChart} from 'vue-chart-3';
import {Chart, registerables} from "chart.js";
import {data} from "autoprefixer";
import axios from "axios";
import {toast} from "vue3-toastify";

Chart.register(...registerables);
// export default {
//     props: ['test'],
//     data() {
//
//     }
// }

export default defineComponent({
    name: 'Home',
    components: {LineChart},
    props: ['time', 'money'],
    data() {
        return {
            groups: [],
            tabIndex: 0,
            form: {
                id: this.money,
                payment: this.time,
                dam: [],
                last_updated_at: '',
                group_id: '',
                price: '',
            },
        }
    },
    mounted() {
        let today = localStorage.getItem('today')
        this.price_t.push(localStorage.getItem('money').toString().split(','))
        this.created_t.push(localStorage.getItem('time').toString().split(','))
        this.price_t[0].pop()
        this.created_t[0].pop()
        let temp_price = 0
        let temp_time = 0

        this.price_t[0].map((item) => {
            temp_price += parseInt(item)
        })

        axios.get('/user/full_price').then(res => {
            if (res.data.data.length != 0) {
                if (res.data.data[res.data.data.length - 1].created_at_chart != today) {
                    this.price.push(temp_price)
                    this.form.price = this.price[this.price.length - 1]
                    axios.post('/user/set/full_price', this.form).then(resp => {
                        if (resp.data == 200) {
                            toast.success('اطلاعات جدید اضافه شد لطفا صفحه را بروز کنید', {
                                autoClose: 3000,
                                position: toast.POSITION.BOTTOM_RIGHT,
                            })
                            // this.price.push(parseInt(resp.data.data.price.toString().replace(/\D/g, "")))
                            // this.created.push(resp.data.data.created_at_chart)
                        }
                    })
                } else {
                    // this.price.push(temp_price)
                    this.form.price = temp_price
                    axios.post('/user/update/full_price', this.form).then(resp => {
                        if (resp.data == 200) {
                            toast.success('اطلاعات جدید اضافه شد لطفا صفحه را بروز کنید', {
                                autoClose: 3000,
                                position: toast.POSITION.BOTTOM_RIGHT,
                            })
                        }
                    })
                }
                res.data.data.map((item) => {
                    this.price.push(item.price)
                    this.created.push(item.created_at_chart)
                })

            } else {
                this.price.push(temp_price)
                this.form.price = this.price[this.price.length - 1]
                axios.post('/user/set/full_price', this.form).then(resp => {
                    if (resp.data == 200) {
                        toast.success('اطلاعات جدید اضافه شد لطفا صفحه را بروز کنید', {
                            autoClose: 3000,
                            position: toast.POSITION.BOTTOM_RIGHT,
                        })
                        // this.price.push(parseInt(resp.data.data.price.toString().replace(/\D/g, "")))
                        // this.created.push(resp.data.data.created_at_chart)
                    }
                })
            }
        })
        // temp_time = this.created_t[0][0]
        // this.created.push(this.created_t[0][0])
        // this.created_t[0].map((item) => {
        //     if (item != temp_time) {
        //         temp_time = item
        //         this.created.push(item)
        //         this.price.push(temp_price)
        //     }
        // })

    },
    methods: {},
    setup() {

        const dam_id = ref([])
        const price_t = ref([])
        const price = ref([])
        const created_t = ref([])
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

        return {testData, price, created, price_t, created_t, dam_id};
    },
});
</script>

<template>
    <LineChart :chartData="testData" :style="{height:30+'rem'}"/>
</template>

<style scoped>

</style>
