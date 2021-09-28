require('./bootstrap');
require('./volt');

import { createApp, h, defineAsyncComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

// import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue';
import { ZiggyVue } from 'ziggyvue';
import { Ziggy } from './ziggy-admin';

import i18n from './Plugins/i18n';
import { Translations } from './i18n';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => import(`./Pages/${name}`).then(({ default: page }) => {
        if (page.layout === undefined && name.startsWith('Admin/') && name != 'Admin/Auth/Login') {
            page.layout = defineAsyncComponent(() => import('./Layouts/Admin/AppLayout'));
        }

        return page;
    }),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(ZiggyVue, Ziggy)
            .use(i18n, Translations)
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#eeb15d' });
