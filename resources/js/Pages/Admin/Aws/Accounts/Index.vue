<template>
    <div class="row gy-3">
        <IMessage />
        <div class="d-flex justify-content-between align-items-center">
            <!-- <Input
                type="select"
                :options="filters.resellerOptions"
            /> -->
            <Url
                :href="route('admin.aws.accounts.create')"
                class="btn btn-primary d-inline-flex align-items-center"
            >
                {{ trans('labels.signup') }}
            </Url>
        </div>
        <Table
            :items="accounts"
            :headers="accountHeaders"
        >
            <template #s3_bucket="{item}">
                <div>DBR: {{ item.s3_bucket_dbr || trans('messages.undefined') }}</div>
                <div>CUR: {{ item.s3_bucket_cur || trans('messages.undefined') }}</div>
            </template>
            <template #actions="{item}">
                <Url
                    :href="route('admin.aws.accounts.edit', item)"
                    class="btn btn-primary btn-sm me-1"
                >
                    {{ trans('labels.modify') }}
                </Url>
                <button
                    class="btn btn-danger btn-sm me-1"
                    type="button"
                    @click="itemBeingDeleted = item"
                >
                    {{ trans('labels.delete') }}
                </button>
            </template>
        </Table>
        <Modal
            ref="bsModalDelete"
            :show="!!itemBeingDeleted"
            :processing="form.processing"
            @close="itemBeingDeleted = null"
        >
            <template #header>
                {{ trans('labels.confirm_delete') }}
            </template>
            <template #body>
                <div
                    v-if="itemBeingDeleted"
                    v-html="trans('messages.confirm_delete', {
                        identifier: `${trans('labels.account')}「ID: ${itemBeingDeleted.account_id}」`,
                    })"
                />
            </template>
            <template #footer>
                <button
                    type="button"
                    class="btn btn-danger"
                    :disabled="form.processing"
                    @click="confirmDelete()"
                >
                    {{ trans('labels.delete') }}
                </button>
            </template>
        </Modal>
    </div>
</template>

<script>
import Url from '@/Shared/Url';
// import Input from '@/Shared/Forms/Input';
import Table from '@/Shared/Table';
import IMessage from '@/Shared/IMessage';
import Modal from '@/Shared/Modals/Modal';

export default {
    components: {
        Url,
        // Input,
        Table,
        IMessage,
        Modal
    },
    props: {
        accounts: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(),
            accountHeaders: [
                {key: 'account_id', name: this.trans('labels.account'), sort: true},
                {key: 'iam_role_name', name: this.trans('@aws.account.iam_role_name'), sort: true},
                {key: 's3_bucket', name: this.trans('@aws.account._labels.s3_bucket'), sort: true},
                // {key: 's3_bucker', name: this.trans('@aws.account.s3_bucket_cur'), sort: true},
                {key: 'is_reseller', name: this.trans('@aws.account.is_reseller'), sort: true},
            ],
            // filters: {
            //     resellerOptions: [
            //         {key: '', name: this.trans('labels.all')},
            //         {key: 'reseller_account', name: this.trans('@aws.account._labels.reseller_account')},
            //         {key: 'normal_account', name: this.trans('@aws.account._labels.normal_account')},
            //     ]
            // },
            itemBeingDeleted: null,
        };
    },
    methods: {
        confirmDelete() {
            this.form.delete(this.route('admin.aws.accounts.destroy', this.itemBeingDeleted), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModalDelete.hide();
                }
            });
        }
    }
};
</script>
