<template>
    <LoginLayout>
        <div
            class="container-common m-auto box-shadow"
            style="width: 700px;"
        >
            <form
                id="frmConfirmLogin"
                class="mb-0"
            >
                <h1 class="text-center font-24 fw-bold mbs-30">
                    {{ trans(`routes.${route().current()}`) }}
                </h1>
                <p class="text-center mbs-20">
                    AWSアカウントを選択してください。
                </p>
                <div
                    class="form-group-user mbs-10 d-flex align-items-center pys-10"
                    style="height: auto !important;"
                >
                    <input
                        id="radio-{$company.awsid}"
                        type="radio"
                        name="sv_awsid"
                        value="{$company.awsid}"
                        data-awsid="{$smarty.session.authInfo._rootInfo.costacctid}"
                    >
                    <label
                        class="mb-0 form-label fw-bold"
                        style="width: 150px"
                        for="radio-{$company.awsid}"
                    >{$company.awsid}</label>
                    <label
                        class="mb-0 form-label fw-bold"
                        style="width: 233px"
                        for="radio-{$company.awsid}"
                    >{$company.name}</label>
                    <label
                        class="mb-0 form-label fw-bold"
                        style="width: 233px"
                        for="radio-{$company.awsid}"
                    >{$company.company}</label>
                </div>
                <div class="form-group mts-30 d-block text-center">
                    <button
                        type="button"
                        class="btns btn-default shadow width-200 btn-confirm-login"
                    >
                        ログイン
                    </button>
                </div>
            </form>
        </div>
    </LoginLayout>
</template>

<script>
import LoginLayout from './LoginLayout';

export default {
    components: {
        LoginLayout,
    }
};
</script>
