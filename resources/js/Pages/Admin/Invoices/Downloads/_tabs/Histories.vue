<template>
    <Tabs :name="name">
        <template #[name]>
            <Histories v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Histories from '../Histories/Index';

export default {
    components: {
        Tabs,
        Histories,
    },
    props: {
        histories: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            name: 'invoice_downloads_histories',
        };
    },
};
</script>