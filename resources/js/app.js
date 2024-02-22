import './bootstrap';
import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import CKEditor from '@mayasabha/ckeditor4-vue3';
import LaravelPermissionToVueJs from "laravel-permission-to-vuejs";
import Vue3PersianDatetimePicker from 'vue3-persian-datetime-picker'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueSweetalert2)
            .use(CKEditor)
            .use(LaravelPermissionToVueJs)
            .component('DatePicker', Vue3PersianDatetimePicker)
            .mount(el)
    },
})
