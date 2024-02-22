import {ref} from "vue";

const showSidebar = ref(true);

const checkScreen = () => {
    if (window.screen.width < 500) {
        showSidebar.value = false;
        return true;
    } else {
        return false;
    }
}
const ShowHideMenu = () => {
    showSidebar.value = !showSidebar.value;
}

export {
    showSidebar,
    ShowHideMenu,
    checkScreen
}
