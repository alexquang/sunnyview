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
            <div class="row gx-5 gy-3">
                <div
                    v-for="link in links"
                    :key="link.href"
                    class="col col-md-12 col-lg-6 col-xl-6 col-xxl-4"
                >
                    <div class="form-group justify-content-between align-items-center">
                        <div class="position-relative">
                            <div class="dot" />
                            <label
                                class="mb-0 mt-0 mls-20 form-label"
                                for="radio2"
                            >{{ trans(`routes.${link.href}`) }}</label>
                        </div>
                        <div>
                            <Link
                                :href="route(link.href)"
                                class="btns btn-default-outline d-flex-center"
                            >
                                {{ trans('labels.setting') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Link
    },
    data() {
        return {
            links: [
                {href: 'frontend.groups.index', text: this.trans('labels.group')},
                {href: 'frontend.users.index', text: this.trans('labels.user')},
                {href: 'frontend.projects.index', text: this.trans('labels.project')},
                {href: 'frontend.aws.regions.index', text: this.trans('labels.nav.aws_region')},
                {href: 'frontend.aws.amis.index', text: this.trans('labels.nav.aws_ami')},
                {href: 'frontend.ec2.instances.types.index', text: this.trans('labels.nav.ec2_instance_type')},
                {href: 'frontend.aws.eips.index', text: this.trans('labels.nav.aws_eip')},
                {href: 'frontend.aws.cloudwatches.rules.index', text: this.trans('labels.nav.aws_cloudwatch_rule')},
                {href: 'frontend.aws.lifecycles.index', text: this.trans('labels.nav.aws_lifecycle')},
                {href: 'frontend.aws.accounts.index', text: this.trans('labels.nav.aws_account')},
            ],
            tooltip: '各Sunny ViewでAWSリソースを管理するための設定を行うことができます。',
        };
    },
};
</script>
<style scoped>
.dot {
    background-color: #71b711;
    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
}
</style>