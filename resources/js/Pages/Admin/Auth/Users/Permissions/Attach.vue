<template>
    <div class="row gy-3">
        <form @submit.prevent="submit">
            <Table
                :items="permissions"
                :headers="permissionHeaders"
            >
                <template #checkbox="{item}">
                    <Input
                        v-model="form.permissions[item.id].selected"
                        type="checkbox"
                        class="text-center"
                        :value="item.id"
                    />
                </template>
                <template #rule="{item}">
                    <Input
                        v-model="form.permissions[item.id].rule"
                        type="select"
                        :options="permissionRuleOptions"
                        :value="item.id"
                        :disabled="!form.permissions[item.id].selected"
                    />
                </template>
            </Table>
            <div class="mt-3">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing || !form.isDirty"
                >
                    {{ trans('labels.save') }}
                </button>
            </div>
        </form>
    </div>
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
        user: {
            type: Object,
            required: true,
        },
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
                        id: v.id,
                        rule: 'allow',
                        selected: false,
                    };
                }, {})
            }),
            permissionHeaders: [
                {key: 'checkbox', name: ''},
                {key: 'name', name: this.trans('@auth.permission.name'), sort: true},
                {key: 'rule', name: this.trans('@auth.assigned_permission.rule')},
            ],
            permissionRuleOptions: [
                {key: 'allow', name: this.trans('@auth.assigned_permission.rule_allow')},
                {key: 'deny', name: this.trans('@auth.assigned_permission.rule_deny')},
            ],
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('admin.auth.users.permissions.attach', this.user));
        }
    }
};
</script>
