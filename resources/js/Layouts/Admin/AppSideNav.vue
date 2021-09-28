<template>
    <nav
        id="sidebarMenu"
        class="sidebar d-lg-block bg-gray-800 text-white collapse"
        data-simplebar
    >
        <div class="sidebar-inner px-4 pt-3 user-select-none">
            <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
                <div class="d-flex align-items-center">
                    <div class="d-block">
                        <h2 class="h5 mb-3">
                            {{ $page.props.user.email }}
                        </h2>
                        <LogoutButton
                            action="admin.logout"
                            class="btn btn-secondary btn-sm d-inline-flex align-items-center"
                        >
                            <svg
                                class="icon icon-xxs me-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            ><path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            /></svg>
                            {{ trans('@auth.user._labels.logout') }}
                        </LogoutButton>
                    </div>
                </div>
                <div class="collapse-close d-md-none">
                    <a
                        href="#sidebarMenu"
                        data-bs-toggle="collapse"
                        data-bs-target="#sidebarMenu"
                        aria-controls="sidebarMenu"
                        aria-expanded="true"
                        aria-label="Toggle navigation"
                    >
                        <svg
                            class="icon icon-xs"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        ><path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        /></svg>
                    </a>
                </div>
            </div>
            <ul class="nav flex-column pt-3 pt-md-0">
                <li
                    v-for="navItem in $page.props.navigations"
                    :key="navItem.id"
                    class="nav-item"
                    :class="{'active': navItem.subs.length == 0 && route().current().startsWith(navItem.group)}"
                >
                    <template v-if="navItem.subs.length">
                        <span
                            class="nav-link d-flex justify-content-between align-items-center"
                            :aria-expanded="route().current().startsWith(navItem.group)"
                            data-bs-toggle="collapse"
                            :data-bs-target="`#submenu-${navItem.id}`"
                        >
                            <span>
                                <span
                                    class="sidebar-icon"
                                    v-html="icons[navItem.icon]"
                                />
                                <span class="sidebar-text">{{ trans(navItem.name) }}</span>
                            </span>
                            <span class="link-arrow">
                                <svg
                                    class="icon icon-sm"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </span>
                        <div
                            :id="`submenu-${navItem.id}`"
                            class="multi-level collapse"
                            :class="{'show': route().current().startsWith(navItem.group)}"
                            role="list"
                            aria-expanded="false"
                        >
                            <ul class="flex-column nav">
                                <li
                                    v-for="navSubItem in navItem.subs"
                                    :key="navSubItem.id"
                                    class="nav-item"
                                    :class="{'active': route().current().startsWith(navSubItem.group)}"
                                >
                                    <Link
                                        class="nav-link d-flex justify-content-between"
                                        :href="route(navSubItem.link)"
                                    >
                                        <span class="sidebar-text">{{ trans(navSubItem.name) }}</span>
                                        <span v-if="navSubItem.is_dev_feature"><span class="badge badge-md bg-secondary ms-1 text-gray-800">Dev</span></span>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </template>
                    <template v-else>
                        <Link
                            :href="route(navItem.link)"
                            class="nav-link d-flex justify-content-between"
                        >
                            <span>
                                <span
                                    class="sidebar-icon"
                                    v-html="icons[navItem.icon]"
                                />
                                <span class="sidebar-text">{{ trans(navItem.name) }}</span>
                            </span>
                            <span v-if="navItem.is_dev_feature"><span class="badge badge-md bg-secondary ms-1 text-gray-800">Dev</span></span>
                        </Link>
                    </template>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import LogoutButton from '@/Shared/Forms/LogoutButton';

export default {
    components: {
        Link,
        LogoutButton
    },
    data() {
        return {
            icons: {
                'chart-pie': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                    </svg>
                `,
                'template': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                `,
                'finger-print': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.625 2.655A9 9 0 0119 11a1 1 0 11-2 0 7 7 0 00-9.625-6.492 1 1 0 11-.75-1.853zM4.662 4.959A1 1 0 014.75 6.37 6.97 6.97 0 003 11a1 1 0 11-2 0 8.97 8.97 0 012.25-5.953 1 1 0 011.412-.088z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M5 11a5 5 0 1110 0 1 1 0 11-2 0 3 3 0 10-6 0c0 1.677-.345 3.276-.968 4.729a1 1 0 11-1.838-.789A9.964 9.964 0 005 11zm8.921 2.012a1 1 0 01.831 1.145 19.86 19.86 0 01-.545 2.436 1 1 0 11-1.92-.558c.207-.713.371-1.445.49-2.192a1 1 0 011.144-.83z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M10 10a1 1 0 011 1c0 2.236-.46 4.368-1.29 6.304a1 1 0 01-1.838-.789A13.952 13.952 0 009 11a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                `,
                // 'shield-check': `
                //     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                //         <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                //     </svg>
                // `,
                'server': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                    </svg>
                `,
                'cloud': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
                    </svg>
                `,
                'user-group': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                `,
                // 'document-report': `
                //     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                //         <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd" />
                //     </svg>
                // `,
                'receipt-tax': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                    </svg>
                `,
                'support': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd" />
                    </svg>
                `
            },
        };
    },
};
</script>