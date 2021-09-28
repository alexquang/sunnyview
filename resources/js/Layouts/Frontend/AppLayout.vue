<template>
    <div
        id="main"
        class="container-fluid px-0 main"
    >
        <div id="header">
            <AppTopBar />
        </div>

        <div id="sidebar">
            <AppSideNav />
        </div>

        <div id="content">
            <IMessage />
            <div id="page-content">
                <div id="view-template">
                    <slot />
                </div>
            </div>

            <div id="footer">
                <AppFooter />
            </div>
        </div>
    </div>
</template>

<script>
import AppSideNav from './AppSideNav';
import AppTopBar from './AppTopBar';
import AppFooter from './AppFooter';
import IMessage from '@/Shared/IMessage';

export default {
    components: {
        AppSideNav,
        AppTopBar,
        AppFooter,
        IMessage,
    },
};
</script>

<style>

</style>