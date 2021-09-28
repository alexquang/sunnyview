<template>
    <div
        :id="id"
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modal-default"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header user-select-none">
                    <h2 class="h6 modal-title">
                        <slot name="header" />
                    </h2>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    />
                </div>
                <div class="modal-body">
                    <slot name="body" />
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-gray-300 text-gray ms-auto"
                        data-bs-dismiss="modal"
                    >
                        {{ trans('labels.cancel') }}
                    </button>
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Modal } from 'bootstrap';

export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        processing: {
            type: Boolean,
            default: false,
        },
        id: {
            type: String,
            default: 'default-modal'
        }
    },
    emits: ['close'],
    data () {
        return {
            bsModal: null,
            isMounted: false,
        };
    },
    watch: {
        show: {
            // immediate: true,
            handler: function(show) {
                if (show) {
                    this.bsModal && this.bsModal.show();
                } else {
                    this.bsModal && this.bsModal.hide();
                }
            }
        }
    },
    mounted () {
        const modal = document.getElementById(this.id);

        modal.addEventListener('hide.bs.modal', (e) => {
            if (this.processing) {
                e.preventDefault();

                return;
            }

            setTimeout(() => {
                this.$emit('close');
            }, 500);
        });

        this.bsModal = new Modal(modal);

        this.isMounted = true;
    },
    methods: {
        hide() {
            this.bsModal.hide();
        }
    }
};
</script>
