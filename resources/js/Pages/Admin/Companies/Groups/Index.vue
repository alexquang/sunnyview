<template>
    <div class="row gy-3">
        <div>
            <Url
                :href="route('admin.companies.groups.create', company)"
                class="btn btn-primary d-inline-flex align-items-center"
            >
                {{ trans('labels.signup') }}
            </Url>
        </div>
        <Table
            :items="groups"
            :headers="groupHeaders"
        >
            <template #actions="{item}">
                <Url
                    :href="route('admin.companies.groups.edit', {company, group: item})"
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
            ref="bsModal"
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
                        identifier: `「${trans('@company.group.name')}: ${itemBeingDeleted.name}」`,
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
import Url from '@/Shared/Url';
import Table from '@/Shared/Table';
import Modal from '@/Shared/Modals/Modal';

export default {
    components: {
        Url,
        Table,
        Modal
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        groups: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(),
            groupHeaders: [
                {key: 'name', name: this.trans('@company.group.name')},
                {key: 'users_count', name: this.trans('@company.group._labels.users_count')},
                {key: 'description', name: this.trans('@company.group.description')},
            ],
            itemBeingDeleted: null,
        };
    },
    methods: {
        confirmDelete: function () {
            this.form.delete(this.route('admin.companies.groups.destroy', {company: this.company, group: this.itemBeingDeleted}), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModal.hide();
                }
            });
        },
    }

};
</script>