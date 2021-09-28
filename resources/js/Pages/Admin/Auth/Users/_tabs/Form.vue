<template>
    <Tabs
        :user="user"
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
        user: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            name: 'user_info',
        };
    },
};
</script>