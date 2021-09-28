<template>
    <Tabs
        :company="company"
        :name="name"
    >
        <template #[name]>
            <Groups v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Groups from '../Groups/Index';

export default {
    components: {
        Tabs,
        Groups,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        groups: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            name: 'company_groups',
        };
    },
};
</script>