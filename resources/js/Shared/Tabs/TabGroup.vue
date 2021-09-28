<template>
    <div>
        <div
            :id="`${id}`"
            class="nav nav-tabs"
            role="tablist"
        >
            <slot />
        </div>
        <div
            :id="`${id}Content`"
            class="tab-content mt-3"
        />
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            required: true,
        },
    },
};
</script>