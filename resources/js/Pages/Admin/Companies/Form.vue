<template>
    <form @submit.prevent="submit">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row gy-3">
                    <h4>{{ trans('@company._labels.company_setting') }}</h4>
                    <div class="col-md-6 col-12">
                        <Input
                            v-model="form.company.company_name"
                            :label="trans('@company.company_name')"
                            :error="form.errors['company.company_name']"
                            type="text"
                            required
                            autofocus
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <Input
                            v-model="form.company.department_name"
                            :label="trans('@company.department_name')"
                            :error="form.errors['company.department_name']"
                            type="text"
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <Input
                            v-model="form.company.position_name"
                            :label="trans('@company.position_name')"
                            :error="form.errors['company.position_name']"
                            type="text"
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <Input
                            v-model="form.company.contact_name"
                            :label="trans('@company.contact_name')"
                            :error="form.errors['company.contact_name']"
                            type="text"
                        />
                    </div>
                    <div class="col-md-3 col-12">
                        <Input
                            v-model="form.company.contact_postal_code"
                            :label="trans('@company.contact_postal_code')"
                            :error="form.errors['company.contact_postal_code']"
                            placeholder="XXX-XXXX"
                            type="text"
                        />
                    </div>
                    <div class="col-md-9 col-12">
                        <Input
                            v-model="form.company.contact_address_1"
                            :label="trans('@company.contact_address_1')"
                            :error="form.errors['company.contact_address_1']"
                            type="text"
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <Input
                            v-model="form.company.contact_address_2"
                            :label="trans('@company.contact_address_2')"
                            :error="form.errors['company.contact_address_2']"
                            type="text"
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <Input
                            v-model="form.company.contact_address_3"
                            :label="trans('@company.contact_address_3')"
                            :error="form.errors['company.contact_address_3']"
                            type="text"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.contact_phone_number"
                            :label="trans('@company.contact_phone_number')"
                            :error="form.errors['company.contact_phone_number']"
                            placeholder="0999999999"
                            type="text"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.contact_email"
                            :label="trans('@company.contact_email')"
                            :error="form.errors['company.contact_email']"
                            type="email"
                            required
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.contact_email_confirmation"
                            :label="trans('@company.contact_email_confirmation')"
                            :error="form.errors['company.contact_email_confirmation']"
                            type="email"
                            required
                        />
                    </div>

                    <h4>{{ trans('@company._labels.invoice') }}</h4>
                    <div class="col-12">
                        <Input
                            v-model="form.company.invoice_title"
                            type="text"
                            :label="trans('@company.invoice_title')"
                            :error="form.errors['company.invoice_title']"
                            :help="trans('@company._labels.invoice_title_description')"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.person_in_charge"
                            type="text"
                            :label="trans('@company.person_in_charge')"
                            :error="form.errors['company.person_in_charge']"
                            :help="trans('@company._labels.person_in_charge_description')"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.invoice_pay_date"
                            type="select"
                            :options="paydayOptions"
                            :label="trans('@company.invoice_pay_date')"
                            :error="form.errors['company.invoice_pay_date']"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.invoice_format_type"
                            type="select"
                            :options="invoiceTypeOptions"
                            :label="trans('@company.invoice_format_type')"
                            :error="form.errors['company.invoice_format_type']"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.invoice_issue_date"
                            type="select"
                            :options="invoiceDateOptions"
                            :label="trans('@company.invoice_issue_date')"
                            :error="form.errors['company.invoice_issue_date']"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.invoice_delivery_method"
                            type="select"
                            :options="deliveryOptions"
                            :label="trans('@company.invoice_delivery_method')"
                            :error="form.errors['company.invoice_delivery_method']"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.credit_card_issuer"
                            type="select"
                            :options="creditCardIssuer"
                            :label="trans('@company.credit_card_issuer')"
                            :error="form.errors['company.credit_card_issuer']"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.credit_card_number"
                            type="text"
                            :label="trans('@company.credit_card_number')"
                            :error="form.errors['company.credit_card_number']"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.invoice_discount_rate"
                            type="number"
                            :label="trans('@company.invoice_discount_rate')"
                            :error="form.errors['company.invoice_discount_rate']"
                            step="0.01"
                        />
                    </div>
                    <div class="col-md-4 col-12">
                        <Input
                            v-model="form.company.invoice_commission_fee"
                            type="number"
                            :label="trans('@company.invoice_commission_fee')"
                            :error="form.errors['company.invoice_commission_fee']"
                        />
                    </div>
                    <div class="col-12">
                        <Input
                            v-model="form.company.bank_issuer"
                            type="select"
                            :options="bankAccountOptions"
                            :label="trans('@company.bank_issuer')"
                            :error="form.errors['company.bank_issuer']"
                            :help="trans('@company._labels.bank_issuer_description')"
                        />
                    </div>
                    <div class="col-md-12">
                        <Input
                            v-model="form.company.notes"
                            type="textarea"
                            rows="5"
                            :label="trans('@company.notes')"
                        />
                    </div>
                    <div class="col-12">
                        <Input
                            v-model="form.company.is_invoice_est_enabled"
                            type="switch"
                            class="d-inline me-2"
                            :label="trans('@company.is_invoice_est_enabled')"
                        />
                        <Input
                            v-model="form.company.is_invoice_nohin_enabled"
                            type="switch"
                            class="d-inline me-2"
                            :label="trans('@company.is_invoice_nohin_enabled')"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="form.processing || !form.isDirty"
                >
                    {{ trans('labels.save') }}
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    props: {
        company: {
            type: Object,
            required: true,
        },
        paydayOptions: {
            type: Array,
            required: true,
        },
        deliveryOptions: {
            type: Array,
            required: true,
        },
        invoiceTypeOptions: {
            type: Array,
            required: true,
        },
        invoiceDateOptions: {
            type: Array,
            required: true,
        },
        creditCardIssuer: {
            type: Array,
            required: true,
        },
        bankAccountOptions: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                company:  _.pick(this.company, [
                    'company_name',
                    'contact_email',
                    'department_name',
                    'position_name',
                    'person_in_charge',
                    'contact_name',
                    'contact_phone_number',
                    'contact_address_1',
                    'contact_address_2',
                    'contact_address_3',
                    'contact_postal_code',
                    'aws_usage_account_id',
                    'invoice_title',
                    'invoice_issue_date',
                    'invoice_pay_date',
                    'invoice_format_type',
                    'invoice_commission_fee',
                    'invoice_discount_rate',
                    'invoice_delivery_method',
                    'is_invoice_est_enabled',
                    'is_invoice_nohin_enabled',
                    'bank_issuer',
                    'credit_card_issuer',
                    'credit_card_number',
                    'notes',
                ])
            }),
        };
    },
    methods: {
        submit() {
            this.company.id
                ? this.form.put(this.route('admin.companies.update', this.company))
                : this.form.post(this.route('admin.companies.store'));
        },
    }
};
</script>
