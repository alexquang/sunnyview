<template>
    <form @submit.prevent="submit">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row gy-3">
                    <Input
                        v-model="form.auth.user.name"
                        :label="trans('@auth.user.name')"
                        :error="form.errors['auth.user.name']"
                        type="text"
                        required
                        autofocus
                    />
                    <Input
                        v-model="form.auth.user.email"
                        :label="trans('@auth.user.email')"
                        :error="form.errors['auth.user.email']"
                        type="email"
                        required
                    />
                    <Input
                        v-if="!user.id"
                        v-model="form.auth.user.password"
                        type="password"
                        :label="trans('@auth.user.password')"
                        :error="form.errors['auth.user.password']"
                        required
                    />
                    <div>
                        <Input
                            v-model="form.auth.user.is_enabled"
                            :label="trans('@auth.user.is_enabled')"
                            type="switch"
                            class="d-inline-block me-2"
                        />
                    </div>
                </div>
            </div>
        </div>
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
</template>

<script>
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(
                _.set({}, 'auth.user', _.pick(this.user, [
                    'name',
                    'email',
                    'password',
                    'is_enabled',
                ])),
            ),
        };
    },
    methods: {
        submit() {
            this.user.id ?
                this.form.put(this.route('admin.auth.users.update', this.user)) :
                this.form.post(this.route('admin.auth.users.store'));
        },
    }
};
</script>
