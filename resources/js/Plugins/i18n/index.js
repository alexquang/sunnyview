export default {
    install: (app, options) => {
        const _translations = options[window._locale || 'ja'];

        app.mixin({
            methods: {
                trans(key, replace) {
                    if (key.startsWith('@')) {
                        key = key.replace(/^(@)/, 'validation.attributes.');
                    }

                    let translated = _.get(_translations, key) || key;

                    _.forEach(replace, (value, key) => {
                        translated = translated.replace(':' + key, value);
                    });

                    return translated;
                }
            },
        });
    }
};