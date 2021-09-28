require('./bootstrap');

import { createApp, h, defineAsyncComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

// import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue';
import { ZiggyVue } from 'ziggyvue';
import { Ziggy } from './ziggy-frontend';

import i18n from './Plugins/i18n';
import { Translations } from './i18n';
import { Tooltip } from 'bootstrap';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => import(`./Pages/${name}`).then(({ default: page }) => {
        if (page.layout === undefined && !['Frontend/Auth/Login', 'Frontend/Auth/LoginConfirm'].includes(name)) {
            page.layout = defineAsyncComponent(() => import('./Layouts/Frontend/AppLayout'));
        }

        return page;
    }),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .mixin({
                mounted: () => {
                    const tooltipTriggerList = [].slice.call(
                        window.document.querySelectorAll(
                            '[data-bs-toggle="tooltip"]'
                        )
                    );
                    const tooltipList = tooltipTriggerList.map(
                        tooltipTriggerEl => new Tooltip(tooltipTriggerEl)
                    );
                },
            })
            .use(ZiggyVue, Ziggy)
            .use(i18n, Translations)
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#0D5DAA' });
