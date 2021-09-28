<template>
    <Tabs :name="name">
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
        settings: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            name: 'invoice_downloads_settings',
        };
    },
};
</script>