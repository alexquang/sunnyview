<template>
    <Tabs
        :invoice="invoice"
        :name="name"
    >
        <template #[name]>
            <Fees v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Fees from '../Fees/Index';

export default {
    components: {
        Tabs,
        Fees,
    },
    props: {
        invoice: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            name: 'invoice_fees',
        };
    },
};
</script>