<template>
    <Tabs
        :company="company"
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
        company: {
            type: Object,
            required: true,
        },
        paydayOptions: {
            type: Array,
            required: true,
        },
        deliveryOptions: {
            type: Array,
            required: true,
        },
        invoiceTypeOptions: {
            type: Array,
            required: true,
        },
        invoiceDateOptions: {
            type: Array,
            required: true,
        },
        creditCardIssuer: {
            type: Array,
            required: true,
        },
        bankAccountOptions: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            name: 'company_info',
        };
    },
};
</script>