<template>
    <Table
        :headers="roleHeaders"
        :items="roles"
    >
        <template #name="{item}">
            <Url
                :href="route('admin.auth.roles.show', item)"
                class="link-info"
            >
                {{ item.name }}
            </Url>
        </template>
        <template #is_enabled="{item}">
            <Input
                v-model="form.roles[item.id].is_enabled"
                :value="item.is_enabled"
                type="switch"
                disabled
            />
        </template>
        <template #is_published="{item}">
            <Input
                v-model="form.roles[item.id].is_published"
                :value="item.is_published"
                type="switch"
                disabled
            />
        </template>
    </Table>
</template>

<script>
import Url from '@/Shared/Url';
import Input from '@/Shared/Forms/Input';
import Table from '@/Shared/Table';

export default {
    components: {
        Url,
        Input,
        Table,
    },
    props: {
        roles: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                roles: _.transform(this.roles, (r, v) => {
                    r[v.id] = {
                        is_enabled: v.is_enabled,
                        is_published: v.is_published,
                    };
                }, {})
            }),
            roleHeaders: [
                {key: 'name', name: this.trans('@auth.role.name'), sort: true},
                {key: 'users_count', name: this.trans('@auth.role.users_count'), sort: true},
                {key: 'is_enabled', name: this.trans('@auth.role.is_enabled')},
                {key: 'is_published', name: this.trans('@auth.role.is_published')},
                {key: 'description', name: this.trans('@auth.role.description')},
            ],
        };
    },
};
</script>
