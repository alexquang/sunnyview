const path = require('path');

const devServer = {
    host: '0.0.0.0',
};
if (process.env.APP_ENV == 'local' && process.env.APP_SCHEME == 'https') {
    const fs = require('fs');

    devServer.https = {
        key: fs.readFileSync(process.env.SSL_LOCAL_KEY_PATH).toString(),
        cert: fs.readFileSync(process.env.SSL_LOCAL_CERT_PATH).toString(),
    };
}

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            // TODO: remove this alias
            '@@path': path.resolve('public'),
            'ziggyvue': path.resolve('vendor/tightenco/ziggy/dist/vue'),
        },
    },
    devServer,
    output: {
        chunkFilename: 'js/chunks/[name].js',
        filename: '[name].js',
    },
};
