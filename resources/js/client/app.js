require('./bootstrap');
// Import Style
import 'element-plus/theme-chalk/index.css'
import "vue-toastification/dist/index.css";

// Import modules...
import { createApp, h } from 'vue';
// import { App as InertiaApp, plugin as InertiaPlugin, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3'

// ARGON TEMPLATE
import ArgonDashboard from '@/Argon/plugins/argon-dashboard'
import Toast from "vue-toastification";
// Vuex
import store from '@/Store'
// Directives
import permission from '@/Directives/permission'
import role from '@/Directives/role'
import screenSize from '@/Directives/screen_size'
// Declaration
const options = { containerClassName: "ct-notification" };
const el = document.getElementById('app');

import FeatherIcon from "@/Components/FeatherIcon.vue"

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mixin(permission)
            .mixin(role)
            .component('feather-icon', FeatherIcon)
            .component('inertia-link', Link)
            .mixin(screenSize)
            .use(ArgonDashboard)
            .use(Toast, options)
            .use(store)
            .mount(el);
    },
})

InertiaProgress.init({ color: '#4B5563' });