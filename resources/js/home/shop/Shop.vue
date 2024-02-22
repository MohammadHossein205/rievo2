<script setup>
import {ref} from "vue";
import axios from "axios";
import {toast} from "vue3-toastify";
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";
import BuyDam from "@/home/singleDam/BuyDam.vue";

const props = defineProps(['dams', 'groupcompany', 'groupname', 'damscount', 'singledam', 'isfilter'])
const groupeCompany = ref(props.groupcompany);


const dams = ref(props.dams)
// const user = ref(props.user)

const IsFilter = ref(props.isfilter)
const groups = ref(props.groupname)
const damsCount = ref(props.damscount)
const damVizhe = ref()
const IsSingle = ref(false)
if (props.singledam.length != 0) {
    damVizhe.value = props.singledam[0]
    IsSingle.value = true
}


const MaxMoney = ref(props.dams[0].price.split(',').join(''))
const MaxWeight = ref(props.dams[0].weight)
const MaxDate = ref(props.dams[0].ageYear)
const MaxMilkAmount = ref(props.dams[0].milk_amount)
const AllColor = ref([])

for (let i = 1; i < props.dams.length; i++) {
    if (parseInt(props.dams[i].price.split(',').join('')) > parseInt(MaxMoney.value.split(',').join(''))) {
        MaxMoney.value = props.dams[i].price.split(',').join('');
    }
    if (props.dams[i].weight > MaxWeight.value) {
        MaxWeight.value = props.dams[i].weight;
    }
    if (props.dams[i].ageYear > MaxDate.value) {
        MaxDate.value = props.dams[i].ageYear;
    }
    if (props.dams[i].milk_amount > MaxMilkAmount.value) {
        MaxMilkAmount.value = props.dams[i].milk_amount;
    }
    AllColor.value.push(dams.value[i].color)
}
const form = ref({
    minValue: 100,
    maxValue: MaxMoney.value,
    race: 'all_race',
    minWeight: 0,
    maxWeight: MaxWeight.value,
    minDate: 0,
    maxDate: MaxDate.value,
    gender: 0,
    haveMilk: false,
    minMilkAmount: 0,
    maxMilkAmount: MaxMilkAmount.value,
    color: 'all_color',
})

const GetDam = () => {
    InfiniteShow.value = false;
    axios.post('/user/GetDamWithCondition/dam', form.value).then(res => {
        dams.value = res.data.data;
    }).catch(err => {
        toast(err.message, {
            autoClose: 3000,
            position: toast.POSITION.BOTTOM_RIGHT,
        })
    })
}
const page = ref(1)
const InfiniteShow = ref(true)
const loadData = () => {
    page.value++
    axios.post(`/shop/get_dam?page=${page.value}`, form.value).then(res => {
        if (res.data.data.length != 0)
            res.data.data.map((item) => {
                dams.value.push(item)
            })
        else
            InfiniteShow.value = false
    })
}

</script>

<template>
    <section class="shopSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shopSecTtl">
                        <h1>دام های فروشگاه</h1>
                        <span>{{ damsCount }} دام</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="shopCat">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="shopCatTtl">
                            <span class="icon-Vector-781"></span>
                            <strong>دسته بندی دام ها</strong>
                        </div>
                        <div class="shopCatBdy">
                            <a :href="`/shop/${group.name}`" class="shopCatCrd position-relative transitionCls"
                               v-for="group in groups">
                                <img
                                    :src="group.image"
                                    class="position-relative"
                                    :alt="group.name"
                                />
                                <div class="shopCatCrdBg">
                                    <strong>{{ group.name }}</strong>
                                    <p>{{ group.dam_count }} محصول</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="shopPgBx">
                        <div class="shopPgFltr" v-if="IsFilter">
                            <div class="shopFltrHed">فیلتر ها</div>
                            <div class="openFiltrLst">فیلتر ها</div>
                            <div class="shopFltrBdy">
                                <div class="shopFltrTtl">رنج قیمتی</div>
                                <div class="priceRange rangeFilter">
                                    <div class="wrapper">
                                        <div class="multi-range-slider">
                                            <input
                                                type="range"
                                                id="input-left"
                                                min="0"
                                                step="50"
                                                :max="MaxMoney"
                                                v-model="form.minValue"
                                                @change="GetDam"
                                            />
                                            <input
                                                type="range"
                                                id="input-right"
                                                min="0"
                                                step="50"
                                                :max="MaxMoney"
                                                v-model="form.maxValue"
                                                @change="GetDam"
                                            />
                                            <div class="slider">
                                                <div class="track"></div>
                                                <div class="range"></div>
                                                <div class="price__wrapper">
                                                    <span class="price-from"></span>
                                                    <span class="price-to"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shopFltrTtl">انتخاب نژاد</div>
                                <div class="selRadioBx selRaceBx">
                                    <div class="selRadioDiv selRaceDiv">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="raceRadio"
                                                @click="form.race='all_race'"
                                                @change="GetDam"
                                                :checked="form.race=='all_race'"
                                            />
                                            <label class="form-check-label" for="raceRadio01">
                                                همه نژاد ها
                                            </label>
                                        </div>
                                        <div class="form-check" v-for="(race,index) in groupeCompany">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="raceRadio"
                                                @click="form.race=index+1"
                                                @change="GetDam"
                                            />
                                            <label class="form-check-label" for="raceRadio01"
                                            >{{ race.name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="shopFltrTtl weightRngTtl">رنج وزنی</div>
                                <div class="weightRng rangeFilter">
                                    <div class="wrapper">
                                        <div class="multi-range-slider">
                                            <input
                                                type="range"
                                                id="input-left"
                                                min="0"
                                                step="1"
                                                :max="MaxWeight"
                                                v-model="form.minWeight"
                                                @change="GetDam"
                                            />
                                            <input
                                                type="range"
                                                id="input-right"
                                                min="0"
                                                step="1"
                                                :max="MaxWeight"
                                                v-model="form.maxWeight"
                                                @change="GetDam"
                                            />
                                            <div class="slider">
                                                <div class="track"></div>
                                                <div class="range"></div>
                                                <div class="price__wrapper">
                                                    <span class="price-from"></span>
                                                    <span class="price-to"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shopFltrTtl">رنج سنی</div>
                                <div class="yearRange rangeFilter">
                                    <div class="wrapper">
                                        <div class="multi-range-slider">
                                            <input
                                                type="range"
                                                id="input-left"
                                                min="1"
                                                step="1"
                                                :max="MaxDate"
                                                v-model="form.minDate"
                                                @change="GetDam"
                                            />
                                            <input
                                                type="range"
                                                id="input-right"
                                                min="1"
                                                step="1"
                                                :max="MaxDate"
                                                v-model="form.maxDate"
                                                @change="GetDam"
                                            />
                                            <div class="slider">
                                                <div class="track"></div>
                                                <div class="range"></div>
                                                <div class="price__wrapper">
                                                    <span class="price-from"></span>
                                                    <span class="price-to"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shopFltrTtl weightRngTtl">رنگ پوست</div>
                                <div class="selRadioBx selColorBx">
                                    <div class="selRadioDiv selColorDiv">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="colorRadio"
                                                @click="form.color = 'all_color'"
                                                @change="GetDam"
                                                :checked="form.color=='all_color'"
                                            />
                                            <label class="form-check-label" for="colorRadio01">
                                                <p>همه رنگ ها</p>
                                            </label>
                                        </div>
                                        <div class="form-check" v-for="color in AllColor">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="colorRadio"
                                                @click="form.color = color"
                                                @change="GetDam"
                                            />
                                            <label class="form-check-label" for="colorRadio01">
                                                <p>{{ color }}</p>
                                                <span :style="{backgroundColor:color}"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="shopFltrTtl selGendrTtl">انتخاب جنسیت</div>
                                <div class="selGender">
                                    <div class="form-check position-relative" @click="form.gender = 1">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="gndrRadio"
                                            id="gndrRadio01"
                                            :checked="form.gender==1"
                                            @change="GetDam"
                                        />
                                        <label
                                            class="form-check-label gndrSel01"
                                            for="gndrRadio01"
                                        >
                                            نر
                                        </label>
                                    </div>
                                    <div class="form-check position-relative" @click="form.gender = 0">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="gndrRadio"
                                            id="gndrRadio02"
                                            :checked="form.gender==0"
                                            @change="GetDam"
                                        />
                                        <label
                                            class="form-check-label gndrSel02"
                                            for="gndrRadio02"
                                        >
                                            ماده
                                        </label>
                                    </div>
                                </div>
                                <div class="form-check form-switch milchSwitch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="flexSwitchCheckDefault"
                                        v-model="form.haveMilk"
                                        @change="GetDam"
                                    />
                                    <label class="form-check-label" for="flexSwitchCheckDefault"
                                    >شیرده</label
                                    >
                                </div>
                                <div class="shopFltrTtl">مقدار مصرف شیر</div>
                                <div class="milkRange rangeFilter">
                                    <div class="wrapper">
                                        <div class="multi-range-slider">
                                            <input
                                                type="range"
                                                id="input-left"
                                                min="0"
                                                step="1"
                                                :max="MaxMilkAmount"
                                                v-model="form.minMilkAmount"
                                                @change="GetDam"
                                            />
                                            <input
                                                type="range"
                                                id="input-right"
                                                min="0"
                                                step="1"
                                                :max="MaxMilkAmount"
                                                v-model="form.maxMilkAmount"
                                                @change="GetDam"
                                            />
                                            <div class="slider">
                                                <div class="track"></div>
                                                <div class="range"></div>
                                                <div class="price__wrapper">
                                                    <span class="price-from"></span>
                                                    <span class="price-to"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shopPgBdy">
                            <div class="shopBdyTop" v-if="IsSingle">
                                <div class="shopTopInfo">
                                    <div class="shopTopRght">
                                        <div class="shopTopFee">
                                            <div class="shopTopTime">
                                                <p>فروش ویژه</p>
                                                <!-- <strong>12 : 23 : 41</strong> -->
                                                <strong class="countdown"></strong>
                                                <span>زمان باقی مانده</span>
                                            </div>
                                            <hr/>
                                            <div class="shopTopPric">
                                                <span>قیمت</span>
                                                <strong class="position-relative">
                                                    <img src="../../../../public/img/toman.png" alt="img"/>
                                                    {{ damVizhe.price }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="shopTopLnks">
                                            <a :href="`/single/damvizhe/${damVizhe.slug}`" class="transitionCls">
                                                <span class="icon-Group-2108"></span>
                                                <p>اضافه کردن به سبد خرید</p>
                                                <i class="icon-Group-2210"></i>
                                            </a>
                                            <!--                                            <buy-dam :dam="props.singledam" :text="true" :arrow="true"-->
                                            <!--                                                     :user="user"></buy-dam>-->
                                            <slot></slot>
                                        </div>
                                    </div>
                                    <div class="shopTopLeft">
                                        <h2>{{ damVizhe.name }}</h2>
                                        <ul>
                                            <li>
                                                <span>نژاد</span>
                                                <div>
                                                    <p>{{ damVizhe.group_company_id }}</p>
                                                    <i>{{ damVizhe.group_company_id }}</i>
                                                </div>
                                            </li>
                                            <li>
                                                <span>سن</span>
                                                <div><p>{{ damVizhe.ageYear }} سال {{ damVizhe.ageMonth }}
                                                    ماه</p></div>
                                            </li>
                                            <li>
                                                <span> جنسیت</span>
                                                <div><p>{{ damVizhe.gender }}</p></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <img :src="damVizhe.image.length!=0?damVizhe.image[0].url:''" class="shopTopImg"
                                     :alt="damVizhe.name"/>
                            </div>
                            <div class="shopLastSec">
                                <div class="shopCatTtl">
                                    <span class="icon-Vector-781"></span>
                                    <strong>آخرین محصولات</strong>
                                </div>
                                <div class="shopLstBdy">
                                    <a
                                        :href="`/single/dam/${dam.slug}`"
                                        class="shopLstCrd transitionCls position-relative"
                                        v-for="dam in dams"
                                    >
                                        <div class="shopLstImg">
                                            <img :src="dam.image[0].url" :alt="dam.name" v-if="dam.image.length!=0"/>
                                        </div>
                                        <div class="shpLstInfo">
                                            <h2>{{ dam.name }}</h2>
                                            <ul>
                                                <li>
                                                    <span>نژاد </span>
                                                    <p>{{ dam.group_company_id }}</p>
                                                </li>
                                                <li>
                                                    <span>سن</span>
                                                    <p>{{ dam.ageYear }} سال {{ dam.ageMonth }} ماه</p>
                                                </li>
                                                <li>
                                                    <span>جنسیت</span>
                                                    <p>{{ dam.gender }}</p>
                                                </li>
                                            </ul>
                                            <div class="lstCrdbtm">
                                                <div class="lstCrdLike">
                                                    <span class="icon-Group-2108 transitionCls"></span>
                                                    <span class="icon-Group-2271 transitionCls"></span>
                                                </div>
                                                <div class="lstCrdPric">
                                                    <p>قیمت</p>
                                                    <strong class="position-relative">
                                                        <img src="../../../../public/img/toman.png" alt="img"/>
                                                        {{ dam.price }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <button class="loadMorLnk transitionCls" v-if="InfiniteShow&&IsFilter">
                                    <span class="icon-Group-2343"></span>
                                    <p>درحال بارگذاری</p>
                                    <InfiniteLoading @infinite="loadData"></InfiniteLoading>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
