<template>
    <form @submit.prevent="detach">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button
                    type="submit"
                    class="btn btn-secondary d-inline-flex align-items-center"
                    :disabled="form.processing || !form.isDirty"
                >
                    {{ trans('@auth.role._labels.detach_permissions') }}
                </button>
            </div>
            <div>
                <Url
                    :href="route('admin.auth.roles.permissions.attach.form', role)"
                    class="btn btn-primary d-inline-flex align-items-center"
                >
                    {{ trans('@auth.role._labels.attach_permissions') }}
                </Url>
            </div>
        </div>
        <Table
            :items="attachedPermissions"
            :headers="permissionHeaders"
            class="mt-3"
        >
            <template #check="{item}">
                <Input
                    v-model="form.permissionIds"
                    :value="item.id"
                    type="checkbox"
                    class="text-center"
                />
            </template>
        </Table>
    </form>
</template>

<script>
import Table from '@/Shared/Table';
import Input from '@/Shared/Forms/Input';
import Url from '@/Shared/Url';

export default {
    components: {
        Table,
        Input,
        Url,
    },
    props: {
        role: {
            type: Object,
            required: true,
        },
        attachedPermissions: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                permissionIds: [],
            }),
            permissionHeaders: [
                {key: 'check', name: ''},
                {key: 'name', name: this.trans('@auth.permission.name'), sort: true},
                {key: 'assigned_rule', name: this.trans('@auth.assigned_permission.rule'), sort: true},
                {key: 'assigned_scope', name: this.trans('@auth.assigned_permission.scope')},
            ],
        };
    },
    methods: {
        submit() {
            this.form.put(this.route('admin.auth.roles.update', this.role));
        },
        detach() {
            this.form.post(this.route('admin.auth.roles.permissions.detach', this.role), {
                onSuccess: () => this.form.reset(),
            });
        },
    }
};
</script>
