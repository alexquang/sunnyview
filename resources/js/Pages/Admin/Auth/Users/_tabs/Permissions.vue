<template>
    <Tabs
        :user="user"
        :name="name"
    >
        <template #[name]>
            <Permissions v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Permissions from '../Permissions/Index';

export default {
    components: {
        Tabs,
        Permissions,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        attachPermissions: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            name: 'user_permissions',
        };
    },
};
</script>