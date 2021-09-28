<template>
    <Table
        :items="invoices"
        :headers="invoiceHeaders"
    >
        <template #company_name="{item}">
            <Url
                :href="route('admin.invoices.releases.show', item)"
                class="link-info"
            >
                {{ item.company_name }}
            </Url>
        </template>
    </Table>
</template>
<script>
import Url from '@/Shared/Url';
import Table from '@/Shared/Table';

export default {
    components: {
        Url,
        Table,
    },
    props: {
        invoices: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            invoiceHeaders: [
                {key: 'company_name', name: this.trans('@company.company_name')},
                {key: 'contact_email', name: this.trans('@company.contact_email')},
            ],
        };
    }
};
</script>