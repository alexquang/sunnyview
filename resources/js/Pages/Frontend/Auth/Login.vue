<template>
    <LoginLayout>
        <div class="container-common width-500 m-auto box-shadow">
            <h1 class="text-center font-24 fw-bold mbs-30">
                {{ trans('@auth.user._labels.login') }}
            </h1>
            <IMessage />
            <form
                id="frmLogin"
                class="mb-0"
                @submit.prevent="submit"
            >
                <div class="form-group mbs-20 d-block">
                    <label
                        for="sv_email"
                        class="form-label minw-200"
                    >{{ trans('labels.email') }}</label>
                    <input
                        id="sv_email"
                        v-model="form.email"
                        type="email"
                        name="sv_email"
                        class="form-control mts-10 w-f-100"
                        autocomplete="email"
                        :placeholder="trans('messages.input_remind')"
                        required
                        autofocus
                    >
                </div>
                <div class="form-group mts-30 mbs-10 d-block">
                    <label
                        for="sv_password"
                        class="form-label minw-200"
                    >{{ trans('labels.password') }}</label>
                    <input
                        id="sv_password"
                        v-model="form.password"
                        type="password"
                        name="sv_password"
                        class="form-control mts-10 w-f-100"
                        autocomplete="current-password"
                        :placeholder="trans('messages.input_remind')"
                        required
                    >
                </div>
                <div class="form-group mts-10 mbs-20 d-block">
                    <a
                        href="/password/forgot"
                        class="btns btn-links text-blue-light"
                    >{{ trans('@auth.user._labels.forgot_password') }}</a>
                </div>
                <div class="form-group mts-30 d-block text-center">
                    <button
                        type="submit"
                        class="btns btn-default shadow width-200 btn-block btn-login"
                        :disabled="form.processing"
                    >
                        {{ trans('@auth.user._labels.login') }}
                    </button>
                </div>
            </form>
        </div>
    </LoginLayout>
</template>

<script>
import IMessage from '@/Shared/IMessage';
import LoginLayout from './LoginLayout';

export default {
    components: {
        IMessage,
        LoginLayout,
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false,
            }),
            icons: {
                'mail': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                `,
                'lock-closed': `
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                `,
            }
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('frontend.login'), {
                onFinish: () => {
                    this.form.reset('password');
                },
            });
        }
    }
};
</script>
