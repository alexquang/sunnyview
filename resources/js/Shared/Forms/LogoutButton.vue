<template>
    <form
        v-if="$page.props.user"
        @submit.prevent="submit"
    >
        <button
            type="submit"
            :disabled="form.processing"
            v-bind="$attrs"
        >
            <slot>
                {{ trans('@auth.user._labels.logout') }}
            </slot>
        </button>
    </form>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        action: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(),
        };
    },
    methods: {
        submit() {
            this.form.post(this.route(this.action));
        }
    }
};
</script>
