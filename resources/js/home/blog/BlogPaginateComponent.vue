<script setup lang="ts">
import {ref} from "vue";
import {VueAwesomePaginate} from "vue-awesome-paginate";

const props = defineProps(['paginate']);
const emit = defineEmits(['sendData']);

const onClickHandler = (page: number) => {
    emit('sendData', page);
};

const currentPage = ref(1);
</script>

<template>
    <vue-awesome-paginate
        :total-items="props.paginate.total"
        v-model="currentPage"
        :items-per-page="props.paginate.per_page"
        :max-pages-shown="5"
        :on-click="onClickHandler"
        :disable-breakpoint-buttons="true"
        :hide-prev-next-when-ends="true"
    />
</template>


<style>
.pagination-container {
    display: flex;
    column-gap: 10px;
}

.paginate-buttons {
    height: 30px;
    width: 30px;
    border-radius: 20px;
    cursor: pointer;
}

.number-buttons, .first-button, .last-button, .back-button, .next-button, .ending-breakpoint-button, .starting-breakpoint-button {
    color: var(--gray-6);
    font-weight: bold;
}

.paginate-buttons:hover {
    background-color: #d8d8d8;
}

.active-page {
    background-color: #3498db;
    border: 1px solid #3498db;
    color: white;
}

.active-page:hover {
    background-color: #2988c8;
}
</style>
