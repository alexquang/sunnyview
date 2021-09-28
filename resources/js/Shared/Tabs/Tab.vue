<template>
    <a
        :id="`${id}-tab`"
        :href="`#${id}`"
        class="nav-item nav-link user-select-none"
        :class="{'active': active == true}"
        data-bs-toggle="tab"
        role="tab"
        aria-controls="nav-home"
        aria-selected="true"
    >
        <slot name="name">{{ name }}</slot>
    </a>
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
export default {
    props: {
        id: {
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