<template>
    <Tabs
        :company="company"
        :name="name"
    >
        <template #[name]>
            <Settings v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Settings from '../Settings/Index';

export default {
    components: {
        Tabs,
        Settings,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        settings: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            name: 'company_settings',
        };
    },
};
</script>