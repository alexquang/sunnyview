<template>
    <Tabs
        :role="role"
        :name="name"
    >
        <template #[name]>
            <Form v-bind="$props" />
        </template>
    </Tabs>
</template>

<script>
import Tabs from './Tabs';
import Form from '../Form';

export default {
    components: {
        Tabs,
        Form,
    },
    props: {
        role: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            name: 'role_info',
        };
    },
};
</script>