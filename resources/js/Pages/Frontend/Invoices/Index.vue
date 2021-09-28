<template>
    <div class="wrapper">
        <h1 class="mbs-30">
            {{ trans(`routes.${route().current()}`) }}
            <i
                class="fas fa-question-circle mls-10"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                :data-bs-original-title="tooltip"
                :aria-label="tooltip"
            />
        </h1>
        <div class="container-common">
            <p class="mb-0">
                通常、請求書は末締め翌月5日頃にご用意しております。
            </p>
            <p class="mb-0">
                「▼」をクリックすると昇順・降順の並び替えができます。
            </p>
        </div>
        <div class="row mts-30">
            <Table
                :items="invoices"
                :headers="invoiceHeaders"
            />
        </div>
    </div>
</template>
<script>
import Table from '@/FShared/Table';

export default {
    components: {
        Table
    },
    props: {
        invoices: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            tooltip: '半年前までの請求書をPDFファイルでダウンロードできます。',
            invoiceHeaders: [
                {key: 'ym', name: this.trans('labels.ym'), sort: true},
                {key: 'company_name', name: this.trans('@company.contact_email'), sort: true},
                {key: 'contact_email', name: this.trans('@company.contact_email'), sort: true},
            ],
        };
    }
};
</script>

    <style>

    </style>