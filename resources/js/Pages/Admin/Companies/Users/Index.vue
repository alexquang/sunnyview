<template>
    <div class="row gy-3">
        <div>
            <Url
                :href="route('admin.companies.users.create', company)"
                class="btn btn-primary"
            >
                {{ trans('labels.signup') }}
            </Url>
        </div>

        <Table
            :items="users"
            :headers="userHeaders"
        >
            <template #name="{item}">
                <div>{{ item.name }}</div>
                <small class="text-muted">{{ item.email }}</small>
            </template>
            <template #roles="{item}">
                <div
                    v-for="role in item.attached_roles"
                    :key="role"
                >
                    <span class="badge bg-primary me-2 user-select-none">
                        {{ role }}
                    </span><br>
                </div>
            </template>
            <template #is_enabled="{item}">
                <Input
                    type="switch"
                    :checked="item.is_enabled"
                    @click.prevent="itemBeingSwitched = item"
                />
            </template>
            <template #actions="{item}">
                <Url
                    :href="route('admin.companies.users.edit', {company, user: item})"
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
            id="bsModalDelete"
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

        <Modal
            id="bsModalSwitch"
            ref="bsModalSwitch"
            :show="!!itemBeingSwitched"
            :processing="form.processing"
            @close="itemBeingSwitched = null"
        >
            <template #header>
                {{ trans('labels.modify') + trans('labels.confirm') }}
            </template>
            <template #body>
                <div
                    v-if="itemBeingSwitched"
                    v-html="itemBeingSwitched.is_enabled
                        ? trans('messages.confirm_disabled', {
                            identifier: `${trans('labels.user')}「${trans('labels.email')}: ${itemBeingSwitched.email}」`,
                        })
                        : trans('messages.confirm_enabled', {
                            identifier: `${trans('labels.user')}「${trans('labels.email')}: ${itemBeingSwitched.email}」`,
                        })"
                />
            </template>
            <template #footer>
                <button
                    type="button"
                    class="btn btn-warning"
                    :disabled="form.processing"
                    @click="confirmSwitch()"
                >
                    {{ trans('labels.confirm') }}
                </button>
            </template>
        </Modal>
    </div>
</template>

<script>
import Url from '@/Shared/Url';
import Table from '@/Shared/Table';
import Input from '@/Shared/Forms/Input';
import Modal from '@/Shared/Modals/Modal';

export default {
    components: {
        Url,
        Table,
        Input,
        Modal
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        users: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(),
            userHeaders: [
                {key: 'name', name: this.trans('labels.user'), sort: true},
                {key: 'group_info.name', name: this.trans('labels.group'), sort: true},
                {key: 'roles', name: this.trans('labels.role')},
                {key: 'login_failed_count', name: this.trans('@company.user._labels.login_failed_count'), sort: true},
                {key: 'last_logged_in_at', name: this.trans('@company.user._labels.last_logged_in_at')},
                {key: 'is_enabled', name: this.trans('@company.user._labels.is_enabled')},
            ],
            itemBeingDeleted: null,
            itemBeingSwitched: null,
        };
    },
    methods: {
        confirmDelete() {
            this.form.delete(this.route('admin.companies.users.destroy', {company: this.company, user: this.itemBeingDeleted}), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModalDelete.hide();
                }
            });
        },
        confirmSwitch() {
            this.form.post(this.route('admin.companies.users.enabled', {company: this.company, user: this.itemBeingSwitched}), {
                onFinish: () => {
                    this.form.wasSuccessful && this.$refs.bsModalSwitch.hide();
                }
            });
        },
    }
};
</script>
