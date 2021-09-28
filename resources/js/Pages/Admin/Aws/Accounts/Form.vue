<template>
    <div class="row gy-3">
        <form @submit.prevent="submit">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row gy-3">
                        <h4>{{ trans('@aws.account._labels.info_account') }}</h4>
                        <Input
                            :label="trans('@aws.account.external_id')"
                            :value="form.aws.account.external_id"
                            readonly
                        />
                        <Input
                            v-model="form.aws.account.iam_role_name"
                            :error="form.errors['aws.account.iam_role_name']"
                            type="text"
                            required
                            autofocus
                        >
                            <template #label>
                                {{ trans('@aws.account.iam_role_name') }}
                                <a
                                    :href="iamRoleCreationLink"
                                    target="_"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-xs"
                                        viewBox="0 0 20 20"
                                        fill="#2361ce"
                                    >
                                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                    </svg>
                                </a>
                            </template>
                        </Input>
                        <Input
                            v-model="form.aws.account.account_id"
                            type="text"
                            :label="trans('@aws.account.account_id')"
                            :error="form.errors['aws.account.account_id']"
                            required
                        />
                        <Input
                            v-model="form.aws.account.account_name"
                            type="text"
                            :label="trans('@aws.account.account_name')"
                            :error="form.errors['aws.account.account_name']"
                            required
                        />
                        <div class="d-block">
                            <Input
                                v-model="form.aws.account.is_reseller"
                                type="switch"
                                :label="trans('@aws.account._labels.make_reseller')"
                            />
                        </div>
                        <template v-if="form.aws.account.is_reseller">
                            <h4>{{ trans('@aws.account._labels.info_s3') }}</h4>
                            <Input
                                v-model="form.aws.account.s3_bucket_dbr"
                                type="text"
                                :label="trans('@aws.account.s3_bucket_dbr')"
                                :error="form.errors['aws.account.s3_bucket_dbr']"
                                required
                            />
                            <Input
                                v-model="form.aws.account.s3_bucket_cur"
                                type="text"
                                :label="trans('@aws.account.s3_bucket_cur')"
                                :error="form.errors['aws.account.s3_bucket_cur']"
                                required
                            />
                        </template>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button
                    class="btn btn-primary"
                    type="submit"
                    :disabled="!form.isDirty || form.processing"
                >
                    {{ trans('labels.save') }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    props: {
        account: {
            type: Object,
            required: true,
        },
        iamRoleCreationLink: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            form: this.$inertia.form(
                _.set({}, 'aws.account', _.pick(this.account, [
                    'account_id',
                    'account_name',
                    'external_id',
                    'iam_role_name',
                    'is_reseller',
                    's3_bucket_cur',
                    's3_bucket_dbr',
                ]))
            ),
        };
    },
    methods: {
        submit() {
            this.account.created_at
                ? this.form.put(this.route('admin.aws.accounts.update', this.account.account_id))
                : this.form.post(this.route('admin.aws.accounts.store'));
        },
    }
};
</script>
