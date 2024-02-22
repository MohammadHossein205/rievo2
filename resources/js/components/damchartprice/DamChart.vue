<script setup>
import {ref} from "vue";

const props = defineProps(['groupid'])
const group_id = ref(props.groupid)

const tabIndex = ref(0)
const SetIndex = (index) => {
    if (tabIndex.value != index) {
        tabIndex.value == index
    }
}
</script>

<template>
    <div class="tabBXHeader">
        <ul>
            <li v-for="(damgroup,index) in group_id">
                <a
                    href="#"
                    class="tablinks position-relative"
                    :class="{active:tabIndex==index}"
                    tabId="tabOne"
                    id="defaultOpen"
                    @click.prevent="SetIndex(index)"
                >{{ damgroup.name }}
                </a>
            </li>
        </ul>
    </div>
    <div class="priceLstTab">
        <div id="tabOne" class="tabcontent">
            <canvas id="pricLstChrt1"></canvas>
        </div>
    </div>
</template>

<style scoped>

</style>
