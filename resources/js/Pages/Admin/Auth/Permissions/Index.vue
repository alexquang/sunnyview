<template>
    <Table
        :items="permissions"
        :headers="permissonHeaders"
    >
        <template #is_premium_feature="{item}">
            <Input
                v-model="form.permissions[item.id].is_premium_feature"
                type="switch"
                :value="item.is_premium_feature"
                disabled
            />
        </template>
        <template #is_developer_feature="{item}">
            <Input
                v-model="form.permissions[item.id].is_developer_feature"
                type="switch"
                :value="item.is_developer_feature"
                disabled
            />
        </template>
        <template #is_enabled="{item}">
            <Input
                v-model="form.permissions[item.id].is_enabled"
                type="switch"
                :value="item.is_enabled"
                disabled
            />
        </template>
    </Table>
</template>


<script>
import Input from '@/Shared/Forms/Input';
import Table from '@/Shared/Table';

export default {
    components: {
        Input,
        Table,
    },
    props: {
        permissions: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                permissions: _.transform(this.permissions, (r, v) => {
                    r[v.id] = {
                        is_enabled: v.is_enabled,
                        is_premium_feature: v.is_premium_feature,
                        is_developer_feature: v.is_developer_feature,
                    };
                }, {})
            }),
            permissonHeaders: [
                {key: 'name', name: this.trans('@auth.permission.name'), sort: true},
                {key: 'is_premium_feature', name: this.trans('@auth.permission.is_premium_feature')},
                {key: 'is_developer_feature', name: this.trans('@auth.permission.is_developer_feature')},
                {key: 'is_enabled', name: this.trans('@auth.permission.is_enabled')},
                {key: 'description', name: this.trans('@auth.permission.description')},
            ],
        };
    },
};
</script>
