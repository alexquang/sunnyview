<template>
    <div
        id="main"
        class="container-fluid px-0 main"
    >
        <header
            class="container-fluid login-header"
            style="position: absolute; z-index: 100;"
        >
            <div class="container-fluid">
                <div class="logo col-sm">
                    <Link :href="route('frontend.dashboard')">
                        <img
                            src="/images/sunny-view-white.svg"
                            alt="Sunny View"
                            class="img__logo"
                        >
                    </Link>
                </div>
                <ul class="noselect nav justify-content-end align-items-center blank_home nav-pills px-0">
                    <li class="nav-item">
                        <LogoutButton
                            v-if="$page.props.user"
                            action="frontend.logout"
                            class="btns btn-default shadow d-flex-center"
                        />
                        <a
                            v-else
                            class="btns btn-default shadow d-flex-center"
                            href="https://www.sunnycloud.jp/"
                            target="_blank"
                        >{{ trans('@auth.user._labels.service_details') }}
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <div id="page-content">
            <div class="wrapper_auth justify-content-between align-items-center flex-column d-flex">
                <div>
                    <div id="content__auth">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        <div id="footer">
            <footer>
                <div class="container-footer mt-4 pt-4">
                    <div class="col-12">
                        <ul class="nav justify-content-center mb-4">
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/about-sunnycloud/"
                                >SunnyCloudについて</a>
                            </li>
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/category/development-case/"
                                >開発事例</a>
                            </li>
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/webinar/"
                                >セミナー・相談会</a>
                            </li>
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/category/news/"
                                >お知らせ</a>
                            </li>
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/category/column/"
                                >コラム</a>
                            </li>
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/faq/"
                                >よくあるご質問</a>
                            </li>
                            <li class="nav-item border-right">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/operating-company/"
                                >運営会社</a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    href="https://www.sunnycloud.jp/contact-us/"
                                >お問合せ</a>
                            </li>
                        </ul>
                        <p class="text-center text-white">
                            &copy; IDS Co., LTD.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import LogoutButton from '@/Shared/Forms/LogoutButton';
export default {
    components: {
        Link,
        LogoutButton,
    }
};
</script>
