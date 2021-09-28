
<template>
    <a
        :href="href"
        :class="classes"
        v-bind="$attrs"
        @click="handleClick"
    >
        <slot />
    </a>
</template>

<script>
export default {
    props: {
        href: {
            type: String,
            required: true,
        },
        only: {
            type: Array,
            default() {
                return [];
            },
        }
    },
    data() {
        return {
            processing: false,
        };
    },
    computed: {
        classes() {
            if (this.processing) {
                let color = (this.$attrs.class || '').match(/btn/) ? 'disabled' : 'text-gray-400';

                return `pe-none user-select-none ${color}`;
            }

            return null;
        },
    },
    methods: {
        handleClick(e) {
            e.preventDefault();

            this.$inertia.visit(this.href, {
                only: this.only,
                onStart: () => {
                    this.processing = true;
                },
                onFinish: () => {
                    this.processing = false;
                },
            });
        }
    }
};
</script>
<style scoped>
    a.btn:focus {
        box-shadow: none;
    }
</style>