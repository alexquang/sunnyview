<template>
    <form @submit.prevent="retract">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button
                    type="submit"
                    class="btn btn-secondary d-inline-flex align-items-center"
                    :disabled="form.processing || !form.isDirty"
                >
                    {{ trans('@auth.role._labels.retract_users') }}
                </button>
            </div>
            <div>
                <Url
                    :href="route('admin.auth.roles.users.assign.form', role)"
                    class="btn btn-primary d-inline-flex align-items-center"
                >
                    {{ trans('@auth.role._labels.assign_users') }}
                </Url>
            </div>
        </div>
        <Table
            :items="assignedUsers"
            :headers="userHeaders"
            class="mt-3"
        >
            <template #check="{item}">
                <Input
                    v-model="form.userIds"
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
        assignedUsers: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                userIds: [],
            }),
            userHeaders: [
                {key: 'check', name: ''},
                {key: 'name', name: this.trans('@auth.user.name'), sort: true},
                {key: 'email', name: this.trans('@auth.user.email'), sort: true},
            ],
        };
    },
    methods: {
        retract() {
            this.form.post(this.route('admin.auth.roles.users.retract', this.role), {
                onSuccess: () => this.form.reset(),
            });
        },
    }
};
</script>
