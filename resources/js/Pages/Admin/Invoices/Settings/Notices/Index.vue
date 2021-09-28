<template>
    <div class="row gy-3">
        <IMessage />

        <form @submit.prevent="submit">
            <Table
                :items="settings"
                :headers="settingHeaders"
            >
                <template #company="{item}">
                    <div>{{ item.company_name }}</div>
                    <small class="text-muted">
                        {{ item.contact_email }}
                    </small>
                </template>
                <template #account="{item}">
                    <div>{{ item.account_id }}</div>
                    <small class="text-muted">
                        {{ item.account_name }}
                    </small>
                </template>
                <template #actions="{item}">
                    <Input
                        v-model="form.settings[item.id].is_notifiable"
                        type="checkbox"
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
import Table from '@/Shared/Table';
import Input from '@/Shared/Forms/Input';
import IMessage from '@/Shared/IMessage';

export default {
    components: {
        Table,
        Input,
        IMessage,
    },
    props: {
        settings: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                settings: _.transform(this.settings, (r, v) => {
                    r[v.id] = {
                        company_id: v.id,
                        is_notifiable: v.is_notifiable? v.is_notifiable: false,
                    };
                }, {})
            }),
            settingHeaders: [
                {key: 'company', name: this.trans('labels.company'), sort: 'contact_name'},
                {key: 'account', name: this.trans('@aws.account.account_id'), sort: 'aws_usage_account_id'},
            ],
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('admin.invoices.settings.notices.update'));
        }
    }
};
</script>
