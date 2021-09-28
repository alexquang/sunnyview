<template>
    <div v-if="iMessage.posted_at > last_posted_at">
        <div
            :class="theme.classes"
            class="fade show alert-dismissible"
            role="alert"
        >
            {{ iMessage.content }}
            <button
                type="button"
                class="btn-close btn-sm"
                aria-label="Close"
                @click="last_posted_at = iMessage.posted_at"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            last_posted_at: 0,
        };
    },
    computed: {
        iMessage() {
            return this.$page.props.flash.iMessage || {};
        },
        theme() {
            let theme = {};

            switch(this.iMessage.level) {
            case 'success':
                theme.color = 'success';
                break;
            case 'error':
                theme.color = 'danger';
                break;
            case 'warn':
                theme.color = 'warning';
                break;
            case 'info':
                theme.color = 'info';
                break;
            default:
                theme.color = 'primary';
                break;
            }

            theme.classes = `alert alert-${theme.color} mb-0`;

            return theme;
        },
    },
};
</script>
<style scoped>
    .btn-close {
        height: calc(1em + 4px);
    }
</style>