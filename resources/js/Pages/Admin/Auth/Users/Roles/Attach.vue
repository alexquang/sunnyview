<template>
    <div class="row gy-3">
        <form @submit.prevent="submit">
            <Table
                :items="roles"
                :headers="roleHeaders"
            >
                <template #checkbox="{item}">
                    <Input
                        v-model="form.roleIds"
                        type="checkbox"
                        class="text-center"
                        :value="item.id"
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
        roles: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                roleIds: [],
            }),
            roleHeaders: [
                {key: 'checkbox', name: ''},
                {key: 'name', name: this.trans('@auth.role.name'), sort: true},
                {key: 'description', name: this.trans('@auth.role.description')},
            ],
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('admin.auth.users.roles.attach', this.user));
        }
    }
};
</script>
