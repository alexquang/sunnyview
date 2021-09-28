<template>
    <div class="row gy-3">
        <IMessage />
        <TabGroup id="role">
            <AsyncTab
                v-for="tab in tabs"
                :id="tab.name"
                :key="tab.name"
                :name="tab.label"
                :href="tab.href"
                :active="name == tab.name"
            >
                <slot :name="tab.name" />
            </AsyncTab>
        </TabGroup>
    </div>
</template>

<script>
import IMessage from '@/Shared/IMessage';
import TabGroup from '@/Shared/Tabs/TabGroup';
import AsyncTab from '@/Shared/Tabs/AsyncTab';

export default {
    components: {
        IMessage,
        TabGroup,
        AsyncTab,
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            tabs: [
                {
                    name: 'user_info',
                    label: this.trans('labels.info'),
                    href: this.route('admin.auth.users.show', this.user)
                },
                {
                    name: 'user_roles',
                    label: this.trans('labels.role'),
                    href: this.route('admin.auth.users.roles.index', this.user)
                },
                {
                    name: 'user_permissions',
                    label: this.trans('labels.permission'),
                    href: this.route('admin.auth.users.permissions.index', this.user)
                },
            ],
        };
    },
};
</script>

<style>

</style>