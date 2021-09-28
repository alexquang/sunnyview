<template>
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="row gy-3">
                <Input
                    :value="invoice.company_name"
                    :label="trans('@company.company_name')"
                    type="text"
                    readonly
                />
                <Input
                    :value="invoice.contact_email"
                    :label="trans('@company.contact_email')"
                    type="text"
                    readonly
                />
            </div>
        </div>
    </div>
</template>

<script>
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    props: {
        invoice: {
            type: Object,
            required: true,
        },
    },
};
</script>
