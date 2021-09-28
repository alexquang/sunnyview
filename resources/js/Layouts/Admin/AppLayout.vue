<template>
    <div>
        <Head :title="trans(`routes.${route().current()}`)" />
        <AppNav />
        <AppSideNav />
        <main class="content">
            <AppTopBar />
            <div class="mt-3">
                <AppBread />

                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <header
                        id="header"
                        class="h4"
                    >
                        <slot name="header">
                            <!-- set default page name as header -->
                            {{ trans(`routes.${route().current()}`) }}
                        </slot>
                    </header>
                </div>
            </div>
            <div class="mt-3 mb-4">
                <slot />
            </div>
            <AppFooter />
        </main>
    </div>
</template>

<script>
import AppNav from './AppNav';
import AppBread from './AppBread';
import AppSideNav from './AppSideNav';
import AppTopBar from './AppTopBar';
import AppFooter from './AppFooter';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Head,
        AppNav,
        AppBread,
        AppSideNav,
        AppTopBar,
        AppFooter
    },
    props: {
        // description: {
        //     type: String,
        //     default: '',
        // },
    },

    data() {
        return {

        };
    },
};
</script>
<style scoped>
    #header {
        line-height: 39px;
    }
</style>