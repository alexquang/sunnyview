<template>
    <div
        v-if="['switch', 'checkbox', 'radio'].includes(type)"
        class="form-check"
        :class="[{'form-switch': type == 'switch'}, $attrs.class]"
    >
        <label class="form-check-label user-select-none">
            <template
                v-if="label"
                class="inline-block pb-1"
            >{{ label }}
            </template>
            <input
                v-model="model"
                v-bind="$attrs"
                :type="(type == 'switch' || type == 'checkbox') ? 'checkbox' : 'radio'"
                class="form-check-input"
            >
        </label>
    </div>
    <label
        v-else
        class="d-block user-select-none"
    >
        <template v-if="$slots.label || label">
            <slot name="label">{{ label }}</slot>
            <span
                v-if="$attrs.hasOwnProperty('required')"
                class="required-asterisk"
            >*</span>
        </template>

        <div :class="{'input-group': $slots.prepend || $slots.append, 'has-validation': !!error}">
            <slot
                v-if="$slots.prepend"
                name="prepend"
            />

            <textarea
                v-if="type == 'textarea'"
                v-model="model"
                v-bind="$attrs"
                :class="classes"
            />
            <select
                v-else-if="type == 'select'"
                v-model="model"
                v-bind="$attrs"
                :class="classes"
            >
                <option
                    v-if="$attrs.placeholder"
                    value=""
                    disabled
                    selected
                >{{ $attrs.placeholder }}</option>
                <option
                    v-for="option in options"
                    :key="option.key"
                    :value="option.key"
                    :disabled="option.disabled"
                    :selected="option.key == modelValue"
                >{{ option.name }}
                </option>
            </select>

            <input
                v-else
                v-model.trim="model"
                v-bind="$attrs"
                :type="type"
                :class="classes"
            >
            <slot
                v-if="$slots.append"
                name="append"
            />
            <div
                v-if="error"
                class="invalid-feedback"
            >{{ error }}</div>
        </div>
        <div>
            <small
                v-if="help"
                class="form-text text-muted"
            >{{ help }}</small>
        </div>
    </label>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        type: {
            type: String,
            default: 'text',
        },
        label: {
            type: String,
            default: '',
        },
        modelValue: {
            type: null,
            default: '',
        },
        error: {
            type: String,
            default: null,
        },
        help: {
            type: String,
            default: null,
        },
        options: {
            type: Array,
            default() {
                return [];
            },
        },
    },
    emits: ['update:modelValue'],
    computed: {
        model: {
            get() {
                // if v-model is not passed into element, try to detect `checked` status and return it
                // TODO: retest this
                if (!this.modelValue) {
                    if (['switch', 'checkbox', 'radio'].includes(this.type)) {
                        return this.$attrs.checked;
                    }

                    // if (this.type == 'select') {
                    //     return _.get(_.head(this.options), 'key');
                    // }

                    return this.$attrs.value;
                }

                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            }
        },
        classes() {
            return {
                'form-select': this.type == 'select',
                'form-control': this.type != 'select',
                'is-invalid': !!this.error,
            };
        },
    },
    mounted() {
        this.$nextTick(() => {
            if (this.type == 'select' && !this.modelValue) {
                this.$emit('update:modelValue', _.get(_.head(this.options), 'key'));
            }
        });
    },
};
</script>
<style scoped>
    label {
        font-weight: 400;
        margin-bottom: 0;
        position: relative;
    }
    .form-select {
        padding-right: 2rem;
    }
    .form-check:not(.form-switch) .form-check-input {
        width: 1.25em;
        height: 1.25em;
    }
    .form-control::placeholder {
        opacity: 0.5;
    }
    label > .required-asterisk {
        color: red;
        font-weight: bold;
        margin-left: 3px;
        font-size: 1.2em;
        position: absolute;
    }
</style>