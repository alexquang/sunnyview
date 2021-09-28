<template>
    <nav
        aria-label="breadcrumb"
        class="d-none d-md-inline-block user-select-none"
    >
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <Url :href="route('admin.dashboard')">
                    {{ trans('routes.admin.home') }}
                </Url>
            </li>
            <li
                v-for="bread in breads"
                :key="bread.uri"
                class="breadcrumb-item"
                aria-current="page"
                :class="{'active': bread.active}"
            >
                <template v-if="bread.active">
                    {{ trans(`routes.${bread.route.name}`) }}
                </template>
                <Url
                    v-else
                    :href="route(bread.route.name, bread.bindings)"
                >
                    {{ trans(`routes.${bread.route.name}`) }}
                </Url>
            </li>
        </ol>
    </nav>
</template>

<script>
import Url from '@/Shared/Url';
export default {
    components: {
        Url
    },
    data() {
        return {
            routesByUri: _(this.route().t.routes).pickBy(function (r) {
                return r.uri.match(/admin\/.+/) && r.methods.includes('GET');
            }).transform(function (r, v, k) {
                r[v.uri] = {
                    uri: v.uri,
                    name: k,
                    bindings: v.bindings,
                };
            }).value(),
        };
    },
    computed: {
        breads() {
            let breads = [];

            let currentRoute = this.route().t.routes[this.route().current()];

            let currentUri = currentRoute.uri;

            breads.push({
                route: this.routesByUri[currentUri],
                active: true,
            });

            do {
                let parentUri = currentUri.replace(/(.+)\/.+$/, '$1');

                let parentRoute = this.routesByUri[parentUri];

                if (parentRoute) {
                    breads.push({
                        route: parentRoute,
                        bindings: this.route().params,
                    });
                }

                currentUri = parentUri;
            } while(currentUri != 'admin');

            return breads.reverse();
        },
    },
};
</script>

<style scoped>
.breadcrumb-item + .breadcrumb-item::before {
    content: var(--bs-breadcrumb-divider, "»");
}
</style>