module.exports = {
    'env': {
        'node': true,
        'browser': true,
        'es2021': true
    },
    'extends': [
        'eslint:recommended',
        'plugin:vue/vue3-recommended'
    ],
    'parserOptions': {
        'ecmaVersion': 12,
        'sourceType': 'module'
    },
    'plugins': [
        'vue',
    ],
    'globals': {
        '_': 'readonly',
        'axios': 'readonly',
    },
    'rules': {
        'indent': [
            'error',
            4
        ],
        'vue/no-v-html': ['off'],
        'vue/html-indent': ['error', 4, {
            'attribute': 1,
            'baseIndent': 1,
            'closeBracket': 0,
            'alignAttributesVertically': true,
            'ignores': []
        }],
        'linebreak-style': [
            'error',
            'unix'
        ],
        'quotes': [
            'error',
            'single'
        ],
        'semi': [
            'error',
            'always'
        ],
    }
};
