<template>
    <div class="row gy-3">
        <IMessage />
        <TabGroup id="invoice">
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
        name: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            tabs: [
                {
                    name: 'invoice_downloads_histories',
                    label: this.trans('labels.info'),
                    href: this.route('admin.invoices.downloads.index')
                },
                {
                    name: 'invoice_downloads_settings',
                    label: this.trans('labels.setting'),
                    href: this.route('admin.invoices.downloads.settings.index')
                },
            ],
        };
    },
};
</script>

<style>

</style>