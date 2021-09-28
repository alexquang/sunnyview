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
        invoice: {
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
                    name: 'invoice_info',
                    label: this.trans('labels.info'),
                    href: this.route('admin.invoices.releases.show', this.invoice)
                },
                {
                    name: 'invoice_overrides',
                    label: this.trans('labels.manual'),
                    href: this.route('admin.invoices.releases.overrides.index', this.invoice)
                },
                {
                    name: 'invoice_fees',
                    label: this.trans('routes.admin.invoices.releases.fees.index'),
                    href: this.route('admin.invoices.releases.fees.index', this.invoice)
                },
            ],
        };
    },
};
</script>

<style>

</style>