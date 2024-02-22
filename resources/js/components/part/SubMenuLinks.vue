<script setup>
import {ref} from "vue";
import SvgComponent from "../../components/part/SvgComponent.vue";


const props = defineProps(['title', 'icon', 'size', 'active', 'counter'])
const arrowStyle = ref({});
const showMenu = ref(props.active ? props.active : false)

const toggleShowMenu = () => {
    showMenu.value = !showMenu.value;
}

</script>

<template>
    <div class="flex items-center mt-4">
        <div class="grid grid-cols-[auto_auto] gap-1 items-center">
            <SvgComponent :name="icon" :size="size" :color="showMenu?'white':'#727272'"></SvgComponent>
            <a href="" @click.prevent="toggleShowMenu" :style="showMenu ? 'color : white' : 'color : #a4a6b2'"
               class="relative w-[10.9rem] block font-bold">{{ title }}</a>
        </div>
        <span v-if="props.counter"
              class="absolute left-7 text-white text-[.65rem] font-bold bg-red-600 rounded-full px-1">{{ props.counter }}</span>
        <div class="transition-all flex items-center" :class="{'rotate-[-90deg]':showMenu}">
            <SvgComponent name="arrow-left" size=".8" :color="showMenu?'white':'#727272'"></SvgComponent>
        </div>
    </div>
    <ul class="grid mt-3 mr-2 text-white text-[.7rem] gap-1" v-if="showMenu">
        <slot></slot>
    </ul>
</template>
