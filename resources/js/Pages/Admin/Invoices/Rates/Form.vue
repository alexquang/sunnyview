<template>
    <div class="row gy-3">
        <form @submit.prevent="submit">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row gy-3">
                        <Input
                            v-model="form.invoice.rate.ym"
                            type="month"
                            :label="trans('@invoice.rate.ym')"
                            :error="form.errors['invoice.rate.ym']"
                            :readonly="rate.ym"
                            required
                        />
                        <Input
                            v-model="form.invoice.rate.value"
                            type="text"
                            :label="trans('@invoice.rate.value')"
                            :error="form.errors['invoice.rate.value']"
                            placeholder="123.45"
                            required
                        />
                        <Input
                            v-model="form.invoice.rate.description"
                            type="textarea"
                            :label="trans('labels.description')"
                            :error="form.errors['invoice.rate.description']"
                            rows="5"
                        />
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button
                    class="btn btn-primary"
                    type="submit"
                    :disabled="!form.isDirty || form.processing"
                >
                    {{ trans('labels.save') }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    props: {
        rate: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(
                _.set({}, 'invoice.rate', _.pick(this.rate, [
                    'ym',
                    'value',
                    'description',
                ]))
            ),
        };
    },
    methods: {
        submit() {
            this.rate.id
                ? this.form.put(this.route('admin.invoices.rates.update', this.rate.id))
                : this.form.post(this.route('admin.invoices.rates.store'));
        },
    }
};
</script>