<template>
    <div class="wrapper">
        <h1 class="mbs-30">
            {{ trans(`routes.${route().current()}`) }}
            <i
                class="fas fa-question-circle mls-10"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                :data-bs-original-title="tooltip"
                :aria-label="tooltip"
            />
        </h1>
        <div class="container-common">
            Dashboard
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    data() {
        return {
            tooltip: 'AWSアカウントの料金や利用状況を確認することができます。',
        };
    },
};
</script>
