import "./bootstrap";
import "../css/app.css";

import { createApp, h, defineAsyncComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from 'ziggy-js/dist/vue.m';

// Inisialisasi Dark Mode
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
} else {
    document.documentElement.classList.remove('dark')
}

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: false })
        return pages[`./Pages/${name}.vue`]()
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        
        // Lazy load heavy components
        app.component('UserManagement', defineAsyncComponent(() => 
            import('./Pages/Users/Index.vue')
        ));
        app.component('RoleManagement', defineAsyncComponent(() => 
            import('./Pages/Roles/Index.vue')
        ));
        app.component('ProfileSettings', defineAsyncComponent(() => 
            import('./Pages/Profile/Edit.vue')
        ));

        app.use(plugin);
        app.use(ZiggyVue);
        
        return app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
