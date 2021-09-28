<template>
    <form @submit.prevent="submit">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row gy-3">
                    <Input
                        v-model="form.auth.role.name"
                        :label="trans('@auth.role.name')"
                        :error="form.errors['auth.role.name']"
                        type="text"
                        required
                        autofocus
                    />
                    <Input
                        v-model="form.auth.role.description"
                        :label="trans('@auth.role.description')"
                        :error="form.errors['auth.role.description']"
                        type="textarea"
                        rows="5"
                    />
                    <div>
                        <Input
                            v-model="form.auth.role.is_enabled"
                            :label="trans('@auth.role.is_enabled')"
                            type="switch"
                            class="d-inline-block me-2"
                        />
                        <Input
                            v-model="form.auth.role.is_published"
                            :label="trans('@auth.role.is_published')"
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
        role: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(
                _.set({}, 'auth.role', _.pick(this.role, [
                    'name',
                    'description',
                    'is_enabled',
                    'is_published',
                ]))
            ),
        };
    },
    methods: {
        submit() {
            this.form.put(this.route('admin.auth.roles.update', this.role));
        },
    }
};
</script>
