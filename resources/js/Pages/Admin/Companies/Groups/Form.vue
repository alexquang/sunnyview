<template>
    <form @submit.prevent="submit">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row gy-3">
                    <Input
                        v-model="form.company.group.name"
                        :label="trans('@company.group.name')"
                        :error="form.errors['company.group.name']"
                        type="text"
                        required
                        autofocus
                    />
                    <Input
                        v-model="form.company.group.description"
                        :label="trans('@company.group.description')"
                        :error="form.errors['company.group.description']"
                        type="textarea"
                        rows="5"
                    />
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
        group: {
            type: Object,
            required: true,
        },
        company: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(
                _.set({}, 'company.group', _.pick(this.group, [
                    'name',
                    'description',
                ]))
            ),
        };
    },
    methods: {
        submit() {
            this.group.id
                ? this.form.put(this.route('admin.companies.groups.update', {company: this.company, group: this.group}))
                : this.form.post(this.route('admin.companies.groups.store', this.company));
        },
    }
};
</script>
