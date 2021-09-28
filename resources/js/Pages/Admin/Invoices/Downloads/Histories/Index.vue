<template>
    <Table
        :items="histories"
        :headers="historyHeaders"
    >
        <template #user="{item}">
            <div>{{ item.user_info.name }}</div>
            <small>{{ item.user_info.email }}</small>
        </template>
        <template #company="{item}">
            <div>{{ item.company_info.company_name }}</div>
            <small>{{ item.company_info.contact_email }}</small>
        </template>
    </Table>
</template>
<script>

import Table from '@/Shared/Table';

export default {
    components: {
        Table,
    },
    props: {
        histories: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            historyHeaders: [
                {key: 'ym', name: this.trans('labels.ym'), sort: true},
                {key: 'file_name', name: this.trans('@invoice.download._labels.file_name'), sort: true},
                {key: 'user', name: this.trans('labels.user'), sort: 'user_info.name'},
                {key: 'company', name: this.trans('labels.company'), sort: 'company_info.company_name'},
                {key: 'downloaded_from', name: this.trans('labels.ip'), sort: true},
                {key: 'downloaded_at', name: this.trans('labels.time'), sort: true},
            ],
        };
    },
};
</script>