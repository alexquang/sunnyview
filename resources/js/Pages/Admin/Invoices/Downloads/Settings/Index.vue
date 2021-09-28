<template>
    <div class="row gy-3">
        <IMessage />

        <form @submit.prevent="submit">
            <Table
                :items="settings"
                :headers="settingHeaders"
            >
                <template #account="{item}">
                    <div>{{ item.aws_usage_account_id }}</div>
                    <small class="text-muted">
                        {{ item.aws_usage_account_name }}
                    </small>
                </template>
                <template #company="{item}">
                    <div>{{ item.company_name }}</div>
                    <small class="text-muted">
                        {{ item.contact_email }}
                    </small>
                </template>
                <template #download_status="{item}">
                    <div v-if="item.download_histories_count > 0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-xs"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </template>
                <template #invoice_delivery_method="{item}">
                    <div v-if="item.invoice_delivery_method == 'post'">
                        郵送
                    </div>
                </template>
                <template #actions="{item}">
                    <Input
                        v-if="item.is_settingable"
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
import IMessage from '@/Shared/IMessage';
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Table,
        IMessage,
        Input,
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
                    r[v.invoice_id] = {
                        invoice_id: v.invoice_id,
                        is_notifiable: v.is_notifiable,
                    };
                }, {})
            }),
            settingHeaders: [
                {key: 'ym', name: this.trans('labels.ym'), sort: true},
                {key: 'account', name: this.trans('@aws.account.account_id'), sort: 'aws_usage_account_id'},
                {key: 'company', name: this.trans('labels.company'), sort: 'company_name'},
                {key: 'download_status', name: this.trans('@invoice.setting.download._labels.download_status'), sort: true},
                {key: 'invoice_delivery_method', name: this.trans('@invoice.setting.download._labels.invoice_delivery_method'), sort: true},
            ],
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('admin.invoices.downloads.settings.update'));
        }
    },
};
</script>
