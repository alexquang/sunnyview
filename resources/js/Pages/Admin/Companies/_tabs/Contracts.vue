<template>
    <Tabs
        :company="company"
        :name="name"
    >
        <template #[name]>
            <Contracts v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Contracts from '../Contracts/Index';

export default {
    components: {
        Tabs,
        Contracts,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            name: 'company_contracts',
        };
    },
};
</script>