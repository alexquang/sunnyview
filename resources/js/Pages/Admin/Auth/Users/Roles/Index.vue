<template>
    <form @submit.prevent="detachRoles">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button
                    type="submit"
                    class="btn btn-secondary d-inline-flex align-items-center"
                    :disabled="formRoles.processing || !formRoles.isDirty"
                >
                    {{ trans('@auth.user._labels.detach_roles') }}
                </button>
            </div>
            <div>
                <Url
                    :href="route('admin.auth.users.roles.attach.form', user)"
                    class="btn btn-primary d-inline-flex align-items-center"
                >
                    {{ trans('@auth.user._labels.attach_roles') }}
                </Url>
            </div>
        </div>
        <Table
            :items="attachRoles"
            :headers="roleHeaders"
            class="mt-3"
        >
            <template #check="{item}">
                <Input
                    v-model="formRoles.roleIds"
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
        attachRoles: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            formRoles: this.$inertia.form({
                roleIds: [],
            }),
            roleHeaders: [
                {key: 'check', name: ''},
                {key: 'name', name: this.trans('@auth.role.name')},
                {key: 'description', name: this.trans('@auth.role.description')},
            ],
        };
    },
    methods: {
        detachRoles() {
            this.formRoles.post(this.route('admin.auth.users.roles.detach', this.user), {
                onSuccess: () => this.formRoles.reset(),
            });
        },
    }
};
</script>
