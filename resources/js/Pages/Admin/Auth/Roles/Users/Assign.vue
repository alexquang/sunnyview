<template>
    <form @submit.prevent="submit">
        <div class="row gy-3">
            <Table
                :items="users"
                :headers="userHeaders"
            >
                <template #checkbox="{item}">
                    <Input
                        v-model="form.userIds"
                        type="checkbox"
                        class="text-center"
                        :value="item.id"
                    />
                </template>
            </Table>
            <div>
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing || !form.isDirty"
                >
                    {{ trans('labels.save') }}
                </button>
            </div>
        </div>
    </form>
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
        role: {
            type: Object,
            required: true,
        },
        users: {
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
                {key: 'checkbox', name: ''},
                {key: 'email', name: this.trans('@auth.user.email'), sort: true},
                {key: 'name', name: this.trans('@auth.user.name'), sort: true},
            ],
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('admin.auth.roles.users.assign', this.role));
        }
    }
};
</script>
