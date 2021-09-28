<template>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div
                class="row justify-content-center form-bg-image"
                data-background-lg="/assets/img/illustrations/signin.svg"
            >
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h3">
                                {{ trans('@auth.user._labels.console_login_title') }}
                            </h1>
                        </div>
                        <IMessage />
                        <form
                            class="mt-3"
                            @submit.prevent="submit"
                        >
                            <div class="row gy-3">
                                <Input
                                    v-model="form.email"
                                    type="email"
                                    :label="trans('@auth.user.email')"
                                    autofocus
                                    required
                                >
                                    <template #prepend>
                                        <span
                                            id="basic-addon1"
                                            class="input-group-text"
                                            v-html="icons['mail']"
                                        />
                                    </template>
                                </Input>
                                <Input
                                    v-model="form.password"
                                    type="password"
                                    :label="trans('@auth.user.password')"
                                    required
                                    autocomplete="current-password"
                                >
                                    <template #prepend>
                                        <span
                                            id="basic-addon1"
                                            class="input-group-text"
                                            v-html="icons['lock-closed']"
                                        />
                                    </template>
                                </Input>
                                <div class="d-grid">
                                    <button
                                        type="submit"
                                        class="btn btn-gray-800"
                                        :disabled="form.processing"
                                    >
                                        {{ trans('@auth.user._labels.login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import IMessage from '@/Shared/IMessage';
import Input from '@/Shared/Forms/Input';

export default {
    components: {
        IMessage,
        Input
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
            this.form.post(this.route('admin.login'), {
                onFinish: () => {
                    this.form.reset('password');
                },
            });
        }
    }
};
</script>
