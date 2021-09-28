<template>
    <Url
        :id="`${id}-tab`"
        :href="href"
        class="nav-item nav-link user-select-none"
        :class="{'active': active == true}"
        role="tab"
    >
        <slot name="name">
            {{ name }}
        </slot>
    </Url>
    <teleport
        v-if="isMounted"
        :to="`#${$parent.id}Content`"
    >
        <div
            :id="id"
            class="tab-pane fade show"
            :class="{'active': active == true}"
            role="tabpanel"
            :aria-labelledby="`${id}-tab`"
        >
            <slot />
        </div>
    </teleport>
</template>

<script>
import Url from '@/Shared/Url';

export default {
    components: {
        Url,
    },
    props: {
        id: {
            type: String,
            required: true,
        },
        href: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            default(props) {
                return props.id;
            },
        },
        active: {
            type: Boolean,
            default: false,
        },
    },
    data: function(){
        return {
            isMounted: false
        };
    },
    mounted(){
        this.isMounted = true;
    }
};
</script>