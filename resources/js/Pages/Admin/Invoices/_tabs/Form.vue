<template>
    <Tabs
        :invoice="invoice"
        :name="name"
    >
        <template #[name]>
            <Form v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Form from '../Form';

export default {
    components: {
        Tabs,
        Form,
    },
    props: {
        invoice: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            name: 'invoice_info',
        };
    },
};
</script>