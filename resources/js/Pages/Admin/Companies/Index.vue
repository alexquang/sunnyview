<template>
    <div class="row gy-3">
        <IMessage />
        <div>
            <Url
                :href="route('admin.companies.create')"
                class="btn btn-primary"
            >
                {{ trans('labels.signup') }}
            </Url>
        </div>
        <Table
            :items="companies"
            :headers="companyHeaders"
        >
            <template #company_name="{item}">
                <Url
                    :href="route('admin.companies.show', item)"
                    class="link-info"
                >
                    {{ item.company_name }}
                </Url>
            </template>
            <template #actions="{item}">
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
                        identifier: `${trans('labels.company')}「${itemBeingDeleted.company_name}」`,
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
import Table from '@/Shared/Table';
import IMessage from '@/Shared/IMessage';
import Modal from '@/Shared/Modals/Modal';

export default {
    components: {
        Url,
        Table,
        IMessage,
        Modal
    },
    props: {
        companies: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(),
            companyHeaders: [
                {key: 'company_name', name: this.trans('@company.company_name')},
                {key: 'contact_email', name: this.trans('@company.contact_email')},
            ],
            itemBeingDeleted: null,
        };
    },
    methods: {
        confirmDelete() {
            this.form.delete(this.route('admin.companies.destroy', this.itemBeingDeleted), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModalDelete.hide();
                }
            });
        }
    }
};
</script>

<style>

</style>