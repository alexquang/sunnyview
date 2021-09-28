<template>
    <div class="row gy-3">
        <IMessage />
        <TabGroup id="company">
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
        company: {
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
                    name: 'company_info',
                    label: this.trans('labels.info'),
                    href: this.route('admin.companies.show', this.company)
                },
                {
                    name: 'company_trusts',
                    label: this.trans('@company._labels.trust'),
                    href: this.route('admin.companies.trusts.index', this.company)
                },
                {
                    name: 'company_groups',
                    label: this.trans('labels.group'),
                    href: this.route('admin.companies.groups.index', this.company)
                },
                {
                    name: 'company_users',
                    label: this.trans('labels.user'),
                    href: this.route('admin.companies.users.index', this.company)
                },
                {
                    name: 'company_contracts',
                    label: this.trans('@company._labels.contract'),
                    href: this.route('admin.companies.contracts.index', this.company)
                },
                {
                    name: 'company_settings',
                    label: this.trans('labels.setting'),
                    href: this.route('admin.companies.settings.index', this.company)
                },
            ],
        };
    },
};
</script>