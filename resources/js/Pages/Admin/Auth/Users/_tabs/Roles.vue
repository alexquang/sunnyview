<template>
    <Tabs
        :user="user"
        :name="name"
    >
        <template #[name]>
            <Roles v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Roles from '../Roles/Index';

export default {
    components: {
        Tabs,
        Roles,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        attachRoles: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            name: 'user_roles',
        };
    },
};
</script>