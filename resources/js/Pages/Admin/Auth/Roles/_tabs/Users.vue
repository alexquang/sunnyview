<template>
    <Tabs
        :role="role"
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
        role: {
            type: Object,
            required: true,
        },
        assignedUsers: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            name: 'role_users',
        };
    },
};
</script>