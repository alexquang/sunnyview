<template>
    <div class="row gy-3">
        <IMessage />
        <div>
            <Url
                :href="route('admin.auth.users.create')"
                class="btn btn-primary"
            >
                {{ trans('labels.signup') }}
            </Url>
        </div>

        <Table
            :items="users"
            :headers="userHeaders"
        >
            <template #is_enabled="{item}">
                <Input
                    v-model="form.users[item.id].is_enabled"
                    :value="item.is_enabled"
                    type="switch"
                    disabled
                />
            </template>
            <template #actions="{item}">
                <Url
                    :href="route('admin.auth.users.show', item)"
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
                        identifier: `${trans('labels.user')}「${trans('labels.email')}: ${itemBeingDeleted.email}」`,
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
import Input from '@/Shared/Forms/Input';
import IMessage from '@/Shared/IMessage';
import Modal from '@/Shared/Modals/Modal';

export default {
    components: {
        Url,
        Table,
        Input,
        IMessage,
        Modal
    },
    props: {
        users: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                users: _.transform(this.users, (r, v) => {
                    r[v.id] = {
                        is_enabled: v.is_enabled,
                    };
                }, {})
            }),
            userHeaders: [
                {key: 'name', name: this.trans('@auth.user.name'), sort: true},
                {key: 'email', name: this.trans('@auth.user.email')},
                {key: 'is_enabled', name: this.trans('@auth.user.is_enabled')},
                {key: 'last_logged_in_at', name: this.trans('@auth.user.last_logged_in_at')},
            ],
            itemBeingDeleted: null,
        };
    },
    methods: {
        confirmDelete() {
            this.form.delete(this.route('admin.auth.users.destroy', this.itemBeingDeleted), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModalDelete.hide();
                }
            });
        }
    }
};
</script>
