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
    props: ['dam'],
    data() {
        return {
            groups: [],
            tabIndex: 0,
            form: {
                id: this.dam.id,
                last_updated_at: '',
                group_id: '',
            },
        }
    },
    mounted() {
        // axios.post('/user/GetUserFactorDetailForEachDam', this.form).then(res => {
        //     console.log(res.data)
        // })
        axios.post('/user/dam/group_id', this.form).then(res => {
            this.form.group_id = res.data
            this.price.push(this.dam.disount_price? this.dam.disount_price.toString().replace(/,/g, ""):this.dam.price.toString().replace(/,/g, ""))
            this.created.push(this.dam.created_at)
            axios.post('/user/dam/FillChart', this.form).then(resp => {
                resp.data.data.map((item) => {
                    this.price.push(parseInt(item.price.toString().replace(/,/g, "")) * parseInt(this.dam.weight))
                    this.created.push(item.created_at)
                })

            })
        })
    },
    methods: {},
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
    <LineChart :chartData="testData"/>
</template>

<style scoped>

</style>
