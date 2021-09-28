<template>
    <header class="navigation">
        <div class="nav-container">
            <div class="brand logo--header">
                <Link :href="route('frontend.dashboard')">
                    <img
                        src="/images/sunny_logo_new.svg"
                        alt="logo"
                        class="img__logo--header"
                    >
                </Link>
            </div>
            <nav>
                <ul class="nav-list">
                    <li
                        v-for="navItem in $page.props.headers"
                        :key="navItem.id"
                    >
                        <a
                            href="#"
                            data-bs-toggle="dropdown"
                            :data-bs-target="`#submenu-${navItem.id}`"
                            :aria-controls="`#submenu-${navItem.id}`"
                            aria-expanded="false"
                            role="button"
                            class="dropdown-toggle"
                        >
                            <em
                                class="fa-fw mrs-5 font-20"
                                :class="navItem.icon"
                            />
                            <span>{{ trans(navItem.name) }}</span>
                        </a>
                        <ul
                            v-if="navItem.subs.length"
                            class="dropdown-menu py-0"
                            :aria-labelledby="`submenu-${navItem.id}`"
                        >
                            <li
                                v-for="navSubItem in navItem.subs"
                                :key="navSubItem.id"
                            >
                                <LogoutButton
                                    v-if="navSubItem.link == 'frontend.logout'"
                                    action="frontend.logout"
                                    class="dropdown-item h-40"
                                >
                                    <i
                                        class="fa-fw mrs-5"
                                        :class="navSubItem.icon"
                                    />
                                    <span>{{ trans(navSubItem.name) }}</span>
                                </LogoutButton>
                                <component
                                    :is="navSubItem.link.startsWith('frontend.help') ? 'a' : 'Link'"
                                    v-else
                                    class="dropdown-item h-40"
                                    :href="route(navSubItem.link)"
                                >
                                    <i
                                        class="fa-fw mrs-5"
                                        :class="navSubItem.icon"
                                    />
                                    <span>{{ trans(navSubItem.name) }}</span>
                                </component>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import LogoutButton from '@/Shared/Forms/LogoutButton';

export default {
    components: {
        Link,
        LogoutButton
    },
};
</script>
<style lang="scss">
button.dropdown-item {
    padding-left: 20px !important;
    &:hover {
        background-color: #2a7ac7;
        color: #ffffff;
    }
}
</style>