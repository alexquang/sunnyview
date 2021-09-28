<template>
    <form @submit.prevent="detachPermissions">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button
                    type="submit"
                    class="btn btn-secondary d-inline-flex align-items-center"
                    :disabled="formPermissions.processing || !formPermissions.isDirty"
                >
                    {{ trans('@auth.user._labels.detach_permissions') }}
                </button>
            </div>
            <div>
                <Url
                    :href="route('admin.auth.users.permissions.attach.form', user)"
                    class="btn btn-primary d-inline-flex align-items-center"
                >
                    {{ trans('@auth.user._labels.attach_permissions') }}
                </Url>
            </div>
        </div>
        <Table
            :items="attachPermissions"
            :headers="permissionHeaders"
            class="mt-3"
        >
            <template #check="{item}">
                <Input
                    v-model="formPermissions.permissionIds"
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
        user: {
            type: Object,
            required: true,
        },
        attachPermissions: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            formPermissions: this.$inertia.form({
                permissionIds: [],
            }),
            permissionHeaders: [
                {key: 'check', name: ''},
                {key: 'name', name: this.trans('@auth.permission.name')},
                {key: 'assigned_rule', name: this.trans('@auth.assigned_permission.rule')},
                {key: 'assigned_scope', name: this.trans('@auth.assigned_permission.scope')},
            ],
        };
    },
    methods: {
        submit() {
            this.form.put(this.route('admin.auth.users.update', this.user));
        },
        detachPermissions() {
            this.formPermissions.post(this.route('admin.auth.users.permissions.detach', this.user), {
                onSuccess: () => this.formPermissions.reset(),
            });
        },
    }
};
</script>
