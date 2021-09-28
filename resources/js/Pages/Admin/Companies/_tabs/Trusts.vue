<template>
    <Tabs
        :company="company"
        :name="name"
    >
        <template #[name]>
            <Trusts v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Trusts from '../Trusts/Index';

export default {
    components: {
        Tabs,
        Trusts,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            name: 'company_trusts',
        };
    },
};
</script>