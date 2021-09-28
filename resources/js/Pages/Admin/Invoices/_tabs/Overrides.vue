<template>
    <Tabs
        :invoice="invoice"
        :name="name"
    >
        <template #[name]>
            <Overrides v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Overrides from '../Overrides/Index';

export default {
    components: {
        Tabs,
        Overrides,
    },
    props: {
        invoice: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            name: 'invoice_overrides',
        };
    },
};
</script>