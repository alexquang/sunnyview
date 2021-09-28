<template>
    <div class="container-sidebar">
        <div class="info__user--sidebar">
            <div class="info__user d-flex align-items-center mbs-5">
                <i class="fas fa-user-circle mrs-10 font-20" />
                <span class="fw-bold">{{ $page.props.user.email }}</span>
            </div>
            <div
                v-if="$page.props.user.company"
                class="user--id"
            >
                AWSアカウント：{{ $page.props.user.company.aws_usage_account_id }}
            </div>
            <div class="pro__plan--user mts-20 d-flex align-items-center">
                <button class="btn--pro__plan">
                    プロフェッショナル
                </button>
                <a
                    v-if="!$page.props.user.sysadmin"
                    href="/plan"
                    class="btns btn-links h-20 font-12 mls-45"
                >
                    プラン変更
                </a>
            </div>
        </div>

        <nav class="nav__sidebar h-100 user-select-none">
            <ul class="list__item--sidebar ps-0 mb-0">
                <li
                    v-for="navItem in $page.props.navigations"
                    :key="navItem.id"
                    class="list-item"
                    :class="{'link-active': navItem.subs.length == 0 && route().current().startsWith(navItem.group)}"
                >
                    <Link
                        v-if="navItem.link"
                        class="d-flex"
                        :href="route(navItem.link)"
                    >
                        <div class="d-flex align-items-center width-20 mrs-10 font-20">
                            <i
                                class="fa-fw"
                                :class="navItem.icon"
                            />
                        </div>
                        <span class="fw-bold d-inline-flex align-items-center">
                            {{ trans(navItem.name) }}
                        </span>
                    </Link>

                    <a
                        v-else
                        class="d-flex"
                        role="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="`#submenu-${navItem.id}`"
                        :aria-expanded="route().current().startsWith(navItem.group)"
                        :aria-controls="`#submenu-${navItem.id}`"
                    >
                        <div class="d-flex align-items-center width-20 mrs-10 font-20">
                            <i
                                class="fa-fw"
                                :class="navItem.icon"
                            />
                        </div>
                        <span class="fw-bold">
                            {{ trans(navItem.name) }}
                        </span>
                    </a>
                    <div
                        v-if="navItem.subs.length"
                        :id="`submenu-${navItem.id}`"
                        class="collapse"
                        :class="{'show': route().current().startsWith(navItem.group)}"
                        :show="true"
                    >
                        <div class="sub-side-bar">
                            <ul class="ps-0">
                                <li
                                    v-for="navSubItem in navItem.subs"
                                    :key="navSubItem.id"
                                >
                                    <Link
                                        :href="route(navSubItem.link)"
                                        class="d-flex pls-35"
                                        :class="{'link-active': route().current().startsWith(navSubItem.group)}"
                                    >
                                        <span class="fw-bold">
                                            {{ trans(navSubItem.name) }}
                                        </span>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="resize-sidebar font-20 text-right">
            <i class="fas fa-angle-double-right" />
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },
};
</script>

<style lang="scss" scoped>
.list__item--sidebar .list-item {
    position: relative;
}

a[data-bs-target^="#submenu-"] {
    &[aria-expanded="true"]:after {
        transform: rotate(90deg);
        transition: all 0.3s ease;
    }
    &:after {
        font-family: "Font Awesome 5 Free";
        -webkit-font-smoothing: antialiased;
        content: "\f105";
        position: absolute;
        right: 20px;
        font-weight: 900;
        // font-style: normal;
        // font-variant: normal;
        // text-rendering: auto;
        font-size: 20px;
        transition: all 0.3s ease;
    }
}
</style>