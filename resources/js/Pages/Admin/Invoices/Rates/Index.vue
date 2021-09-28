<template>
    <div class="row gy-3">
        <IMessage />
        <div>
            <Url
                :href="route('admin.invoices.rates.create')"
                class="btn btn-primary d-inline-flex align-items-center"
            >
                {{ trans('labels.signup') }}
            </Url>
        </div>
        <Table
            :items="rates"
            :headers="rateHeaders"
        >
            <template #value="{item}">
                {{ item.value }} <span>円</span>
            </template>

            <template
                #actions="{item}"
            >
                <Url
                    :href="route('admin.invoices.rates.edit', item.id)"
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
                        identifier: `${trans('labels.rate')}「${trans('labels.ym')}: ${itemBeingDeleted.ym}」`,
                    })"
                />
            </template>
            <template #footer>
                <button
                    class="btn btn-danger"
                    type="button"
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
import Table from '@/Shared/Table';
import Url from '@/Shared/Url';
import IMessage from '@/Shared/IMessage';
import Modal from '@/Shared/Modals/Modal';

export default {
    components: {
        Url,
        Table,
        IMessage,
        Modal,
    },
    props: {
        rates: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(),
            rateHeaders: [
                {key: 'ym', name: this.trans('@invoice.rate.ym'), sort: true},
                {key: 'value', name: this.trans('@invoice.rate.value'), sort: true},
                {key: 'description', name: this.trans('@invoice.rate.description')},
            ],
            itemBeingDeleted: null,
        };
    },
    methods: {
        confirmDelete: function () {
            this.form.delete(this.route('admin.invoices.rates.destroy', this.itemBeingDeleted.id), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModalDelete.hide();
                }
            });
        },
    }
};
</script>