<template>
    <Tabs
        :role="role"
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
        role: {
            type: Object,
            required: true,
        },
        attachedPermissions: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            name: 'role_permissions',
        };
    },
};
</script>