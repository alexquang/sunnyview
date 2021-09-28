<template>
    <Tabs
        :company="company"
        :name="name"
    >
        <template #[name]>
            <Users v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Users from '../Users/Index';

export default {
    components: {
        Tabs,
        Users,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        users: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            name: 'company_users',
        };
    },
};
</script>