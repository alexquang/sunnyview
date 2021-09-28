<template>
    <form @submit.prevent="submit">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row gy-3">
                    <template
                        v-for="setting in settings"
                        :key="setting.key"
                    >
                        <Input
                            v-model="form.company.settings[setting.key].value"
                            :label="trans(`@company.settings.${setting.key}.label`)"
                            :error="form.errors[`company.settings.${setting.key}.value`]"
                            :help="trans(`@company.settings.${setting.key}.description`)"
                            type="text"
                            required
                            autofocus
                        />
                    </template>
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
        settings: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            form: this.$inertia.form(
                _.set({}, 'company.settings', _.transform(this.settings, (r, v) => {
                    r[v.key] = {
                        company_id: this.company.id,
                        key: v.key,
                        value: v.value,
                    };
                }, {})),
            )
        };
    },
    methods: {
        submit() {
            this.form.put(this.route('admin.companies.settings.update', this.company));
        },
    }
};
</script>
