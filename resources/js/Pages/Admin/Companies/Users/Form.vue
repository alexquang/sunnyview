<template>
    <form @submit.prevent="submit">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row gy-3">
                    <Input
                        v-model="form.company.user.name"
                        :label="trans('@company.user.name')"
                        :error="form.errors['company.user.name']"
                        type="text"
                        required
                        autofocus
                    />
                    <Input
                        v-model="form.company.user.email"
                        :label="trans('@company.user.email')"
                        :error="form.errors['company.user.email']"
                        type="email"
                        required
                    />
                    <Input
                        v-if="!user.id"
                        v-model="form.company.user.password"
                        :label="trans('@company.user.password')"
                        :error="form.errors['company.user.password']"
                        type="password"
                        required
                    />
                    <Input
                        v-if="!user.id"
                        v-model="form.company.user.password_confirmation"
                        :label="trans('@company.user.password_confirmation')"
                        :error="form.errors['company.user.password_confirmation']"
                        type="password"
                        required
                    />
                    <Input
                        v-model="form.company.user.group_id"
                        :options="groupOpts"
                        :label="trans('@company.user.group_id')"
                        :error="form.errors['company.user.group_id']"
                        :value="form.company.user.group_id"
                        type="select"
                        required
                    />
                    <div>
                        <Input
                            v-for="role in roles"
                            :key="role.id"
                            v-model="form.roleIds"
                            :label="trans(`@auth.role._labels.${role.name}`)"
                            :value="role.id"
                            type="switch"
                            class="d-inline-block me-2"
                        />
                    </div>
                    <div>
                        <Input
                            v-model="form.company.user.is_enabled"
                            :label="trans('@company.user._labels.is_enabled')"
                            type="switch"
                            class="d-inline-block me-2"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
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

export default {
    components: {
        Input,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        },
        groups: {
            type: Array,
            required: true,
        },
        roles: {
            type: Array,
            required: true,
        },
        attachedRoles: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                company: {
                    user: _.pick(this.user, [
                        'name',
                        'email',
                        'password',
                        'password_confirmation',
                        'group_id',
                        'is_enabled',
                    ])
                },
                roleIds: this.attachedRoles.map(role => role.id)
            }),
            groupOpts: this.groups.map(group => {
                return {
                    key: group.id,
                    name: group.name,
                };
            })
        };
    },
    methods: {
        submit() {
            this.user.id
                ? this.form.put(this.route('admin.companies.users.update', {company: this.company, user: this.user}))
                : this.form.post(this.route('admin.companies.users.store', this.company));
        },
    }
};
</script>
