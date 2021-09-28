<template>
    <form>
        <Input
            type="select"
            :options="selectOptions"
            error="this is error"
            multiple
        >
            <template #append>
                <button class="btn btn-primary">
                    Test
                </button>
            </template>

            <p>Your Input:</p>
            <pre>{{ form }}</pre>
        </Input>
    </form>
</template>

<script>

import Input from '@/Shared/Forms/Input';

export default {
    components: {
        Input,
    },
    data() {
        return {
            form: {
                email: 'abc@example.com',
                textarea: 'default textarea value',
                select: '',
                input: 'default input value',
                number: 'default number value',
                password: 'default password value',
                checkbox: true,
                checkboxes: ['checkbox_1'],
                radio: 'radio_1',
                switch: true,
                switches: ['switch_1'],
            },
            selectOptions: [
                {key: '1', name: 'Number one'},
                {key: '2', name: 'Number two'},
                {key: '3', name: 'Number three'},
            ],
        };
    },
};
</script>
