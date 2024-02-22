<script setup>
import {btnShowModal, closeModal, showModal} from '../../Pages/modalGalleries/Modal.js';

import {ref} from "vue";
import SvgComponent from "@/components/part/SvgComponent.vue";

const props = defineProps(['discountdata', 'discountId']);
const emit = defineEmits(['getDiscount']);
const discountData = ref(props.discountdata.data)
const selectId = ref(props.discountId);
const discountCode = ref('');

const SelectId = (id) => {
  selectId.value = id;
  emit('getDiscount', selectId);
}
</script>


<template>
  <div
      class="modalGallery fixed left-0 top-0 z-10 w-screen h-screen bg-[rgba(5,5,5,.6)] backdrop-blur-lg grid justify-center items-center hover:cursor-default sm:block"
      @click="closeModal">
    <div class="bg-white w-[50rem] h-[40rem] p-1 rounded-lg no-scrollbar overflow-y-auto sm:w-[90%] sm:m-auto">
      <div class="flex justify-between items-center">
        <h1 class="font-bold m-2 text-[1rem]">انتخاب تخفیف</h1>
        <span @click="btnShowModal(false)" class="hover:cursor-pointer">
                    <SvgComponent name="close" size="1.5" color="#25282f"></SvgComponent>
                </span>
      </div>
      <div v-for="discount in discountData" class="w-full bg-slate-200 rounded-lg">
        <div
            class="grid grid-cols-[auto_auto_auto_auto_auto_auto_auto] gap-2 items-center my-2 p-4 rounded-lg transition-all hover:cursor-pointer"
            @click="SelectId(discount.id)" :class="{'bg-[#1b1c1e] text-white':discount.id==selectId}">
          <div>
            <span>کد تخفیف : </span>
            <span>{{ discount.discount_code }}</span>
          </div>
          |
          <div>
            <span>مبلغ تخفیف : </span>
            <span>{{ discount.price }}تومان</span>
          </div>
          |
          <div>
            <span>تعداد استفاده تخفیف : </span>
            <span>{{ discount.count }}</span>
          </div>
          |
          <div>
            <span>انقضاء تخفیف : </span>
            <span>{{ discount.end_time }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

