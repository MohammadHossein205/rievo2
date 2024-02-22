import {ref} from "vue";

const showModal = ref(false);
let MultiSelect = false;
const selectValue = ref('');

const MultiSelectValue = ref([]);

const Baner1 = ref('');
const Baner2 = ref('');

const selectIdValue = ref([]);
let _number = 0;
const BanerValue = (number) => {
    btnShowModal(false);
    _number = number;
    selectValue.value = '';
}
const closeModal = (e) => {
    if (e.target.className.includes('modalGallery')) {
        showModal.value = false;
        if (_number == 1) {
            Baner1.value = selectValue.value;
            selectValue.value = '';
        } else if (_number == 2) {
            Baner2.value = selectValue.value;
            selectValue.value = '';
        }
    }
}
const btnShowModal = (multiSelectValue) => {
    MultiSelect = multiSelectValue;
    showModal.value = !showModal.value
}


export {
    showModal,
    selectValue,
    selectIdValue,
    MultiSelectValue,
    MultiSelect,
    closeModal,
    btnShowModal,
    BanerValue,
    Baner1,
    Baner2
}
