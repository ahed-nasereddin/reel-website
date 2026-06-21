import './bootstrap';
import '../css/app.css';
import 'vue3-toastify/dist/index.css';

import './bootstrap';
import '../css/app.css';
import 'vue3-toastify/dist/index.css';

import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js'; // ✅ لتفعيل @routes في Vue
import AppLayout from '@/layouts/AppLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')).then((module) => {
            const page = module.default;
            if (!page.layout) {
                page.layout = AppLayout;
            }
            return module;
        }),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });
        const pinia = createPinia();

        vueApp.use(pinia);
        vueApp.use(plugin);
        vueApp.use(ZiggyVue); // ✅ دمج Ziggy
        vueApp.mount(el);
    },
});
