<template>

    <Carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currentSlide">
        <Slide v-for="(slide,index) in this.damimage" :key="index" class="swiper-slide">
            <div class="swiper-slide">
                <img :src="slide.url" alt="" class="main-image">
            </div>
            <!--            <div class="carousel__item">{{ slide }}</div>-->
            <slot></slot>
        </Slide>
    </Carousel>

    <Carousel
        id="thumbnails"
        :items-to-show="4"
        :wrap-around="true"
        v-model="currentSlide"
        ref="carousel"
    >

        <Slide v-for="(slide,index) in this.damimage" :key="index" class="swiper-slide">
            <div class="swiper-slide">
                <img :src="slide.url" alt="" @click="slideTo(index)">
            </div>
            <!--            <div class="carousel__item">{{ slide }}</div>-->
        </Slide>
    </Carousel>
</template>

<script>
import {defineComponent} from 'vue'
import {Carousel, Navigation, Slide} from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'

export default defineComponent({
    name: 'Gallery',
    props: ['damimage', 'dam'],
    components: {
        Carousel,
        Slide,
        Navigation,
    },

    data: () => ({
        currentSlide: 0,
        image: [],
    }),
    mounted() {

    },
    methods: {
        slideTo(val) {
            this.currentSlide = val
        },
    },
    setup(props) {

    },
})
</script>
